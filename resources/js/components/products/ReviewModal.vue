<template>
  <!-- Reusable BaseModal -->
     <BaseModal 
      :show="show" 
      title="Add Review"
      @update:show="$emit('update:show', $event)"
    >
      <div v-if="reviewSubmitted" class="text-center p-5">
        <div class="text-success" style="font-size: 48px;">
          ✅
        </div>
        <h5 class="mt-3">Review submitted</h5>
      </div>

      <form v-else @submit.prevent="submitReview">
        <!-- Rating -->
        <div class="form-group d-flex align-items-center">
          <label class="mr-2">Rating</label>
          <select v-model="newReview.rating" class="form-control w-auto">
            <option v-for="n in 5" :key="n" :value="n">{{ n }}</option>
          </select>

          <!-- Stars beside dropdown -->
          <div class="ml-3">
            <span
              v-for="n in 5"
              :key="'star-' + n"
              class="mx-1"
              :class="n <= newReview.rating ? 'text-warning' : 'text-muted'"
            >
              ★
            </span>
          </div>
        </div>

        <!-- Title -->
        <div class="form-group mt-3">
          <label for="review-title">Review Title</label>
          <input
            id="review-title"
            v-model="newReview.title"
            type="text"
            class="form-control"
            placeholder="e.g. Excellent quality!"
            required
          />
        </div>

        <!-- Description -->
        <div class="form-group mt-3">
          <label for="review-description">Description</label>
          <textarea
            id="review-description"
            v-model="newReview.description"
            class="form-control"
            rows="4"
            placeholder="Write your review here..."
            required
          ></textarea>
        </div>

        <!-- Submit Button -->
        <div class="form-group mt-4 text-right">
          <button type="submit" class="btn btn--primary btn-round" :disabled="submiting">
            {{ reviewText }}
          </button>
        </div>
      </form>
    </BaseModal>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import BaseModal from "../modal/BaseModal.vue";

export default {
  props: ["reviews", "meta", "show"],
   components: {
    BaseModal
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
