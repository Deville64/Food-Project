<template>
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
    <input :id="'ingredientId' + index" type="text" style="display: none" />
    <input
      type="text"
      :id="'quantity' + index"
      className="quantity"
      placeholder="Choisir une quantité"
      autocomplete="off"
    />
    <input type="button" value="X" @click="deleteIngredient(index)" />
  </li>
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