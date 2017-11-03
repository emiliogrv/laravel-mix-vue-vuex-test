<template>
    <div>
        <div class="nav justify-content-center mb-3">
            <a class="nav-link btn btn-success" href="/api/v1/excel/export">Exportar todo a excel</a>
        </div>

        <section id="table-container">
            <div v-if="excelRows.length && !loading" v-cloak>
                <table-excel v-model="excelRows" :errors="errors" @update="updatedValue" :action-column="true" @delete="deleteItem"></table-excel>

            </div>

            <div id="load-container" class="text-center" v-if="!excelRows.length && !loading" v-cloak>
                <h2>Sin registros para mostrar</h2>
            </div>

            <div v-if="loading" v-cloak>
                <div class="text-center">
                    <p>
                        <i class="fa fa-spinner fa-spin fa-5x fa-fw align-middle"></i>
                    </p>
                </div>
            </div>
        </section>

        <div class="col">
            <hr>
            <paginate ref="paginate" :page-count="pagination.last_page" :click-handler="paginateSet" prev-text="«" next-text="»" container-class="pagination  justify-content-center" page-class="page-item" page-link-class="page-link" prev-class="page-item" prev-link-class="page-link" next-class="page-item" next-link-class="page-link" :initial-page="pagination.current_page - 1" /></paginate>
        </div>
    </div>
</template>

<script>
    import Paginate from "vuejs-paginate";
    import URI from "urijs";
    import store from "../../store";
    import handleHTTPErrors from "../../js/handle-HTTP-errors";
    import TableExcel from "./TableList";

    export default {
      data() {
        return {
          excelRows: [],
          lastUpdated: {},
          errors: [],
          pagination: {
            current_page: 1,
            last_page: 1
          },
          loading: true
        };
      },
      mounted: function() {
        let _vm = this;
        store.commit("errors", []);
        store.commit("success", false);

        _vm.populate();

        window.onpopstate = function(event) {
          let page = 1;
          let uri = URI(window.location.href);
          if (uri.hasSearch("page")) {
            page = uri.search(true).page;
          }
          _vm.populate();
        };
      },
      watch: {
        errors: function(val) {
          setTimeout(function() {
            $('[data-toggle="tooltip"]').tooltip();
          }, 500);
        },
        excelRows: function(val) {
          setTimeout(function() {
            $('[data-toggle="tooltip"]').tooltip();
          }, 500);
        }
      },
      components: {
        paginate: Paginate,
        tableExcel: TableExcel
      },
      methods: {
        populate: function() {
          this.loading = true;
          this._populate("/api/v1/excel" + window.location.search, null);
        },
        _populate: function(url) {
          let _vm = this;
          _vm.errors = [];
          store.commit("errors", []);

          $.ajax({
            url: url,
            method: "get",
            contentType: "application/json",
            success: function(data) {
              _vm.excelRows = data.data;
              _vm.pagination = data.meta;

              if (_vm.$refs.paginate) {
                _vm.$refs.paginate.selected = _vm.pagination.current_page - 1;
              }
            },
            error: function(jqXHR) {
              let errors = handleHTTPErrors(jqXHR);
              store.commit("errors", errors.catched);
              _vm.errors = errors.exclude;
            },
            complete: function() {
              _vm.loading = false;
            }
          });
        },
        updatedValue: function(input) {
          this.lastUpdated = input;
          this._submit();
        },
        deleteItem: function(id) {
          let _vm = this;
          _vm.errors = [];
          store.commit("errors", []);
          store.commit("success", false);
          $(".tooltip").hide();

          $.ajax({
            url: "/api/v1/excel/" + id,
            method: "delete",
            contentType: "application/json",
            success: function(data) {
              store.commit("success", true);
              _vm.populate();
            },
            error: function(jqXHR) {
              let errors = handleHTTPErrors(jqXHR);
              store.commit("errors", errors.catched);
              _vm.errors = errors.exclude;
            }
          });
        },
        _submit: function() {
          let _vm = this;
          _vm.errors = [];
          store.commit("errors", []);
          store.commit("success", false);
          let data = {};
          data[_vm.lastUpdated.item] = _vm.lastUpdated.value;

          $.ajax({
            url: "/api/v1/excel/" + _vm.lastUpdated.id,
            data: JSON.stringify(data),
            method: "put",
            dataType: "json",
            contentType: "application/json",
            success: function(data) {
              store.commit("success", true);
            },
            error: function(jqXHR) {
              let errors = handleHTTPErrors(jqXHR, {
                excludeKey: /\w./i,
                addKeyPrefix: _vm.lastUpdated.index
              });
              errors.catched.push("Cambios no guardados.");
              store.commit("errors", errors.catched);
              _vm.errors = errors.exclude;
            }
          });
        },
        paginateSet: function(page) {
          let url = URI(window.location.href).setSearch({
            page: page
          });
          history.pushState(null, null, url);
          this.populate();
        }
      }
    };
</script>
