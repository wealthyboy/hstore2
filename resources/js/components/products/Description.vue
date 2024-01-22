<template>
  <div class="product-single-tabs">
    <ul class="nav nav-tabs" role="tablist">
      <li class="nav-item pl-2">
        <a
          class="nav-link active"
          id="product-tab-desc"
          data-toggle="tab"
          href="#product-desc-content"
          role="tab"
          aria-controls="product-desc-content"
          aria-selected="true"
          >Description</a
        >
      </li>
    </ul>
    <div class="tab-content bg--gray">
      <div
        class="tab-pane fade show active pl-2"
        id="product-desc-content"
        role="tabpanel"
        aria-labelledby="product-tab-desc"
      >
        <div
          v-html="product.product.description"
          class="product-desc-content pl-2 pb-2 color--primary"
        ></div>
        <!-- End .product-desc-content -->
      </div>
      <!-- End .tab-pane -->
    </div>
    <!-- End .tab-content -->
  </div>
</template>
<script>
export default {
  props: {
    product: Object,
  },
};
</script>
