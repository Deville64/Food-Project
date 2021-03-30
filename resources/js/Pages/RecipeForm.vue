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

      <h2>Ingrédients:</h2>
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
      index,
    };
  },

  methods: {
    //Show hints depending on what is in ingredient input
    showHint(text, id) {
      const dropdown = document.getElementById(id);
      //Purge old results
      while (dropdown.firstChild) {
        dropdown.removeChild(dropdown.firstChild);
      }

      if (text.length == 0) {
        dropdown.innerHTML = "";
      } else {
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "http://127.0.0.1:8000/ingredients");
        xmlhttp.onload = function () {

          const ingredients = JSON.parse(xmlhttp.responseText);
          for (let ingredient of ingredients) {
            if (
              text.toLowerCase().substr(0, text.length) ==
              ingredient["name"].toLowerCase().substr(0, text.length)
            ) {
              console.log(ingredient)
              dropdown.style.display = "block";

              const li = document.createElement("li");
              li.innerText = ingredient["name"];

              li.addEventListener("click", function (event) {
                let getHint = event.target;
                let getID = getHint.parentNode.id.replace("dropdown", "");
                let giveInputName = document.getElementById(
                  "ingredient" + getID
                );
                let giveInputId = document.getElementById(
                  "ingredientId" + getID
                );

                giveInputName.value = getHint.innerHTML;
                giveInputId.value = ingredient["id"];

                dropdown.style.display = "none";
              });

              const ul = document.getElementById(id);
              ul.appendChild(li);
            }
          }
        };
        xmlhttp.send();
      }
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

      const ul = document.createElement("ul");
      ul.id = "dropdown" + this.index;

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
      li.appendChild(ul);
      li.appendChild(quantity);

      return (document.getElementById(
        "ingredient" + this.index
      ).onkeyup = function () {
        vm.showHint(this.value, ul.id);
      });
    },
  },
};
</script>
