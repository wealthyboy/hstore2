<template>
  <div class="reviews-section">
    <!-- Header with Add Review button -->
    <div class="d-flex justify-content-between align-items-center">
      <h4 class="mb-0 font-weight-bold">
        Reviews {{ product.product.average_rating / 20 }}
        <span class="text-warning">
           <span v-for="n in 5" :key="n">
              <span v-if="n <= product.product.average_rating / 20">★</span>
              <span v-else>☆</span>
            </span>
        </span>
      
      </h4>
      <button
        class="btn btn-sm btn-dark border-raduis-btn mb-3"
        @click="openShowReviewModal"
      >
        <i class="fas fa-plus mr-1"></i> Add a Review
      </button>
    </div>

    <ReviewModal :show="showReviewModal" @update:show="close"  />




    <!-- Reviews -->
    <div v-for="(review, index) in reviews" :key="index" class="review-item py-3 border-top">
      <div class="row">
        <!-- Left Column -->
        <div class="col-md-3">
         
           <div class="text-warning">
           <span v-for="n in 5" :key="n">
              <span v-if="n <= (review.rating / 20)">★</span>
              <span v-else>☆</span>
            </span>
          </div>
          <p class="mb-1 font-weight-bold">{{ review.author }}</p>
          <small class="text-muted">{{ review.date }}</small>
        </div>

        <!-- Middle Column -->
        <div class="col-md-6">
          <p class="mb-1 font-weight-bold text-uppercase">{{ review.title }}</p>
          <small class="d-block text-muted">
            Fit: {{ review.fit }} &nbsp; | &nbsp;
            Size Ordered: {{ review.size }}
          </small>
          <p class="mb-0">{{ review.text }}</p>
        </div>

        <!-- Right Column -->
        <div class="col-md-3 text-md-right mt-2 mt-md-0">
          <button class="btn btn-outline-secondary btn-sm">
            <i class="far fa-thumbs-up mr-1"></i>
            Helpful ({{ review.helpful }})
          </button>
        </div>
      </div>
    </div>
    <LoginModal :show="showLogin" @update:show="close"  />
</div>

</template>

<script>
import { mapGetters, mapActions } from "vuex";
import Pagination from "../pagination/Pagination.vue";
import LoginModal from "../auth/LoginModal.vue";
import ReviewModal from "./ReviewModal.vue";



export default {
  props: ["reviews", "meta", "product"],
   components: {
    Pagination,
    ReviewModal,
    LoginModal
  },
  data() {
    return {
      showReviewModal: false,
      submiting: false,
      reviewText: "Submit Review",
      reviewSubmitted: false, // ✅ track submission state
      newReview: {
        title: "",
        description: "",
        rating: "",
        size: ""
      },
      showLogin: false,

    }
  },
   computed: {
    ...mapGetters({
      loggedIn: "loggedIn",
      errors: "errors",
      message: "message",
    }),
    loggedIn: function() {
      return [this.user ? true : false];
    },
  },
  methods: {
     ...mapActions({
       createReviews: "createReviews",
    }),
    close(){

      this.showReviewModal = false;
      this.showLogin = false
    },
    openShowReviewModal(){
      

      if (!this.$root.user) {
        this.showLogin = true;
        return;
      }

      this.showReviewModal = true;
    },
    submitReview() {
      
      if (this.submiting) return;

      this.reviewText = "...";
      this.submiting = true;

      let form = new FormData();
      form.append("description", this.newReview.description);
      form.append("title", this.newReview.title);
      form.append("rating", this.newReview.rating);
      form.append("product_id", this.product.product_id);
      form.append("product_variation_id", this.product.id);

      this.createReviews({ context: this, form }).then(() => {
        this.submiting = false;
        this.reviewText = "Submit Review";

        // ✅ show success check
        this.reviewSubmitted = true;

        // Auto-close modal after 2 seconds
        setTimeout(() => {
          this.reviewSubmitted = false;
          this.showReviewModal = false;

          // reset form
          this.newReview = { title: "", description: "", rating: "", size: "" };
        }, 2000);
      });
    },

    productReviews() {
      return axios
        .get("/reviews/" + this.product.product.id)
        .then((response) => {
          this.loading = false;
          this.$store.commit("setReviews", response.data.data);
          this.$store.commit("setReviewsMeta", response.data.meta);
        })
        .catch((error) => {
          this.loading = false;
        });
    },
  }
};
</script>
<style scoped>
.review-item:first-child {
  border-top: none;
}
.modal {
  display: block; /* Override Bootstrap hide */
}


.wave-loader {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 20px;
}

.wave-loader span {
  display: block;
  width: 6px;
  height: 6px;
  margin: 0 2px;
  background: white;
  border-radius: 50%;
  animation: wave 1.2s linear infinite;
}

.wave-loader span:nth-child(1) {
  animation-delay: 0s;
}
.wave-loader span:nth-child(2) {
  animation-delay: 0.2s;
}
.wave-loader span:nth-child(3) {
  animation-delay: 0.4s;
}

@keyframes wave {
  0%, 60%, 100% {
    transform: initial;
  }
  30% {
    transform: translateY(-6px);
  }
}
</style>




