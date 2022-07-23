<template>
  <div
    class="w-full px-3 mb-4"
    :class="{ ['md:' + md]: md  }"
  >
    <label
      class="form-label"
      :for="id"
      v-text="`Select ${label}`"
    ></label>
    <div class="flex items-center">
      <v-select
        :id="id"
        class="w-full"
        :class="{'vs--error': hasError}"
        :reduce="option => option.id"
        :options="options"
        :label="nameKey"
        placeholder="Select"
        :value="value"
        v-bind="$attrs"
        @input="onInput"
      ></v-select>
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
  name: "Select",
  inheritAttrs: false,
  props: {
    label: {
      type: String,
      required: true
    },
    value: {},
    nameKey: {
      default: 'name'
    },
    options: {
      type: Array,
      required: true
    },
    error: {
      type: Array,
    },
    md: {
      type: String
    }
  },
  computed: {
    id() {
      return this.label
        .replaceAll(' ', '-')
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
    onInput(e) {
      this.$emit('input', e)
    }
  }
}
</script>

<style scoped>

</style>