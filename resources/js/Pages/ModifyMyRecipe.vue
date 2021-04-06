<template>
  <TheHeader />
  <main v-for="myrecipe in recipe" :key="myrecipe">
    <input type="text" :value="myrecipe.name" />
    <ul>
        <li>{{myrecipe.preparation_time}}</li>
        <li>{{myrecipe.cooking_time}}</li>
    </ul>
    <ul>
        <li v-for="ingredient in ingredients" :key="ingredient">
            <input type="text" :value="ingredient.name">
            <input type="text" :value="ingredient.quantity">
        </li>
    </ul>
    <textarea id="" cols="30" rows="10">{{ myrecipe.description }}</textarea>
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