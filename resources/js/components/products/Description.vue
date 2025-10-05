<template>
  <div class="container my-4">
     
    <div id="productDetails" class="accordion">

      <!-- Size + Fit -->
      <div class="card mb-0 border-0 border-bottom">
        <div
          class="card-heade  bg--main cursor-pointer border-bottom bg-white d-flex justify-content-between align-items-center py-3"
          data-toggle="collapse"
          data-target="#collapseSizeFit"
          @click="toggle('collapseSizeFit')"

        >
          <div class="d-flex align-items-center">
            <i class="fas fa-clipboard-list mr-2"></i>
            <span class="font-weight-bold text-uppercase small">Description</span>
          </div>
          <span class="toggle-icon">{{ active === 'collapseSizeFit' ? '−' : '+' }}</span>

        </div>
        <div id="collapseSizeFit" class="collapse show" data-parent="#productDetails">
          <div v-html="product.product.description" class="card-body px-3"> </div>
        </div>
      </div>

      <!-- Material -->
      <div class="card mb-0 border-0 border-bottom">
        <div
          class="card-heade  cursor-pointer border-bottom bg--main  d-flex justify-content-between align-items-center py-3"
          data-toggle="collapse"
          data-target="#collapseMaterial"
          @click="toggle('collapseMaterial')"

        >
          <div class="d-flex  bg--main  align-items-center">
            <i class="fas fa-globe mr-2"></i>
            <span class="font-weight-bold text-uppercase small">Material</span>
          </div>
          <span class="toggle-icon">{{ active === 'collapseMaterial' ? '−' : '+' }}</span>

        </div>
        <div id="collapseMaterial" class="collapse" data-parent="#productDetails">
          <div class="card-body px-3">
             Our pieces are made from good materials, finished with our signature antique gold or silver polish and accented with acrylic.
          </div>
        </div>
      </div>


      <!-- Shipping -->
      <div class="card mb-0 border-0 border-bottom">
        <div
          class="card-heade cursor-pointer bg--main  border-bottom bg-white d-flex justify-content-between align-items-center py-3"
          data-toggle="collapse"
          data-target="#collapseShipping"
          @click="toggle('collapseShipping')"

        >
          <div class="d-flex align-items-center">
            <i class="fas fa-plane mr-2"></i>
            <span class="font-weight-bold text-uppercase small">Shipping</span>
          </div>
          <span class="toggle-icon">{{ active === 'collapseShipping' ? '−' : '+' }}</span>

        </div>
        <div id="collapseShipping" class="collapse" data-parent="#productDetails">
          <div class="card-body px-3">
            Within Lagos: We offer same-day delivery for all confirmed orders placed before our daily cut-off time.

            Other States in Nigeria: Delivery typically takes 1–3 business working days, depending on location and courier service availability.
          </div>
        </div>
      </div>

     

    </div>
  </div>
</template>



<script>
export default {
  props: ["product"],
  data() {
    return {
      active: "collapseSizeFit", // open first one by default
    };
  },
  methods: {
    toggle(section) {
      // When user clicks a header, set active to that ID or clear it
      this.active = this.active === section ? null : section;
    },
  },
};
</script>

<style>
.toggle-icon {
  font-size: 1.8rem;
  font-weight: bold;
  transition: transform 0.2s ease;
  user-select: none;
}

.card-header {
  cursor: pointer;
}
</style>