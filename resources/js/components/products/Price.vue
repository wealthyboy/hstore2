<template>
  <div class="p">
    <div v-if="product.brand" class="tag brand-name bold">
      {{ product.brand_name }}
    </div>
    <p class="product-title bold">{{ name }}</p>
    <div class="ratings-container">
      <div class="product-ratings">
        <span
          class="ratings"
          :style="{ width: product.average_rating + '%' }"
        ></span
        ><!-- End .ratings -->
      </div>
      <!-- End .product-ratings -->

      <a href="#" class="rating-link"
        >( {{ product.average_rating_count }} Reviews )</a
      >
    </div>

    <div v-if="!product.is_gift_card">
      <div class="product-item-prices d-flex mt-2" v-if="discounted_price">
        <div class="product--price--amount">
          <span class="retail--title text-gold">SALE PRICE</span>
          <span class="product--price text-danger"
            >{{ product.currency }}{{ discounted_price | priceFormat }}</span
          >
          <span class="retail--title">{{ percentage_off }}% off</span>
        </div>
        <div class="product--price--amount retail">
          <span class="retail--title text-gold">PRICE</span>
          <span class="product--price retail--price text-gold"
            >{{ product.currency }}{{ price | priceFormat }}</span
          >
          <span class="retail--title"></span>
        </div>
      </div>

      <div class="product-item-prices mt-2" v-else>
        <div class="product--price--amount">
          <span class="retail--title text-gold">PRICE</span>
          <span class="product--price"
            >{{ product.currency }}{{ price | priceFormat }}</span
          >
          <span class="retail--title"></span>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: [
    "product",
    "attributes",
    "name",
    "discounted_price",
    "percentage_off",
    "price",
  ],

  mounted() {
    console.log(this.product);
  },

  methods: {},
};
</script>
