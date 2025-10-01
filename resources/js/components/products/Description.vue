<template>
  <div class="container my-4">
     
    <div id="productDetails" class="accordion">

      <!-- Size + Fit -->
      <div class="card mb-0 border-0 border-bottom">
        <div
          class="card-heade  bg--main cursor-pointer border-bottom bg-white d-flex justify-content-between align-items-center p-3"
          data-toggle="collapse"
          data-target="#collapseSizeFit"
        >
          <div class="d-flex align-items-center">
            <i class="fas fa-clipboard-list mr-2"></i>
            <span class="font-weight-bold text-uppercase small">Description</span>
          </div>
          <span class="toggle-icon">+</span>
        </div>
        <div id="collapseSizeFit" class="collapse" data-parent="#productDetails">
          <div v-html="product.product.description" class="card-body"> </div>

        </div>
      </div>

      <!-- Material -->
      <div class="card mb-0 border-0 border-bottom">
        <div
          class="card-heade  cursor-pointer border-bottom bg--main  d-flex justify-content-between align-items-center p-3"
          data-toggle="collapse"
          data-target="#collapseMaterial"
        >
          <div class="d-flex  bg--main  align-items-center">
            <i class="fas fa-globe mr-2"></i>
            <span class="font-weight-bold text-uppercase small">Material</span>
          </div>
          <span class="toggle-icon">+</span>
        </div>
        <div id="collapseMaterial" class="collapse" data-parent="#productDetails">
          <div class="card-body">
             Our pieces are made from good materials, finished with our signature antique gold or silver polish and accented with acrylic.
          </div>
        </div>
      </div>


      <!-- Shipping -->
      <div class="card mb-0 border-0 border-bottom">
        <div
          class="card-heade cursor-pointer bg--main  border-bottom bg-white d-flex justify-content-between align-items-center p-3"
          data-toggle="collapse"
          data-target="#collapseShipping"
        >
          <div class="d-flex align-items-center">
            <i class="fas fa-plane mr-2"></i>
            <span class="font-weight-bold text-uppercase small">Shipping</span>
          </div>
          <span class="toggle-icon">+</span>
        </div>
        <div id="collapseShipping" class="collapse" data-parent="#productDetails">
          <div class="card-body">
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


  mounted() {
    // Toggle plus/minus dynamically
    const headers = document.querySelectorAll("#productDetails .card-header");

    headers.forEach(header => {
      header.addEventListener("click", function () {
        const icon = this.querySelector(".toggle-icon");

        // reset all to plus
        document.querySelectorAll("#productDetails .toggle-icon").forEach(el => {
          el.textContent = "+";
        });

        // if this is expanded, show minus
        setTimeout(() => {
          if (
            this.nextElementSibling.classList.contains("show")
          ) {
            icon.textContent = "-";
          }
        }, 200);
      });
    });
  },
};
</script>

<style>
.toggle-icon {
  font-size: 2.2rem;
  transition: transform 0.2s ease;
}

/* when the collapse is open, show minus */
.collapse.show + .card-body,
.card-header.active .toggle-icon {
  content: "-";
}

.card-header[aria-expanded="true"] .toggle-icon {
  content: "-";
}
</style>
