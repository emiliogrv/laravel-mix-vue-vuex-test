<template>
    <div class="input-group">
        <input :type="type" class="form-control" :class="{'is-invalid': withError}" :value="value" @blur="updatedValue($event.target.value)">
        <div v-if="withError" class="input-group-addon" data-toggle="tooltip" data-placement="top" :title="error">
            <span class="badge badge-danger">!</span>
        </div>
    </div>
</template>

<script>
    export default {
      props: {
        value: {},
        index: {
          type: Number,
          required: true
        },
        item: {
          type: String,
          required: true
        },
        type: {
          type: String,
          default: "text"
        },
        error: {
          type: String
        }
      },
      methods: {
        updatedValue: function(value) {
          if (this.value != value) {
            this.$emit("input", value);
            this.$emit("update", {
              value: value,
              item: this.item,
              index: this.index
            });
          }
        }
      },
      computed: {
        withError: function() {
          return this.error ? true : false;
        }
      }
    };
</script>
