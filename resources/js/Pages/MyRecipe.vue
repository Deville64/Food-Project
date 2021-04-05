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
};
</script>