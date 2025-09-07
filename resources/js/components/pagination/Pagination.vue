<template>
  <!-- Pagination -->
  <div class="d-flex justify-content-between align-items-center my-4 flex-wrap">
    <!-- Showing info -->
    <div class="text-muted small mb-2 mb-md-0">
      Showing <strong>{{ meta.from }}</strong> to <strong>{{ meta.to }}</strong> of <strong>{{ meta.total }}</strong> results
    </div>

    <!-- Page numbers -->
    <ul class="pagination circle-pagination mb-0">
      <!-- Prev -->
      <li class="page-item" :class="{ disabled: meta.current_page === 1 }">
        <a
          href="#"
          class="page-link d-flex align-items-center justify-content-center"
          @click.prevent="switched(meta.current_page - 1)"
        >
          <i class="fa fa-angle-double-left"></i>
        </a>
      </li>

      <!-- Numbers -->
      <li
        v-for="x in meta.last_page"
        :key="x"
        class="page-item"
        :class="{ active: meta.current_page === x }"
      >
        <a
          href="#"
          class="page-link"
          @click.prevent="switched(x)"
        >
          {{ x }}
        </a>
      </li>

      <!-- Next -->
      <li class="page-item" :class="{ disabled: meta.current_page === meta.last_page }">
        <a
          href="#"
          class="page-link d-flex align-items-center justify-content-center"
          @click.prevent="switched(meta.current_page + 1)"
        >
          <i class="fa fa-angle-double-right"></i>
        </a>
      </li>
    </ul>
  </div>
  <!-- End Pagination -->
</template>

<script>
export default {
  props: {
    meta: Object,
    useUrl: Boolean
  },
  methods: {
    switched(page) {
      if (this.pageIsFinished(page)) return;

      this.$emit("pagination:switched", page);

      if (this.useUrl) {
        this.$router.replace({ query: { page } });
      } else {
        return axios
          .get(this.meta.path + "?page=" + page)
          .then(response => {
            this.$store.commit("setReviews", response.data.data);
            this.$store.commit("setReviewsMeta", response.data.meta);
          })
          .catch(() => {});
      }
    },
    pageIsFinished(page) {
      return page <= 0 || page > this.meta.last_page;
    }
  }
};
</script>

<style scoped>
.circle-pagination .page-link {
  width: 40px;
  height: 40px;
  line-height: 38px;
  text-align: center;
  border-radius: 50%; /* 👈 circle */
  padding: 0;
  margin: 0 4px;
  border: 1px solid #dee2e6;
  color: #2c3639;
  transition: all 0.2s ease;
}

.circle-pagination .page-link:hover {
  background-color: #f1f3f5;
  text-decoration: none;
  color: #000;
}

.circle-pagination .page-item.active .page-link {
  background-color: #2c3639;
  border-color: #2c3639;
  color: #fff;
}

.circle-pagination .page-item.disabled .page-link {
  pointer-events: none;
  opacity: 0.4;
}
</style>
