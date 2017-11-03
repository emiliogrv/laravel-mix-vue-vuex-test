<template>
    <table style="min-width: 1500px;">
        <thead>
            <tr>
                <th style="min-width: 160px;">ALBARÁN</th>
                <th>DESTINATARIO</th>
                <th>DIRECCIÓN</th>
                <th>POBLACIÓN</th>
                <th style="min-width: 120px;">CP</th>
                <th>PROVINCIA</th>
                <th style="min-width: 160px;">TELÉFONO</th>
                <th>OBSERVACIONES</th>
                <th>FECHA</th>
                <th v-if="actionColumn" style="width: 80px;">ACCIONES</th>
            </tr>
        </thead>

        <tbody>
            <tr v-for="(item, indexER) in value">
                <td>
                    <input-item :error="errors[indexER + '.albaran']" :index="indexER" item="albaran" v-model="item.albaran" @update="updatedValue" />
                </td>
                <td>
                    <input-item :error="errors[indexER + '.destinatario']" :index="indexER" item="destinatario" v-model="item.destinatario" @update="updatedValue" />
                </td>
                <td>
                    <input-item :error="errors[indexER + '.direccion']" :index="indexER" item="direccion" v-model="item.direccion" @update="updatedValue" />
                </td>
                <td>
                    <input-item :error="errors[indexER + '.poblacion']" :index="indexER" item="poblacion" v-model="item.poblacion" @update="updatedValue" />
                </td>
                <td>
                    <input-item :error="errors[indexER + '.cp']" :index="indexER" item="cp" v-model="item.cp" @update="updatedValue" />
                </td>
                <td>
                    <input-item :error="errors[indexER + '.provincia']" :index="indexER" item="provincia" v-model="item.provincia" @update="updatedValue" />
                </td>
                <td>
                    <input-item :error="errors[indexER + '.telefono']" :index="indexER" item="telefono" v-model="item.telefono" @update="updatedValue" />
                </td>
                <td>
                    <input-item :error="errors[indexER + '.observaciones']" :index="indexER" item="observaciones" v-model="item.observaciones" @update="updatedValue" />
                </td>
                <td>
                    <input-item :error="errors[indexER + '.fecha']" :index="indexER" item="fecha" v-model="item.fecha" @update="updatedValue" />
                </td>
                <td v-if="actionColumn" class="nav justify-content-center">
                    <a href="#" @click.prevent="deleteItem(item.id)" data-toggle="tooltip" data-placement="top" title="Eliminar">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </a>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
    import InputItem from "./InputItem";

    export default {
      props: {
        value: {},
        errors: {},
        actionColumn: {
          type: Boolean,
          default: false
        }
      },
      components: {
        inputItem: InputItem
      },
      methods: {
        updatedValue: function(input) {
          input.id = this.value[input.index].id;
          this.$emit("update", input);
        },
        deleteItem: function(id) {
          if (confirm("¿Está segur@ de continuar?.")) {
            this.$emit("delete", id);
          }
        }
      }
    };
</script>
