<template>
  <FruitListItem
    :fruitList="fruitsList"
    :addToFavorite="addToFavorite"
  />
  <FavoriteModal :favoriteList="favoriteList" :isOpenFavoriteModal="isOpenFavoriteModal" :closeFavoriteModal="closeFavoriteModal"/>
  <div class="footer">
    <div class="footer-pagination">
      <a @click="openFavoriteModal()" class="footer-paginationItem">Favorite List</a>
    </div>
    <PageNumber
      :totalPage="totalPage"
      :activePageNumber="activePageNumber"
      :pageSetter="setPages"
    />
    <div class="footer-pagination">
      <input class="footer-paginationItem" placeholder="Search by name" type="text" v-model="searchName" v-on:change="handleChangeSearchName"/>
      <input class="footer-paginationItem" placeholder="Search by family" type="text" v-model="searchFamily" v-on:change="handleChangeSearchFamily"/>
      <a @click="onSubmitSearch()" class="footer-paginationItem">Search</a>
      <a @click="onSubmitReset()" class="footer-paginationItem">Reset</a>
    </div>
  </div>
</template>

<script>
import axios from "axios";

import PageNumber from "./PageNumber.vue";
import FavoriteModal from "./FavoriteModal.vue";
import FruitListItem from "./FruitListItem.vue";

export default {
  name: "FruitList",
  methods: {
    setPages(pageNumber) {
      this.activePageNumber = pageNumber;
    },
    setIsSearch(isSearch) {
      this.isSearch = isSearch;
    },
    setFavoriteList(favoriteList) {
      this.favoriteList = favoriteList;
    },
    async fetchData(page) {
      const { data } = await axios.get(`http://localhost:92/api/fruits/list?page=${this.activePageNumber}`, {headers: {
          // "Access-Control-Allow-Origin": "*",
        }});
      this.fruitsList = data?.data.map(item => {
        item.favorite = !!this.checkIssetFavorite(item.id);
        return item;
      });
      this.totalPage = data?.totalNumberOfPage;
      this.setPages(page);
    },
    async fetchDataFavoriteIds(favorites) {
      let ids = "";
      for (let i = 0; i < favorites.length; i++) {
        ids += 'ids[]=' + favorites[i] + '&';
      }
      if (ids !== '') {
        ids = ids.substring(0, ids.length - 1);
          const { data } = await axios.get(`http://localhost:92/api/fruits/get_by_ids?` + ids, {headers: {
              // "Access-Control-Allow-Origin": "*",
            }});
        this.favoriteList = data?.data;
      }

    },
    async searchData(page) {
      this.fruitsList = [];
      const { data } = await axios.get(`http://localhost:92/api/fruits/search?page=${this.activePageNumber}&name=${this.searchName}&family=${this.searchFamily}`, {headers: {
          // "Access-Control-Allow-Origin": "*",
        }});
      this.fruitsList = data?.data.map(item => {
        item.favorite = !!this.checkIssetFavorite(item.id);
        return item;
      });
      this.totalPage = data?.totalNumberOfPage;
      this.setPages(page);
      this.setIsSearch(true);
    },

    checkIssetFavorite(id) {
      const items = JSON.parse(localStorage.getItem('favorite')) || [];
      const itemExists = items.some(item => item == id);
      return !itemExists;
    },
    addToFavorite(id) {
      let idFruitsList = 0;
      for (let i = 0; i < this.fruitsList.length; i++) {
        if (this.fruitsList[i].id === id) {
          idFruitsList = i;
          break;
        }
      }

      const favorites = JSON.parse(localStorage.getItem('favorite')) || [];
      const itemIndex = favorites.findIndex((i) => i === id);
      if (itemIndex === -1) {
        if (favorites.length < 10) {
          this.fruitsList = this.fruitsList.map(item => {
            if (item.id === id) item.favorite = !item.favorite;
            return item;
          });
          favorites.push(id);
        }
      } else {
        favorites.splice(itemIndex, 1);
        this.fruitsList = this.fruitsList.map(item => {
          if (item.id === id) item.favorite = !item.favorite;
          return item;
        });
      }
      localStorage.setItem('favorite', JSON.stringify(favorites));
      this.mergeFavoriteList(favorites);
    },
    openFavoriteModal() {
      this.isOpenFavoriteModal = true;
    },
    closeFavoriteModal() {
      this.isOpenFavoriteModal = false;
    },
    mergeFavoriteList(favorites) {
      this.fetchDataFavoriteIds(favorites)
    },
    handleChangeSearchName(e) {
      this.searchName = e.target.value;
    },
    handleChangeSearchFamily(e) {
      this.searchFamily = e.target.value;
    },
    onSubmitSearch(){
      this.searchData(this.activePageNumber, this.searchName, this.searchFamily)
    },
    onSubmitReset(){
      this.setIsSearch(false)
      this.fetchData(1)
      this.searchName = ''
      this.searchFamily = ''
    }
  },
  watch: {
    activePageNumber: function (newValue) {
      if (this.isSearch) {
        this.searchData(newValue, this.searchName, this.searchFamily)
      } else {
        this.fetchData(newValue)
      }
    }
  },
  components: {
    PageNumber,
    FruitListItem,
    FavoriteModal
  },
  props: {
    fruit: Object,
  },
  data() {
    return {
      totalPage: 0,
      activePageNumber: 1,
      fruitsList: [],
      favoriteList: [],
      isOpenFavoriteModal: false,
      searchName: '',
      searchFamily: '',
    };
  },

  async mounted() {
    await this.fetchData(this.activePageNumber);

    // merge favorite list
    const favorites = JSON.parse(localStorage.getItem('favorite')) || [];
    this.mergeFavoriteList(favorites);

  },
};
</script>
<style scoped>
@import "../assets/styles/css.scss";
</style>
