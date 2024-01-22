<template>
  <div class="col-md-1 product-single-gallery d-none d-lg-block">
    <div
      class="prod-thumbnail carousel-custom-dots owl-dots"
      id="carousel-custom-dots"
    >
      <div class="owl-dot">
        <img
          class="animated"
          @click.prevent="currentSlide(product.image_to_show)"
          :src="image_tn"
        />
      </div>
      <div
        @click.prevent="currentSlide(image.image)"
        v-for="image in images"
        :key="image.id"
        class="owl-dot"
      >
        <img :src="image.image_tn" :alt="image.image_tn" />
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["images", "product", "image_tn"],
};
</script>
