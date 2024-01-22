<template>
  <form method="POST" class="">
    <div
      class="row reduce-gutters"
      id="add-new-address-form"
      data-action="/address/create"
    >
      <p class="form-group reduce-gutters col-lg-9">
        <label for="Amount">Amount</label>
        <input
          :class="{ 'has-danger': errors.amount }"
          id="amount"
          @input="removeError($event)"
          @blur="vInput($event)"
          v-model="form.amount"
          type="text"
          class="form-control card_required"
          name="amount"
          placeholder="Amount"
        />
        <span
          class="help-block error  text-danger text-sm-left"
          v-if="errors.amount"
        >
          <small class="text-danger">{{ formatError(errors.amount) }}</small>
        </span>
      </p>

      <p class="form-group reduce-gutters col-lg-9">
        <label for="recipients_name">Recipient's Name</label>
        <input
          id="lastname"
          :class="{ 'has-danger': errors.recipients_name }"
          type="text"
          @blur="vInput($event)"
          @input="removeError($event)"
          v-model="form.recipients_name"
          class="form-control card_required"
          name="recipients_name"
          placeholder="Recipient's Name"
        />
        <span
          class="help-block error  text-danger text-sm-left"
          v-if="errors.recipients_name"
        >
          <small class="text-danger">{{
            formatError(errors.recipients_name)
          }}</small>
        </span>
      </p>

      <p class="form-group reduce-gutters col-lg-9">
        <label for="recipients_email">Recipient's Email</label>
        <input
          id="recipients_email"
          type="text"
          class="form-control card_required"
          name="recipients_email"
          placeholder="Recipient's Email"
          v-model="form.recipients_email"
          @input="removeError($event)"
          @blur="vInput($event)"
        />
        <span
          class="help-block error  text-danger text-sm-left"
          v-if="errors.recipients_email"
        >
          <small class="text-danger">{{
            formatError(errors.recipients_email)
          }}</small>
        </span>
      </p>
      <p class="form-group reduce-gutters col-lg-9">
        <label for="senders_name">Sender's Name</label>
        <input
          id="senders_name"
          :class="{ 'has-danger': errors._name }"
          type="text"
          @input="removeError($event)"
          @blur="vInput($event)"
          class="form-control card_required"
          name="senders_name"
          placeholder="Sender's Name"
          v-model="form.senders_name"
        />
        <span
          class="help-block error  text-danger text-sm-left"
          v-if="errors.senders_name"
        >
          <small class="text-danger">{{
            formatError(errors.senders_name)
          }}</small>
        </span>
      </p>
      <p class="form-group reduce-gutters col-md-9">
        <label for="senders_email">Sender's Email</label>
        <input
          id="senders_email"
          @input="removeError($event)"
          @blur="vInput($event)"
          v-model="form.senders_email"
          :class="{ 'has-danger': errors.senders_email }"
          type="text"
          class="form-control card_required"
          name="senders_email"
          placeholder="Sender's Email"
        />

        <span
          class="help-block error  text-danger text-sm-left"
          v-if="errors.senders_email"
        >
          <small class="text-danger">{{
            formatError(errors.senders_email)
          }}</small>
        </span>
      </p>

      <p class="form-group reduce-gutters col-md-9">
        <label for="comment">Add Something Sweet </label>
        <textarea
          id="comment"
          v-model="form.comment"
          name="comment"
          class=" form-control card_required form-control-sm"
          cols="35"
          rows="10"
          @input="removeError($event)"
          @blur="vInput($event)"
          aria-required="true"
          placeholder="Comment"
        >
        </textarea>
        <span
          class="help-block error  text-danger text-sm-left"
          v-if="errors.comment"
        >
          <small class="text-danger">{{ formatError(errors.comment) }}</small>
        </span>
      </p>
      <p class="form-group reduce-gutters col-md-9">
        <button
          @click.prevent="addToCart"
          :class="canAddToCart"
          type="button"
          name="add-to-cart"
          value="add_to_cart"
          class="bold pt-4 pb-4 btn btn--primary btn-lg btn-block"
        >
          {{ cText }}
          <span
            style="margin-left: 8px; float: right"
            v-if="loading"
            class="spinner-border spinner-border-sm"
            role="status"
            aria-hidden="true"
          ></span>
          <i
            style="margin-left: 8px; float: right"
            v-if="!loading"
            class="icon-shopping-cart text-left"
          ></i>
        </button>
      </p>
    </div>
  </form>
</template>
<script>
import { mapGetters, mapActions } from "vuex";

export default {
  props: ["canAddToCart", "product"],
  data() {
    return {
      form: {
        comment: null,
        amount: null,
        recipients_email: null,
        recipients_name: null,
        senders_email: null,
        senders_name: null,
      },
      cText: "Add to cart",
      loading: false,
      errorsBag: {},
    };
  },
  computed: {
    ...mapGetters({
      errors: "errors",
    }),
  },
  methods: {
    ...mapActions({
      validateForm: "validateForm",
      clearErrors: "clearErrors",
      checkInput: "checkInput",
      addProductToCart: "addProductToCart",
    }),
    formatError(error) {
      return Array.isArray(error)
        ? error[0].charAt(0).toUpperCase() + error[0].slice(1)
        : error.charAt(0).toUpperCase() + error.slice(1);
    },
    removeError(e) {
      let input = document.querySelectorAll(".card_required");
      if (typeof input !== "undefined") {
        this.clearErrors({ context: this, input: input });
      }
    },
    vInput(e) {
      let input = document.querySelectorAll(".card_required");
      if (typeof input !== "undefined") {
        this.checkInput({ context: this, input: e });
      }
    },
    addToCart: function() {
      let input = document.querySelectorAll(".card_required");
      this.validateForm({ context: this, input: input });

      if (Object.keys(this.errors).length !== 0) {
        return false;
      }

      this.cText = "Adding....";
      this.loading = true;
      this.addProductToCart({
        product_variation_id: this.product.id,
        quantity: 1,
        form: this.form,
      })
        .then(() => {
          this.cText = "Add To Cart";
          this.loading = false;
        })
        .catch((error) => {
          this.cText = "Add To Cart";
          this.loading = false;
        });
    },
  },
};
</script>
