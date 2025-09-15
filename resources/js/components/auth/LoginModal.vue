<template>
  <!-- Reusable BaseModal -->
  <BaseModal :show="show" title="Login" @update:show="$emit('update:show', $event)">
   

    <form method="POST" @submit.prevent="authenticate">
      <p>
        <label for="email">Email address</label>
        <input
          v-model="email"
          id="email"
          type="email"
          class="form-control"
          required
          autofocus
        />
        <p class="text-danger bold" v-if="errors.length">Email/Password not found</p>
      </p>

      <p>
        <label for="password">Password</label>
        <input
          v-model="password"
          id="password"
          type="password"
          class="form-control"
          required
        />
      </p>

      <div class="d-flex justify-content-between">
        <div>
          <div class="custom-control custom-checkbox">
            <input
              type="checkbox"
              class="custom-control-input"
              id="remember-me"
              value="1"
            />
            <label class="custom-control-label" for="remember-me">Remember Me</label>
          </div>
        </div>

        <p class="form-group text-right mt-2">
          <a class="color--primary bold" href="/password/reset">Forget your password?</a>
        </p>
      </div>

      <button
        type="submit"
        id="login_form_button"
        data-loading="Loading"
        class="ml-1 btn btn--primary btn-round btn-lg btn-block"
      >
        <span
          v-if="loading"
          class="spinner-border spinner-border-sm"
          role="status"
          aria-hidden="true"
        ></span>
        Log In
      </button>
    </form>

    <div class="text-center border-top pt-3">
      <p>
        Don’t have an account?
        <a class="color--primary bold" href="#" @click="openRegister">Create One</a>
      </p>
    </div>
  </BaseModal>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import BaseModal from "../modal/BaseModal.vue";
import RegisterModal from "./RegisterModal.vue";

export default {
  name: "LoginModal",
  components: {
    BaseModal,
    RegisterModal,
  },
  props: {
    show: { type: Boolean, default: false },
  },
  emits: ["update:show"],
  data() {
    return {
      email: "",
      password: "",
      loading: false,
    };
  },
  computed: {
    ...mapGetters({
      errors: "errors",
    }),
  },
  methods: {
    ...mapActions({
      login: "login",
    }),
    closeLogin() {
      this.$emit("update:show", false);
    },
    openRegister() {
      this.closeLogin();
      this.$emit("open-register"); // parent can listen and open RegisterModal
    },
    authenticate() {
      this.loading = true;
      this.login({
        email: this.email,
        password: this.password,
      }).catch((error) => {
        this.loading = false;
        this.errors =
          error.response.data.error || error.response.data.errors;
      });
    },
  },
};
</script>
