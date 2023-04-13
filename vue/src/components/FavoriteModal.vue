<template>
  <div class="modal" v-if="isOpenFavoriteModal">
    <div class="modalBackground" @click="closeFavoriteModal()"></div>
    <div class="modal-item">
      <div class="modal-closeBtn" @click="closeFavoriteModal()"></div>
      <div class="imageList">
        <div
            v-for="fruit in favoriteList"
            :key="fruit.id"
            class="imageList-item"
        >
          <div class="imageList-item-img">
            <img
                :alt="'placeholder'"
                :src="`/images/placeholder.png`"
                :height="250"
                :width="250"
            />
          </div>
          <div class="imageList-item-descriptionContainer">
            <div class="imageList-item-author">
              {{ fruit.name }}
            </div>
            <div class="imageList-item-id">
              {{ fruit.family }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "PageLimit",
  props: {
    isOpenFavoriteModal: Boolean,
    closeFavoriteModal: Function,
    favoriteList: Array,
  },
};
</script>
