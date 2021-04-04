<template>
  <TheHeader />
  <main id="myRecipes" class="wrapper">
    <h1>Mes recettes</h1>
    <ul id="recipes">
      <li v-for="recipe in recipes" :key="recipe">
        <inertia-link :href="'/myrecipe/' + recipe.id">{{
          recipe.name
        }}</inertia-link>
        <h2></h2>
      </li>
      <li>
        <inertia-link href="/recipeform"
          ><img id="addMore" src="/img/general/addMore.png" alt=""
        /></inertia-link>
      </li>
    </ul>
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
    recipes: Array,
  },
};
</script>