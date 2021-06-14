<template>
  <TheHeader />
  <main v-for="myrecipe in recipe" :key="myrecipe" class="wrapper">
    <h1>{{ myrecipe.name }}</h1>
    <ul id="time">
      <li>{{ myrecipe.preparation_time }}</li>
      <li>{{ myrecipe.cooking_time }}</li>
    </ul>

    <h2>Ingrédients:</h2>
    <ul>
      <li
        v-for="api in ingredientsApi"
        :key="api"
        class="ingredientBlock"
        id="ingredientAPI"
      >
        <img
          :src="
            'https://static.openfoodfacts.org/images/products/' + api.picture
          "
          class="ingredientPicture"
        />
        <span class="apiName">
          {{ api.name }}
        </span>
        <span class="apiQuantity">
          {{ api.quantity }}
        </span>
        <img
          :src="
            'https://static.openfoodfacts.org/images/misc/nutriscore-' +
            api.nutriscore +
            '.svg'
          "
          class="ingredientNutriscore"
        />
      </li>
      <li
        v-for="ingredient in ingredients"
        :key="ingredient"
        class="ingredientBlock"
      >
        <span class="ingredientName">
          {{ ingredient.name }}
        </span>
        <span class="ingredientQuantity">
          {{ ingredient.quantity }}
        </span>
      </li>
    </ul>

    <h2>Préparation:</h2>
    <p>{{ myrecipe.description }}</p>

    <div id="button">
      <inertia-link :href="'/modifymyrecipe/' + myrecipe.id" as="button"
        >Modifier ma recette</inertia-link
      >
      <inertia-link :href="'/deletemyrecipe/' + myrecipe.id" as="button" id="deleteRecipe"
        >Supprimer ma recette</inertia-link
      >
    </div>
  </main>
  <TheFooter />
</template>

<script>
import TheHeader from "@/Components/TheHeader";
import TheFooter from "@/Components/TheFooter";

export default {
  components: {
    TheHeader,
    TheFooter,
  },
  props: {
    recipe: Object,
    ingredients: Object,
    ingredientsApi: Object,
  },
  methods: {
    deleteRecipe(id) {
      this.$inertia.post(this.route("deleteRecipe"));
    },
  },
};
</script>

<style lang="scss" scoped>
h1,
h2 {
  margin-top: 20px;
  margin-bottom: 10px;
  font-size: 28px;
  font-weight: 600;
}

h1,
#time {
  text-align: center;
}

#time li {
  display: inline-block;
  margin-top: 20px;
  margin-bottom: 20px;
}

#time li:first-child {
  margin-right: 6%;
}

.ingredientBlock {
  display: inline-block;
  vertical-align: middle;
  width: 27%;
  margin-right: 6%;
  margin-bottom: 20px;
  box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
  padding: 20px 0px 20px 0px;

  @media (max-width: 1800px) {
    width: 44%;
  }

  @media (max-width: 1100px) {
    width: 100%;
    margin-right: 0;
  }
}

#ingredientAPI {
  padding: 0;
}

@media only screen and (min-width: 1801px) {
  .ingredientBlock:nth-child(3n) {
    margin-right: 0;
  }
}

.ingredientPicture {
  margin-left: 3%;
  margin-right: 3%;
  height: 52px;
}

.apiQuantity {
  margin-left: 30%;
}

.apiQuantity,
.apiName {
  margin-bottom: 1%;
}

.ingredientNutriscore {
  float: right;
  margin-right: 3%;
  width: 90px;
}

.ingredientName {
  float: left;
  margin-left: 14%;
}

.ingredientQuantity {
  float: right;
  margin-right: 14%;
}

#button {
  text-align: right;
  margin-top: 20px;
  margin-bottom: 20px;

    @media (max-width: 1100px) {
    text-align: center;
  }
}

#deleteRecipe{
  margin-left: 6%;
}
</style>