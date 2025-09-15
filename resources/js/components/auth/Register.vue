<template>
    

<form @submit.prevent="submit" class="row">
    <p class="form-group col-6">
    <label for="first_name">First Name</label>
    <input
        v-model="form.first_name"
        id="first_name"
        type="text"
        class="form-control required"
        @input="removeError($event)"
        @blur="vInput($event)"
        :class="{ 'is-invalid': errors.first_name }"
        required
        autofocus
    />
    <span v-if="errors.first_name" class="text-danger">
        {{ formatError(errors.first_name) }}
    </span>
    </p>

    <p class="form-group col-6">
    <label for="last_name">Last Name</label>
    <input
        v-model="form.last_name"
        id="last_name"
        type="text"
        class="form-control required"
        @input="removeError($event)"
        @blur="vInput($event)"
        :class="{ 'is-invalid': errors.last_name }"
        required
    />
    <span v-if="errors.last_name" class="text-danger">
        {{ formatError(errors.last_name) }}
    </span>
    </p>

    <p class="form-group col-6">
    <label for="email">Email Address</label>
    <input
        v-model="form.email"
        id="email"
        type="email"
        class="form-control required"
        @input="removeError($event)"
        @blur="vInput($event)"
        :class="{ 'is-invalid': errors.email }"
        required
    />
    <span v-if="errors.email" class="text-danger">
        {{ formatError(errors.email) }}
    </span>
    </p>

    <p class="form-group col-6">
    <label for="phone_number">Phone Number</label>
    <input
        v-model="form.phone_number"
        id="phone_number"
        type="text"
        class="form-control required"
        @input="removeError($event)"
        @blur="vInput($event)"
        :class="{ 'is-invalid': errors.phone_number }"
        required
    />
    <span v-if="errors.phone_number" class="text-danger">
        {{ formatError(errors.phone_number) }}
    </span>
    </p>

    <p class="form-group col-6">
    <label for="password">Password</label>
    <input
        v-model="form.password"
        id="password"
        type="password"
        class="form-control required"
        @input="removeError($event)"
        @blur="vInput($event)"
        :class="{ 'is-invalid': errors.password }"
        required
    />
    <span v-if="errors.password" class="text-danger">
        {{ formatError(errors.password) }}
    </span>
    </p>

    <p class="form-group col-6">
    <label for="password_confirmation">Confirm Password</label>
    <input
        v-model="form.password_confirmation"
        id="password_confirmation"
        type="password"
        class="form-control required"
        @input="removeError($event)"
        @blur="vInput($event)"
        :class="{ 'is-invalid': errors.password_confirmation }"
        required
    />
    <span v-if="errors.password_confirmation" class="text-danger">
        {{ formatError(errors.password_confirmation) }}
    </span>
    </p>

    <p class="form-group col-6">
    Already have an account?
    <a href="#" @click.prevent="openLogin" class="color--primary bold">
        Login
    </a>
    </p>

    <p class="form-group col-6 text-right">
    <button
        type="submit"
        class="btn btn--primary btn--lg bold"
        :disabled="loading"
    >
        <span
        v-if="loading"
        class="spinner-border spinner-border-sm"
        role="status"
        ></span>
        Sign Up
    </button>
    </p>
</form>

           
         
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
  name: "RegisterModal",
  props: {
    show: { type: Boolean, default: false },
  },
  emits: ["update:show", "open-login"],
  data() {
    return {
      loading: false,
      form: {
        first_name: "",
        last_name: "",
        email: "",
        phone_number: "",
        password: "",
        password_confirmation: "",
      },
    };
  },
  computed: {
    ...mapGetters({ errors: "errors" }),
  },
  methods: {
    ...mapActions(["register", "validateForm", "clearErrors", "checkInput"]),
    close() {
      this.$emit("update:show", false);
    },
    openLogin() {
      this.$emit("open-login");
    },
    formatError(error) {
      return Array.isArray(error) ? error[0] : error;
    },
    formatErrors(error) {
      return Array.isArray(error) ? error : [error];
    },
    removeError(e) {
      this.clearErrors({ context: this, input: e.target });
    },
    vInput(e) {
      this.checkInput({ context: this, email: this.form.email, input: e });
    },
    async submit() {
      let input = document.querySelectorAll(".required");
      this.validateForm({ context: this, input });

      if (Object.keys(this.errors).length) {
        return;
      }

      this.loading = true;
      try {
        await this.register({ context: this, ...this.form });
        this.close();
      } finally {
        this.loading = false;
      }
    },
  },
};
</script>

