<template>
  <div v-if="$root.loggedIn" class="col-1">
    <a
      v-if="!wishlistText"
      @click.prevent="addToWishList"
      href="#"
      class="mt-4"
      title="Add to Wishlist"
    >
      <span class="fa-stack ">
        <i class="fas fa-circle fa-stack-2x"></i>
        <i class="fas fa-heart fa-stack-1x fa-inverse"></i>
      </span>
    </a>
    <span
      style=""
      v-if="wishlistText"
      class="spinner-border spinner-border-sm ml-4"
      role="status"
      aria-hidden="true"
    ></span>
  </div>
  <div v-else class="col-1 mt-1">
    <a
      data-toggle="modal"
      data-target="#login-modal"
      @click.prevent="addToWishList"
      href="#"
      class="mt-4"
      title="Add to Wishlist"
    >
      <span class="fa-stack">
        <i class="fas fa-circle fa-stack-2x"></i>
        <i class="fas fa-heart fa-stack-1x fa-inverse"></i>
      </span>
    </a>
  </div>
</template>
<script>
export default {
  props: ["attributes", "wishlistText"],
  data() {
    return {
      user: Window.auth,
      isActive: false,
    };
  },
  computed: {
    activeObject: function() {
      return {
        "active-attributes": this.isActive,
      };
    },
  },
  methods: {
    addToWishList: function() {
      this.$emit("wishlistChange");
    },
  },
};
</script>
