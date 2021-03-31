<template>
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
</template>

<script>
export default {
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
              if (index < 4) {
                index++;
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