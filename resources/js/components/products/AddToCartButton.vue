<template>
  <button
    @click.prevent="addToCart"
    :class="canAddToCart"
    type="button"
    name="add-to-cart"
    value="add_to_cart"
    class="bold pt-4 pb-4 btn btn--primary btn-lg btn-block"
  >
    {{ cartText }}
    <span
      style="margin-left: 8px; float: right"
      v-if="loading"
      class="spinner-border spinner-border-sm"
      role="status"
      aria-hidden="true"
    ></span>
    <i
      style="margin-left: 8px; float: right"
      v-if="!loading"
      class="icon-shopping-cart text-left"
    ></i>
  </button>
</template>
<script>
export default {
  props: ["cartText", "canAddToCart", "loading"],

  methods: {
    addToCart: function() {
      this.$emit("add");
    },
  },
};
</script>
