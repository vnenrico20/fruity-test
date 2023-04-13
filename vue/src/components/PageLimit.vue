<template>
  <div class="footer-limit">
    <select @change="setLimit($event)" class="footer-limitOption">
      <option>25</option>
      <option>50</option>
      <option>75</option>
      <option>100</option>
    </select>
  </div>
</template>
<script>
export default {
  name: "PageLimit",
  props: {
    setLimit: Function,
  },
};
</script>
