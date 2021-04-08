<template>
  <TheHeader />
  <main>
    <form @submit.prevent="submit(recipe[0].id)">
      <input type="text" v-model="form.name" />
      <ul>
        <li><input type="text" v-model="form.preparation_time" /></li>
        <li><input type="text" v-model="form.cooking_time" /></li>
      </ul>
      <ul class="dropdownToUpdate">
        <li
          v-for="(ingredient, index) in ingredients"
          :key="index"
          :id="'updateIngredient' + index"
        >
          {{ ingredient.name }}
          <span style="display: none" :id="'ingredientId' + index">{{ ingredient.id }}</span>
          <input
            type="text"
            :id="'quantity' + index"
            v-model="ingredient.quantity"
          />
          <input type="button" value="X" @click="deleteIngredient(index)" />
        </li>
      </ul>
      <AddIngredients />
      <textarea id="" cols="30" rows="10" v-model="form.description"></textarea>
      <input type="submit" value="Enregistrer" />
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
      form: {
        id: this.recipe[0].id,
        name: this.recipe[0].name,
        preparation_time: this.recipe[0].preparation_time,
        cooking_time: this.recipe[0].cooking_time,
        description: this.recipe[0].description,
        ingredientsToUpdate: [],
        ingredientsToDelete: [],
        ingredientsToAdd: [],
      },
    };
  },
  methods: {
    deleteIngredient(index) {
      let getIngredientId = document.getElementById("ingredientId" + index)
        .innerText;
      this.form.ingredientsToDelete.push({
        ingredients_id: getIngredientId,
      });
      const myLi = document.getElementById("updateIngredient" + index);
      myLi.remove();
      console.log(this.form.ingredientsToDelete);
    },
    submit(id) {
      const dropdownToUpdateLength = document.getElementsByClassName("dropdownToUpdate").length;
      const dropdownToUpdateIndex = dropdownToUpdateLength - 1;

      if (dropdownToUpdateIndex != 0) {
        for (let index = 0; index <= dropdownToUpdateIndex; index++) {
          let getQuantity = document.getElementById("quantity" + index).value;
          let getIngredientId = document.getElementById("ingredientId" + index)
            .innerText;
          this.form.ingredientsToUpdate.push({
            ingredients_id: getIngredientId,
            quantity: getQuantity,
          });
        }
      }

      const dropdownToCreateLength = document.getElementsByClassName("dropdownToCreate").length;
      const dropdownToCreateIndex = dropdownToCreateLength - 1;

      for (let index = 0; index <= dropdownToCreateIndex; index++) {
        let getQuantity = document.getElementById("quantity" + index).value;
        let getIngredientId = document.getElementById("ingredientId" + index)
          .value;
        this.form.ingredientsToAdd.push({
          ingredients_id: getIngredientId,
          quantity: getQuantity,
        });
      }
      this.$inertia.post(this.route("updateRecipe", this.form));
    },
  },
};
</script>