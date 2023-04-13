<template>
  <div class="footer-pagination">
    <div v-for="page in totalPage" :key="page" @click="this.pageSetter(page)">
      <div
        class="footer-paginationItem footer-paginationItem-active"
        v-if="page === activePageNumber"
      >
        {{ page }}
      </div>
      <div class="footer-paginationItem" v-else>{{ page }}</div>
    </div>
  </div>
</template>
<script>
export default {
  name: "PageNumber",
  props: {
    totalPage: Number,
    activePageNumber: Number,
    pageSetter: Function,
  },
  data() {
    return {};
  },
  methods: {
    setPages(page) {
      this.$emit("click", page);
    },
  },
};
</script>
