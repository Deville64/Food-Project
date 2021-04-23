<template>
  <TheHeader />
  <main v-for="myrecipe in recipe" :key="myrecipe">
    <h1>{{ myrecipe.name }}</h1>
    <ul>
      <li>{{ myrecipe.preparation_time }}</li>
      <li>{{ myrecipe.cooking_time }}</li>
    </ul>
    <ul>
      <li v-for="api in ingredientsApi" :key="api">
        <img
          :src="
            'https://static.openfoodfacts.org/images/products/' + api.picture
          "
          alt=""
        />
        {{ api.name }}
        {{ api.quantity }}
        <img
          :src="
            'https://static.openfoodfacts.org/images/misc/nutriscore-' +
            api.nutriscore +
            '.svg'
          "
          alt=""
        />
      </li>
      <li v-for="ingredient in ingredients" :key="ingredient">
        {{ ingredient.name }}
        {{ ingredient.quantity }}
      </li>
    </ul>
    <p>{{ myrecipe.description }}</p>
    <inertia-link :href="'/modifymyrecipe/' + myrecipe.id"
      >Modifier ma recette</inertia-link
    >
    <inertia-link type="button" :href="'/deletemyrecipe/' + myrecipe.id"
      >Supprimer ma recette</inertia-link
    >
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