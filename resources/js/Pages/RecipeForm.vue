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

      <img src="/img/general/addMore.png" />
      <p>Ajouter une photo à votre recette</p>

      <ul id="time">
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
      <AddIngredients />

      <h2>Préparation:</h2>
      <textarea
        v-model="form.description"
        id="preparation"
        autocomplete="off"
        placeholder="Vous pouvez décrire ici les différentes étapes de votre recette"
      ></textarea>

      <div id="button">
        <input type="submit" value="Enregistrer" />
      </div>
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
    };
  },

  methods: {
    submit() {
      const dropdownToCreateLength = document.getElementsByClassName(
        "dropdownToCreate"
      ).length;
      const dropdownToCreateIndex = dropdownToCreateLength - 1;

      for (let index = 0; index <= dropdownToCreateIndex; index++) {
        let getIngredientId = document.getElementById("ingredientId" + index)
          .value;
        let getQuantity = document.getElementById("createdQuantity" + index)
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

<style lang="scss" scoped>
h1,
h2 {
  margin-top: 20px;
  margin-bottom: 10px;
  font-size: 28px;
  font-weight: 600;
}
 #recipeName, img{
   display: block;
   margin-left: auto;
   margin-right: auto;
 }

h1,
#time, p
{
  text-align: center;
}

img {
  text-align: center;
  width: 75px;
  margin-top: 20px;
  margin-bottom: 10px;
}

li {
  display: inline-block;
  margin-top: 20px;
  margin-bottom: 20px;
}
li:first-child{
  margin-right: 6%;
}

textarea {
  width: 100%;
  margin-top: 10px;
}

#button {
  text-align: right;
  margin-top: 20px;
  margin-bottom: 20px;
}
</style>