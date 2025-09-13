<template>
    <div class="position-relative d-flex align-items-center  ml-3">
         <div

        class="wishlist-icon "
        style="top: 10px; right: 10px; cursor: pointer;"
      >
        <!-- Outlined heart -->
        <svg
          v-if="!is_wishlist"
          xmlns="http://www.w3.org/2000/svg"
          width="24"
          height="24"
          viewBox="0 0 24 24"
          fill="none"
        >
          <path
            d="M19.6706 5.4736C17.6806 3.8336 14.7206 4.1236 12.8906 5.9536L12.0006 6.8436L11.1106 5.9536C9.29063 4.1336 6.32064 3.8336 4.33064 5.4736C2.05064 7.3536 1.93063 10.7436 3.97063 12.7836L11.6406 20.4536C11.8406 20.6536 12.1506 20.6536 12.3506 20.4536L20.0206 12.7836C22.0706 10.7436 21.9506 7.3636 19.6706 5.4736Z"
            stroke="currentColor"
            stroke-miterlimit="10"
            stroke-linecap="round"
            stroke-linejoin="round"
          />
        </svg>

        <!-- Filled heart -->
        <svg
          v-else
          xmlns="http://www.w3.org/2000/svg"
          width="24"
          height="24"
          viewBox="0 0 24 24"
          fill="black"
        >
          <path
            d="M19.6706 5.4736C17.6806 3.8336 14.7206 4.1236 12.8906 5.9536L12.0006 6.8436L11.1106 5.9536C9.29063 4.1336 6.32064 3.8336 4.33064 5.4736C2.05064 7.3536 1.93063 10.7436 3.97063 12.7836L11.6406 20.4536C11.8406 20.6536 12.1506 20.6536 12.3506 20.4536L20.0206 12.7836C22.0706 10.7436 21.9506 7.3636 19.6706 5.4736Z"
          />
      </svg>
  </div>
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
