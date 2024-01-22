<template>
  <div class="col-12  text-info bold">
    <div
      v-if="parseInt(quantity) < 1"
      class="alert alert-warning alert-dismissible fade show"
      role="alert"
    >
      <strong
        ><a
          data-toggle="modal"
          data-target="#out-of-stock-modal"
          class=""
          href="#"
          ><i class="fas  fa-bell"></i> Notify me when available</a
        ></strong
      >
      <button
        type="button"
        class="close"
        data-dismiss="alert"
        aria-label="Close"
      >
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  </div>
</template>
<script>
export default {
  props: ["quantity"],
};
</script>
