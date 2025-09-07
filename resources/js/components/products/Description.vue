<template>

<div class="container my-3">
  <div id="descriptionCard">
    <div class="card">
      <div class="card-header" id="headingDesc">
        <h5 class="mb-0">
          <button 
            class="btn btn-link d-flex align-items-center collapsed" 
            data-toggle="collapse" 
            data-target="#collapseDesc" 
            aria-expanded="false" 
            aria-controls="collapseDesc"
          >
            <i class="toggle-icon fas fa-plus mr-2"></i> Description
          </button>
        </h5>
      </div>

      <div 
        id="collapseDesc" 
        class="collapse" 
        aria-labelledby="headingDesc" 
        data-parent="#descriptionCard"
      >
        <div class="card-body">
          This is where your product description will go.  
          You can add paragraphs, lists, or even images here.
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Bootstrap JS -->


  
</template>
<script>
export default {
  props: {
    product: Object,
  },
};
</script>

<style>
/* Swap icons depending on collapse state */
.btn[aria-expanded="true"] .toggle-icon {
  content: "\f068"; /* Font Awesome minus */
}
.btn[aria-expanded="true"] .toggle-icon:before {
  font-family: "Font Awesome 5 Free";
  font-weight: 900;
  content: "\f068"; /* minus */
}
.btn[aria-expanded="false"] .toggle-icon:before {
  font-family: "Font Awesome 5 Free";
  font-weight: 900;
  content: "\f067"; /* plus */
}
</style>
