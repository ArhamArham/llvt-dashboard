<template>
  <div class="w-full px-3 mb-4">
    <label
      class="form-label"
      :for="id"
      v-text="label"
    ></label>
    <div class="form-switch mt-2">
      <input
        class="form-check-input"
        type="checkbox"
        :id="id"
        :name="name"
        v-bind="$attrs"
        :checked="value"
        @change="onChange"/>
    </div>
    <span
      v-if="hasError"
      class="font-medium tracking-wide text-red-500 text-xs"
      v-text="getError"
    ></span>
  </div>
</template>

<script>
export default {
  name: "Checkbox",
  props: {
    label: {
      type: String,
      required: true
    },
    value: {
      type: Boolean
    }
  },
  computed: {
    id() {
      return this.label
        .replaceAll(' ', '-')
        .toLowerCase()
    },
    name() {
      return this.label
        .replaceAll(' ', '_')
        .toLowerCase()
    },
    hasError() {
      return this.error?.length > 0;
    },
    getError() {
      return this.hasError && this.error[0];
    }
  },
  methods: {
    onChange(e) {
      this.$emit('input', e.target.checked)
    }
  }
}
</script>

<style scoped>

</style>