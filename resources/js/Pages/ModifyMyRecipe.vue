<template>
  <TheHeader />
  <main>
    <form v-for="updateMyRecipe in recipe" :key="updateMyRecipe">
      <input type="text" v-model="updateMyRecipe.name" />
      <ul>
        <li><input type="text" v-model="updateMyRecipe.preparation_time" /></li>
        <li><input type="text" v-model="updateMyRecipe.cooking_time" /></li>
      </ul>
      <ul>
        <li
          v-for="(ingredient, index) in ingredients"
          :key="index"
          :id="'li' + index"
        >
          <input type="text" v-model="ingredient.name" />
          <input type="text" v-model="ingredient.quantity" />
          <input type="button" value="X" @click="deleteIngredient(index)" />
        </li>
        <AddIngredients />
      </ul>
      <textarea
        id=""
        cols="30"
        rows="10"
        v-model="updateMyRecipe.description"
      ></textarea>
    </form>
  </main>
  <TheFooter />
</template>

<script>
import TheHeader from "@/Components/TheHeader";
import AddIngredients from "@/Components/AddIngredients";
import TheFooter from "@/Components/TheFooter";
export default {
  components: {
    TheHeader,
    AddIngredients,
    TheFooter,
  },
  props: {
    recipe: Object,
    ingredients: Object,
  },
  data() {
    return {
      updateForm: {
        name: "",
        preparation_time: "",
        cooking_time: "",
        description: "",
        recipes_ingredients: [],
      },
      items: [],
      dataIngredients: [],
    };
  },
  methods: {
    deleteIngredient(index) {
      const myLi = document.getElementById("li" + index);
      myLi.remove();
    },
    createIngredient() {
      let index = 0;
      this.items.push(index++);
    },
  },
};
</script>