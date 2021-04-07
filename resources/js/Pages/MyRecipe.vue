<template>
  <TheHeader />
  <main v-for="myrecipe in recipe" :key="myrecipe">
    <h1>{{ myrecipe.name }}</h1>
    <ul>
      <li>{{ myrecipe.preparation_time }}</li>
      <li>{{ myrecipe.cooking_time }}</li>
    </ul>
    <ul>
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
    <!-- <input type="button" value="Supprimer ma recette"  @click="deleteRecipe(myrecipe.id)"/> -->
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
  },
  methods: {
    deleteRecipe(id) {
      this.$inertia.post(this.route("deleteRecipe"));
    },
  },
};
</script>