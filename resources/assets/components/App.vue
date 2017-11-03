<template>
    <div>
        <nav class="mb-3">
            <ul class="nav justify-content-center">
                <router-link class="nav-item" tag="li" :to="{name: 'home'}" active-class="active" exact>
                    <a class="nav-link">Inicio</a>
                </router-link>
                <router-link class="nav-item" tag="li" :to="{name: 'list'}" active-class="active">
                    <a class="nav-link">Listado</a>
                </router-link>
            </ul>
        </nav>

        <div style="height: 100px">
            <ul v-if="errors.length" class="alert alert-danger" v-cloak style="list-style-type: none; max-height: 100px; overflow-y: auto;">
                <li v-for="error in errors">{{ error }}</li>
            </ul>
            <ul v-if="success" class="alert alert-success" v-cloak style="list-style-type: none">
                <li>Operación realizada con éxito</li>
            </ul>
        </div>

        <router-view></router-view>
    </div>
</template>

<script>
    import store from "../store";

    export default {
      computed: {
        errors: () => store.state.errors,
        success: () => store.state.success
      }
    };
</script>

<style >
    .is-invalid {
      color: red;
    }

    form {
      width: 100%;
    }

    html,
    body {
      min-width: 320px;
    }

    [v-cloak] {
      display: none;
    }

    #form-container {
      background-color: rgba(204, 204, 204, 0.22);
      border: 5px gray dashed;
      margin-bottom: 14px;
      margin-top: 5px;
      border-radius: 10px;
    }

    #table-container {
      height: calc(78vh - 100px);
      width: 98%;
      overflow: auto;
      margin: 0 auto;
      min-height: 650px;
    }

    #load-container {
      margin-top: 10vh;
    }
</style>
