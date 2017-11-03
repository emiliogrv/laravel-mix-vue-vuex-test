<template>
    <div>
        <section id="form-container" class="container">
            <div class="row">
                <div class="col">
                    <div class="nav justify-content-between">
                        <label for="input-file">Cargar Excel
                            <span class="badge badge-success" data-toggle="tooltip" data-placement="bottom" data-html="true" title="
                                <p>El archivo debe ser de formato .xls o .xlsx</p>
                                <p>El archivo no debe superar las 200 filas o 40kb</p>
                                <p>Todas las columnas deben tener el nombre del tipo de dato al que pertenecen (Albarán, CP, etc.) antes de la información y en la misma fila</p>
                                <p>Todas los nombres de columnas (Albarán, CP, etc.) no deben contener caracteres especiales como tildes, puntos o comas</p>
                                <p>Las columnas obligatorias son: Albarán, Destinatario, Dirección, CP, Provincia, Teléfono, Fecha</p>
                                <p>Las columnas opcionales son: Población, Observaciones</p>">!</span>
                        </label>

                        <a href="/docs/datos.xls">Documento de ejemplo</a>
                    </div>

                    <form class="form-inline justify-content-between">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">@</div>
                                <input type="file" class="form-control" id="input-file" @change="handleFile">
                            </div>
                        </div>

                        <a href="#" class="btn btn-primary" @click.prevent="submit" v-if="excelRows.length && !processing" v-cloak>Guardar</a>
                        <a class="btn btn-primary disabled" v-if="processing" disabled="disabled" v-cloak>
                            <i class="fa fa-spinner fa-spin fa-fw"></i> Procesando
                        </a>
                    </form>
                </div>
            </div>
        </section>

        <section id="table-container">
            <div v-if="excelRows.length && !loading" v-cloak>
                <table-excel v-model="excelRows" :errors="errors"></table-excel>
            </div>

            <div id="load-container" class="text-center" v-if="!excelRows.length && !loading">
                <label class="btn btn-primary" for="input-file">Cargar Excel</label>
            </div>

            <div v-if="loading" v-cloak>
                <div class="text-center">
                    <p>
                        <i class="fa fa-spinner fa-spin fa-5x fa-fw"></i>
                    </p>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    import XLSX from "xlsx";
    import store from "../../store";
    import handleHTTPErrors from "../../js/handle-HTTP-errors";
    import TableExcel from "./TableList";

    export default {
      data() {
        return {
          excelRows: [],
          errors: [],
          loading: false,
          processing: false
        };
      },
      mounted() {
        $('[data-toggle="tooltip"]').tooltip();
        store.commit("errors", []);
        store.commit("success", false);
      },
      watch: {
        errors(val) {
          setTimeout(function() {
            $('[data-toggle="tooltip"]').tooltip();
          }, 500);
        }
      },
      components: {
        tableExcel: TableExcel
      },
      methods: {
        submit() {
          let _vm = this;
          _vm.errors = [];
          store.commit("errors", []);
          store.commit("success", false);
          _vm.processing = true;

          $.ajax({
            url: "/api/v1/excel",
            data: JSON.stringify({
              data: _vm.excelRows
            }),
            method: "post",
            dataType: "json",
            contentType: "application/json",
            success: function(data) {
              store.commit("success", true);
              _vm.excelRows = [];
              $("#input-file").val("");
            },
            error(jqXHR) {
              let errors = handleHTTPErrors(jqXHR, {
                excludeKey: /data.\d./i,
                removeKeyPrefix: "data."
              });
              store.commit("errors", errors.catched);
              _vm.errors = errors.exclude;
            },
            complete: function() {
              _vm.processing = false;
            }
          });
        },
        handleFile(e) {
          let _vm = this;
          _vm.errors = [];
          store.commit("errors", []);
          store.commit("success", false);
          _vm.loading = true;

          let rABS =
            typeof FileReader !== " undefined " &&
            (FileReader.prototype || {}).readAsBinaryString;
          let file = e.target.files[0];
          let reader = new FileReader();

          setTimeout(function() {
            reader.onload = function(e) {
              try {
                let data = e.target.result;
                if (!rABS) {
                  data = new Uint8Array(data);
                }
                let workbook = XLSX.read(data, {
                  type: rABS ? "binary" : "array"
                });
                let firstWorksheet = _vm.setHeaderToLower(
                  workbook.Sheets[workbook.SheetNames[0]]
                );
                firstWorksheet = XLSX.utils.sheet_to_json(firstWorksheet);

                if (firstWorksheet.length > 200) {
                  store.commit("errors", [
                    "¡ERROR! El documento no debe tener más de 200 filas."
                  ]);
                } else {
                  _vm.excelRows = firstWorksheet;
                }
                _vm.loading = false;
              } catch (e) {
                _vm.loading = false;
                store.commit("errors", [
                  "¡ERROR! No ha sido posible cargar el archivo deseado. Por favor verifique que sea de los formatos aceptados (.xls o .xlsx)"
                ]);
              }
            };

            if (file) {
              if (file.size <= 40000) {
                if (rABS) {
                  reader.readAsBinaryString(file);
                } else {
                  reader.readAsArrayBuffer(file);
                }
              } else {
                _vm.loading = false;
                _vm.errors.push(
                  "¡ERROR! No ha sido posible cargar el archivo deseado por ser demasiado pesado"
                );
              }
            } else {
              _vm.loading = false;
            }
          }, 250);
        },
        setHeaderToLower(sheet) {
          let range = XLSX.utils.decode_range(sheet["!ref"]);
          let cell;

          for (let i = 0; i <= range.e.c; ++i) {
            cell = XLSX.utils.encode_col(i) + (range.s.r + 1).toString();
            if (sheet[cell]) {
              sheet[cell].v = sheet[cell].v.toLowerCase().replace(/[^\w]/gi, "");

              if (sheet[cell].w) {
                sheet[cell].w = sheet[cell].w.toLowerCase().replace(/[^\w]/gi, "");
              } else {
                sheet[cell].h = sheet[cell].h.toLowerCase().replace(/[^\w]/gi, "");
              }
            }
          }

          return sheet;
        }
      }
    };
</script>
