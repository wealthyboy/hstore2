<template>
  <div>
    <div id="out-of-stock-modal" class="modal fade" role="dialog">
      <div class="modal-dialog" style="">
        <!-- Modal content-->
        <div class="modal-content ">
          <div class="modal-header">
            <div class="modal-title text-center">
              <img
                width="200"
                height="200"
                :src="'/images/logo/' + $root.settings.store_logo"
              />
            </div>
            <span class="bold text-large "
              ><button
                type="button"
                class="close"
                id="login_modal"
                data-dismiss="modal"
              >
                <i class="fas fa-times"></i></button
            ></span>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <img
                  v-if="null !== product_variation"
                  :src="product_variation.image"
                  alt=""
                />
                <p></p>
              </div>
              <div class="col-md-6">
                <div class="newsletter-content">
                  <div>
                    <h3 class="newsletter-popup-title">ITEM IS OUT OF STOCK</h3>
                    <p class="newsletter-popup-slogen">
                      Get notified when this item is available.
                    </p>

                    <p v-if="message">{{ message }}</p>
                    <form
                      v-if="!message"
                      @submit.prevent="signUp"
                      method="POST"
                      class="form-group"
                    >
                      <div class="form-field-wrapper">
                        <input
                          name="email"
                          v-model="form.email"
                          class="form-control"
                          id="newsletter-email"
                          title="Email"
                          placeholder="Enter Your Email..."
                          value=""
                          type="email"
                          required
                        />
                      </div>
                      <div class="form-field-wrapper mt-1">
                        <button
                          type="submit"
                          class="newsletter-btn btn btn--primary btn-block"
                          name="Sign_Up"
                          id="Sign_Up"
                          value="Sign Up"
                          data-value="Sign_Up"
                          :class="{ disabled: loading }"
                        >
                          <span
                            v-if="loading"
                            class="spinner-border spinner-border-sm"
                            role="status"
                            aria-hidden="true"
                          ></span>
                          Get Notified
                        </button>
                      </div>
                    </form>
                    <p class="newsletter-popup-info"></p>
                    <div class="newsletter-popup-footer">
                      <a
                        href="#"
                        id="out-of-stock-modal"
                        data-dismiss="modal"
                        class=" newsletter-close-text"
                        >No Thanks</a
                      >
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- End .newsletter-popup -->
          </div>
        </div>
      </div>
      <!--modal-content-->
    </div>
    <!--modal-dialog-->
  </div>

  <!--loginModal-->
</template>
<script>
import { mapActions, mapGetters } from "vuex";
import ErrorMessage from "../messages/components/Error";

export default {
  props: ["product_variation"],
  data() {
    return {
      form: {
        email: null,
      },
      loading: false,
      message: null,
      error: null,
      errorsBag: [],
    };
  },
  computed: {
    ...mapGetters({
      errors: "errors",
    }),
  },
  components: {
    ErrorMessage,
  },

  mounted() {
    this.message = null;
  },

  methods: {
    signUp() {
      this.loading = true;
      return axios
        .post("/out_of_stock/signup", {
          email: this.form.email,
          product_variation_id: this.product_variation.id,
        })
        .then((response) => {
          this.loading = false;
          this.message = "You have been added";
          let context = this;
          setTimeout(() => {
            context.message = null;
          }, 1000);
        })
        .catch((error) => {
          this.loading = false;
          this.error = "There was an error";
        });
    },
  },
};
</script>
