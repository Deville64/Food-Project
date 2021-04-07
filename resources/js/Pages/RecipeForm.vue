<template>
  <TheHeader />
  <main id="recipeForm" class="wrapper">
    <h1>Creation de ma recette</h1>
    <form @submit.prevent="submit">
      <input
        id="recipeName"
        v-model="form.name"
        type="text"
        placeholder="Nom de ma recette"
        autocomplete="off"
      />

      <ul>
        <li>
          <input
            v-model="form.preparation_time"
            type="text"
            placeholder="Temps de préparation"
            autocomplete="off"
          />
        </li>
        <li>
          <input
            v-model="form.cooking_time"
            type="text"
            placeholder="Temps de cuisson"
            autocomplete="off"
          />
        </li>
      </ul>

      <h2>Ingrédients:</h2>
      <ul id="ingredients">
        <AddIngredients />
      </ul>

      <h2>Préparation:</h2>
      <textarea
        v-model="form.description"
        id="preparation"
        cols="30"
        rows="10"
        autocomplete="off"
      ></textarea>

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

  data() {
    return {
      form: {
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
    submit() {
      const dropdownLength = document.getElementsByClassName("dropdown").length;
      const dropdownIndex = dropdownLength - 1;

      for (let index = 0; index <= dropdownIndex; index++) {
        let getQuantity = document.getElementById("quantity" + index).value;
        let getIngredientId = document.getElementById("ingredientId" + index)
          .value;
        this.form.recipes_ingredients.push({
          ingredients_id: getIngredientId,
          quantity: getQuantity,
        });
      }
      console.log(this.form.recipes_ingredients[0]["ingredients_id"]);
      this.$inertia.post(this.route("createRecipe", this.form));
    },
  },
};
</script>
