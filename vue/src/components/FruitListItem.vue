<template>
  <div class="imageList">
    <div
      v-for="fruit in fruitList"
      :key="fruit.id"
      class="imageList-item"
    >
      <div class="imageList-item-img">
        <img
          :alt="'placeholder'"
          :src="`/images/placeholder.png`"
          :height="350"
          :width="350"
        />
      </div>
        <div class="imageList-item-descriptionContainer">
          <div class="fruit-item-description">
              <span>
              Name : {{ fruit.name }}
            </span>
              <span>
              Family : {{ fruit.family }}
            </span>
          </div>
          <a @click="addToFavorite(fruit.id)">
            <img width="30" height="30" :src="fruit.favorite ? 'https://www.svgrepo.com/show/14970/heart.svg' : 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/f1/Heart_coraz%C3%B3n.svg/2048px-Heart_coraz%C3%B3n.svg.png'"/>
          </a>
      </div>
      <table id="nutritions">
        <tr>
          <th>Calories</th>
          <th>Fat</th>
          <th>Sugar</th>
          <th>Carbohydrates</th>
          <th>Protein</th>
        </tr>
        <tr>
          <td>{{ fruit.nutritions.calories }} calories</td>
          <td>{{ fruit.nutritions.fat }}g</td>
          <td>{{ fruit.nutritions.sugar }}g</td>
          <td>{{ fruit.nutritions.carbohydrates }}g</td>
          <td>{{ fruit.nutritions.protein }}g</td>
        </tr>
      </table>
    </div>
  </div>
</template>
<script>
export default {
  name: "FruitListItem",
  props: {
    fruitList: Object,
    addToFavorite: Function,
  },
  methods: {

  }
};
</script>
