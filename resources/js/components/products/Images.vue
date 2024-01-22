<template>
  <div class="col-md-6 product-single-gallery">
    <div class="product-slider-container">
      <div class="product-single-carousel owl-carousel owl-theme">
        <div class="product-item">
          <img
            class="product-single-image"
            :data-zoom-image="image"
            :src="image"
          />
        </div>
        <div v-for="image in images" :key="image.id" class="product-item">
          <img
            class="product-single-image"
            :data-zoom-image="image.image"
            :src="image.image"
            v-if="image.image !== ''"
            :alt="image.image_tn"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["images", "image"],
};
</script>
