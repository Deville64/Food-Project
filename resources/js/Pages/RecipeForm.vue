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

      <VForTest />

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
import ChooseIngredients from "@/Components/ChooseIngredients";
import VForTest from "@/Components/VForTest";
import TheFooter from "@/Components/TheFooter";

export default {
  components: {
    TheHeader,
    ChooseIngredients,
    VForTest,
    TheFooter,
  },

  data() {
    return {
      form: {
        name: "",
        preparation_time: "",
        cooking_time: "",
        description: "",
      },
    };
  },

  methods: {
    submit() {
      this.$inertia.post(this.route("createRecipe", this.form));
    },
  },
};
</script>
