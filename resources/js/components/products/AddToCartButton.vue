<template>
  <button @click.prevent="addToCart" :class="canAddToCart" type="button" name="add-to-cart" value="add_to_cart"
    class="btn btn-sm btn-dark w-100 py-4"
  >

    <span v-if="loading" class="wave-loader">
      <span></span><span></span><span></span>
    </span>
    {{ cartText }}
    
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


<template>
  <button
    @click.prevent="addToCart"
    :class="['btn btn--primary btn-lg btn-block border-raduis-btn', canAddToCart]"
    type="button"
    name="add-to-cart"
    value="add_to_cart"
  >
    <!-- Loader -->
    <span v-if="loading" class="wave-loader">
      <span></span><span></span><span></span>
    </span>

    <!-- Button Text -->
    <span v-else class="d-flex align-items-center justify-content-center">
      <i class="icon-shopping-cart mr-2"></i>
      {{ cartText }}
    </span>
  </button>
</template>

<script>
export default {
  props: ["cartText", "canAddToCart", "loading"],
  methods: {
    addToCart() {
      this.$emit("add");
    },
  },
};
</script>

<style scoped>

</style>

