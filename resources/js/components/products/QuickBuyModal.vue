<template>
  <div v-if="show" class="modal-overlay" @click.self="close">
    <div class="modal-content">
      <button class="modal-close" @click="close">×</button>
      <!-- Slot for custom content -->
      <slot />
    </div>
  </div>
</template>

<script>
export default {
  props: {
    show: {
      type: Boolean,
      default: false
    }
  },
  methods: {
    close() {
      this.$emit("close");
    }
  }
};
</script>

<style scoped>
/* Overlay */
.modal-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.6);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1050;
  animation: fadeIn 0.3s ease;
}

/* Content */
.modal-content {
  background: #FFFFE8 !important;
  border-radius: 16px;
  max-width: 1000px;
  width: 90%;

  height: 650px;

  padding: 20px;
  position: relative;
  animation: slideUp 0.35s ease;
  box-shadow: 0 10px 25px #f8f7f733;
}

.quickbuy-modal {
  max-width: 900px;   /* wider than default */
  width: 90%;         /* responsive */
}

/* Center properly */
.quickbuy-modal .modal-content {
  border-radius: 12px;
  padding: 20px;
}

/* Close button */
.modal-close {
  position: absolute;
  top: 10px;
  right: 15px;
  border: none;
  background: transparent;
  font-size: 1.8rem;
  cursor: pointer;
  line-height: 1;
  color: #333;
  transition: color 0.2s;
}
.modal-close:hover {
  color: #ff5722; /* Accent */
}

/* Animations */
@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}
@keyframes slideUp {
  from { transform: translateY(40px); opacity: 0; }
  to { transform: translateY(0); opacity: 1; }
}
</style>
