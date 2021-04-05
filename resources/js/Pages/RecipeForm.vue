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
        <li>
          <img
            src="/img/general/addMore.png"
            alt=""
            id="moreIngredients"
            @click="createIngredient()"
          />
          <p>Ajouter un ingrédient</p>
        </li>

        <li v-for="(item, index) in items" :key="index" :id="'li' + index">
          <input
            type="text"
            :id="'ingredient' + index"
            @keyup="showHint(index)"
            className="ingredient"
            placeholder="Selectionner un ingrédient"
            autocomplete="off"
          />

          <ul class="dropdown" :id="'dropdown' + index" style="display: none">
            <li
              v-for="ingredient in dataIngredients"
              :key="ingredient.name"
              @click="selectHint(index, ingredient.id)"
              :id="'list' + ingredient.id"
            >
              {{ ingredient.name }}
            </li>
          </ul>
          <input
            :id="'ingredientId' + index"
            type="text"
            style="display: none"
          />
          <input
            type="text"
            :id="'quantity' + index"
            className="quantity"
            placeholder="Choisir une quantité"
            autocomplete="off"
          />
          <input type="button" value="X" @click="deleteIngredient(index)" />
        </li>
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
import TheFooter from "@/Components/TheFooter";

export default {
  components: {
    TheHeader,
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
    deleteIngredient(index) {
      const myLi = document.getElementById("li" + index);
      myLi.remove();
    },
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
    createIngredient() {
      let index = 0;
      this.items.push(index++);
    },
    selectHint(index, ingredientId) {
      const dropdown = document.getElementById("dropdown" + index);
      let getHint = document.getElementById("list" + ingredientId);
      let giveInputName = document.getElementById("ingredient" + index);
      let giveInputId = document.getElementById("ingredientId" + index);

      giveInputName.value = getHint.innerHTML;
      giveInputId.value = ingredientId;

      dropdown.style.display = "none";
    },
    showHint(id) {
      const vm = this;
      const dropdown = document.getElementById("dropdown" + id);
      const text = document.getElementById("ingredient" + id).value;

      //Purge old results
      while (dropdown.children[0]) {
        dropdown.removeChild(dropdown.children[0]);
      }

      if (text.length == 0) {
        dropdown.style.display = "none";
      } else {
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "http://127.0.0.1:8000/ingredients");
        xmlhttp.onload = function () {
          const ingredients = JSON.parse(xmlhttp.responseText);
          let index = 0;
          for (let ingredient of ingredients) {
            //Check if input with lower case and no accent match with ingredients from DB with lower case and no accent
            if (
              text
                .toLowerCase()
                .normalize("NFD")
                .replace(/[\u0300-\u036f]/g, "")
                .substr(0, text.length) ==
              ingredient["name"]
                .toLowerCase()
                .normalize("NFD")
                .replace(/[\u0300-\u036f]/g, "")
                .substr(0, text.length)
            ) {
              if (index < 3) {
                index++;
                dropdown.style.display = "block";

                let element = {};
                element.id = ingredient["id"];
                element.name = ingredient["name"];
                vm.dataIngredients.push(element);
              }
            }
          }
        };
        xmlhttp.send();
      }
    },
  },
};
</script>
