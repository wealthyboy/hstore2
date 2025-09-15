<template>
 <transition name="fade">

  <div
    v-if="show"
    class="modal fade show d-block"
    tabindex="-1"
    role="dialog"
  >
    <!-- Backdrop -->
    <div class="modal-backdrop fade show" @click.self="close"></div>

    <!-- Modal content -->
    <transition name="scale">

    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title">{{ title }}</h3>
          <button type="button" class="close" @click="close">
            <span>&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <slot />
        </div>
      </div>
    </div>
    </transition>
  </div>
  </transition>
</template>

<script>
export default {
  name: "BaseModal",
  props: {
    show: { type: Boolean, default: false },
    title: { type: String, default: "" },
  },
  emits: ["update:show"],
  methods: {
    close() {
      this.$emit("update:show", false);
    },
  },
};
</script>

<style scoped>

/* Fade for overlay */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

/* Scale + fade for dialog */
.scale-enter-active,
.scale-leave-active {
  transition: all 0.3s ease;
}
.scale-enter-from,
.scale-leave-to {
  transform: scale(0.95);
  opacity: 0;
}


.modal {
  background: rgba(0, 0, 0, 0.6);
  z-index: 1050;
}

.modal-dialog {
  max-width: 600px; /* wider than default (500px) */
  width: 90%;       /* responsive: shrink on small screens */
  z-index: 1060;
}

.modal-content {
  border-radius: 10px;
  padding: 10px;
}
</style>
