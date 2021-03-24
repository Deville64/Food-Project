<template>
  <TheHeader />
  <main id="recipeForm" class="wrapper">
    <h1>Creation de ma recette</h1>

    <form action="" method="post">
      <input
        id="recipeName"
        name="recipeName"
        type="text"
        placeholder="Nom de ma recette"
        autocomplete="off"
      />

      <ul>
        <li>
          <input
            name="preparationTime"
            type="text"
            placeholder="Temps de préparation"
            autocomplete="off"
          />
        </li>
        <li>
          <input
            name="cookingTime"
            type="text"
            placeholder="Temps de cuisson"
            autocomplete="off"
          />
        </li>
      </ul>

      <h2>Ingrédients: {{ ingredients }}</h2>
      <ul id="ingredients">
        <li>
          <img
            src="/img/general/addMore.png"
            alt=""
            id="moreIngredients"
            v-on:click="createIngredient()"
          />
          <p>Ajouter un ingrédient</p>
        </li>
      </ul>

      <h2>Préparation:</h2>
      <textarea
        name="preparation"
        id="preparation"
        cols="30"
        rows="10"
        autocomplete="off"
      ></textarea>

      <input type="submit" value="Valider" />
    </form>
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
    data: Array,
  },

  data() {
    let index = 0;
    return {
      ingredients: {},
    };
  },
  created() {
    axios
      .get("http://127.0.0.1:8000/ingredients")
      .then((response) => (this.ingredients = response.data))
      .catch((error) => console.log(error));
  },
  methods: {
    strstr(haystack, needle, bool) {
      let pos = 0;
      haystack += "";
      pos = haystack.indexOf(needle);

      if (pos === -1) {
        return false;
      } else {
        if (bool) {
          return haystack.substr(0, pos);
        } else {
          return haystack.slice(pos);
        }
      }
    },

    //Show hints depending on what is in ingredient input
    showHint(text, id) {
      let vm = this;
      if (text.length == 0) {
        document.getElementById(id).innerHTML = "";
        return;
      } else {
        for (ingredient in vm.ingredients) {
          if (vm.strstr(text, ingredient["name"].substr(0, text.length))) {
            let hint =
              hint +
              "<div v-on:click =selectHint(event," +
              ingredient["id"] +
              ")>" +
              ingredient["name"] +
              "</div>";
            document.getElementById(id).innerHTML = hint;
          }
        }
      }
    },

    selectHint(event, id) {
      let getHint = event.target;

      let getInputID = getHint.parentNode.id.replace("dropdown", "");
      let giveInputName = document.getElementById("ingredient" + getInputID);
      let giveInputId = document.getElementById("ingredientId" + getInputID);

      giveInputName.value = getHint.innerHTML;
      giveInputId.value = id;
    },

    //Create Ingredient, Quantity Inputs if click on add ingredient
    createIngredient() {
      const vm = this;
      this.index++;
      const getUl = document.getElementById("ingredients");

      const li = document.createElement("li");
      li.className = "ingredients";

      const ingredient = document.createElement("input");
      ingredient.placeholder = "Selectionner un ingrédient";
      ingredient.id = "ingredient" + this.index;
      ingredient.className = "ingredient";
      ingredient.autocomplete = "off";

      const div = document.createElement("div");
      div.id = "dropdown" + this.index;

      const ingredientId = document.createElement("input");
      ingredientId.id = "ingredientId" + this.index;
      ingredientId.style.display = "none";
      ingredientId.name = "ingredients[ingredientsId][]";

      const quantity = document.createElement("input");
      quantity.placeholder = "Choisir une quantité";
      quantity.id = "quantity" + this.index;
      quantity.className = "quantity";
      quantity.name = "ingredients[quantity][]";
      quantity.autocomplete = "off";

      getUl.appendChild(li);
      li.appendChild(ingredient);
      li.appendChild(ingredientId);
      li.appendChild(div);
      li.appendChild(quantity);

      return (document.getElementById(
        "ingredient" + this.index
      ).onkeyup = function () {
        vm.showHint(this.value, div.id);
      });
    },
  },
};
</script>
