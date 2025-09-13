<template>
  <div class="reviews-section mt-4">
    <!-- Header with Add Review button -->
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h4 class="mb-0 font-weight-bold">
        Reviews <span class="text-warning">5.0 
          ★★★★☆

        </span>({{ product.average_rating_count }})
      </h4>
      <button
        class="btn btn-sm btn-dark"
        @click="showReviewModal = true"
      >
        <i class="fas fa-plus mr-1"></i> Add a Review
      </button>
    </div>

    <!-- Reviews -->
    <div v-for="(review, index) in reviews" :key="index" class="review-item py-3 border-top">
      <div class="row">
        <!-- Left Column -->
        <div class="col-md-3">
          <div class="text-warning">
            <i v-for="n in 5" :key="n" class="fas fa-star"></i>
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

    <!-- Review Modal -->
    <div v-if="showReviewModal" class="modal fade show d-block" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content rounded-lg shadow">
          <div class="modal-header">
            <h5 class="modal-title">Add a Review</h5>
            <button type="button" class="close" @click="showReviewModal = false">
              <span>&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <form @submit.prevent="submitReview">
              <!-- Title -->
              <div class="form-group">
                <label>Review Title</label>
                <input v-model="newReview.title" type="text" class="form-control" required />
              </div>

              <!-- Text -->
              <div class="form-group">
                <label>Review</label>
                <textarea v-model="newReview.text" rows="3" class="form-control" required></textarea>
              </div>

              <!-- Fit -->
              <div class="form-group">
                <label>Fit</label>
                <select v-model="newReview.fit" class="form-control">
                  <option>Small</option>
                  <option>True to size</option>
                  <option>Large</option>
                </select>
              </div>

              <!-- Size -->
              <div class="form-group">
                <label>Size Ordered</label>
                <input v-model="newReview.size" type="text" class="form-control" />
              </div>

              <button type="submit" class="btn btn-dark">Submit Review</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal backdrop -->
    <div v-if="showReviewModal" class="modal-backdrop fade show"></div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import Pagination from "../pagination/Pagination.vue";
export default {
  props: ["reviews", "meta", "product"],
   components: {
    Pagination,
  },
  data() {
    return {
      showReviewModal: false,
     
      newReview: {
        title: "",
        text: "",
        fit: "True to size",
        size: ""
      }
    };
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
    submitReview() {
      this.reviews.unshift({
        ...this.newReview,
        author: "You",
        date: new Date().toLocaleDateString(),
        helpful: 0
      });
      this.newReview = { title: "", text: "", fit: "True to size", size: "" };
      this.showReviewModal = false;
    },
    submitReview() {
      let input = document.querySelectorAll(".rating_required");
      this.validateForm({ context: this, input: input });
      if (!this.form.rating) {
        this.noRating = true;
        return false;
      }

      if (Object.keys(this.errors).length !== 0) {
        return false;
      }

      this.submiting = true;
      let form = new FormData();
      form.append("description", this.form.description);
      form.append("title", this.form.title);
      form.append("rating", this.form.rating);
      form.append("product_id", this.product.product_id);
      form.append("product_variation_id", this.product.id);
      this.createReviews({ context: this, form });
    },

    productReviews() {
      return axios
        .get("/reviews/" + this.product.id)
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
</style>




