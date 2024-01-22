<template>
  <div>
    <div class="comments">
      <h3 class="review-title">Comments</h3>
      <div v-if="!loading && comments.length">
        <div v-for="comment in comments" :key="comment.id" class="post-author">
          <figure>
            <a href="#">
              <img src="/img/avtar.jpg" alt="author" />
            </a>
          </figure>

          <div class="author-content">
            <span class="bold">{{ comment.author }}</span
            >-
            <span>{{ comment.date }}</span>

            <p>{{ comment.body }}</p>
            <p></p>
          </div>
          <!-- End .author.content -->
        </div>
      </div>

      <div v-if="!loading && !comments.length">
        No comments
      </div>
    </div>

    <!--Comment Form-->
    <div class="comment-respond">
      <h3 class="review-title">Leave a Comment</h3>
      <form id="comment-form" @submit.prevent="submit" class="row comment-form">
        <div class="col-sm-6">
          <div class="form-group form-field-wrapper">
            <label for="author">Name<span class="required">*</span></label>
            <input
              id="author"
              name="author"
              class="form-control required"
              size="30"
              aria-required="true"
              required=""
              type="text"
              v-model="form.author"
              @input="removeError($event)"
              @blur="vInput($event)"
            />
          </div>
          <div class="form-field-wrapper form-group">
            <label for="email">Email<span class="required">*</span></label>
            <input
              id="email"
              name="email"
              size="30"
              aria-required="true"
              required=""
              type="email"
              v-model="form.email"
              @input="removeError($event)"
              @blur="vInput($event)"
              class="form-control required"
            />
          </div>
          <div class="form-field-wrapper  form-group">
            <label for="comment">Comment</label>
            <textarea
              v-model="form.comment"
              name="comment"
              class="form-control required"
              cols="20"
              rows="5"
              @input="removeError($event)"
              @blur="vInput($event)"
            />
          </div>
          <div class="form-field-wrapper">
            <button
              type="submit"
              class="btn  btn--md btn--primary btn--full"
              name="checkout_place_order"
              id="place_order"
              value="Place order"
              data-value="Place Order"
            >
              <span
                v-if="submiting"
                class="spinner-border spinner-border-sm"
                role="status"
                aria-hidden="true"
              ></span>
              Submit
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
import Pagination from "../pagination/Pagination.vue";

export default {
  props: {
    blog: Object,
  },
  components: {
    Pagination,
  },
  data() {
    return {
      user: Window.auth,
      loading: false,
      errorsBag: [],
      form: {
        email: null,
        comment: null,
        author: null,
        blog_id: this.blog.id,
      },
      submiting: false,
    };
  },
  computed: {
    ...mapGetters({
      loggedIn: "loggedIn",
      comments: "comments",
      meta: "reviewsMeta",
      errors: "errors",
    }),
  },
  mounted() {
    this.getComments();
  },
  methods: {
    getComments() {
      this.loading = true;
      return axios
        .get("/api/blog/" + this.blog.slug)
        .then((response) => {
          this.loading = false;
          this.$store.commit("setComments", response.data.data);
          // this.$store.commit('setReviewsMeta', response.data.meta)
        })
        .catch((error) => {});
    },
    removeError(e) {
      let input = document.querySelectorAll(".required");
      if (typeof input !== "undefined") {
        this.clearErrors({ context: this, input: input });
      }
    },
    vInput(e) {
      let input = document.querySelectorAll(".required");
      if (typeof input !== "undefined") {
        this.checkInput({ context: this, input: e });
      }
    },
    ...mapActions({
      createComment: "createComment",
      validateForm: "validateForm",
      clearErrors: "clearErrors",
      checkInput: "checkInput",
      getReviews: "getReviews",
    }),
    submit() {
      let input = document.querySelectorAll(".required");
      this.validateForm({ context: this, input: input });
      if (Object.keys(this.errors).length !== 0) {
        if (!this.form.rating) {
          this.noRating = true;
        }
        return false;
      }
      this.submiting = true;
      this.createComment({ context: this });
    },
  },
};
</script>
