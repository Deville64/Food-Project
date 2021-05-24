<template>
  <ul>
    <li
      v-for="(item, index) in ingredientNumber"
      :key="index"
      :id="'li' + index"
    >
        <input
          type="text"
          :id="'ingredient' + index"
          @keyup="showHint(index)"
          className="ingredient"
          placeholder="Selectionner un ingrédient"
          autocomplete="off"
        />

        <ul
          class="dropdownToCreate"
          :id="'dropdown' + index"
          style="display: none"
        >
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
          :id="'createdQuantity' + index"
          className="quantity"
          placeholder="Choisir une quantité"
          autocomplete="off"
        />
        <input type="button" value="X" @click="deleteIngredient(index)" />
    </li>
    <li>
      <img
        src="/img/general/addMore.png"
        alt=""
        id="moreIngredients"
        @click="createIngredient()"
      />
      <p>Ajouter un ingrédient</p>
    </li>
  </ul>
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
      ingredientNumber: [],
      dataIngredients: [],
      checkDataName: [],
    };
  },

  methods: {
    createIngredient() {
      let index = 1;
      this.ingredientNumber.push(index);
    },
    deleteIngredient(index) {
      let getinputName = document.getElementById("ingredient" + index);
      let name = getinputName.value;
      let number = this.checkDataName.indexOf(name);
      this.checkDataName.splice(number, 1);

      const myLi = document.getElementById("li" + index);
      myLi.remove();
    },
    selectHint(index, ingredientId) {
      const dropdown = document.getElementById("dropdown" + index);
      let getHint = document.getElementById("list" + ingredientId);
      let giveInputName = document.getElementById("ingredient" + index);
      let giveInputId = document.getElementById("ingredientId" + index);

      giveInputName.value = getHint.innerHTML;
      giveInputId.value = ingredientId;

      dropdown.style.display = "none";

      const vm = this;
      vm.checkDataName.push(giveInputName.value);
      giveInputName.setAttribute("readonly", "readonly");
      console.log(vm.checkDataName);
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
            //Check if data input with lower case and no accent match
            //with ingredients from DB with lower case and no accent
            //& display max 3 ingredients & not display ingredient that
            //is already selected previously
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
                  .substr(0, text.length) &&
              index < 3 &&
              !vm.checkDataName.includes(ingredient["name"])
            ) {
              index++;
              dropdown.style.display = "block";

              let element = {};
              element.id = ingredient["id"];
              element.name = ingredient["name"];
              vm.dataIngredients.push(element);
            }
          }
        };
        xmlhttp.send();
      }
    },
  },
};
</script>

<style lang="scss" scoped>
#moreIngredients {
  display: block;
  margin-left: auto;
  margin-right: auto;
  width: 75px;
  margin-top: 10px;
}
li {
  display: inline-block;
  vertical-align: middle;
  width: 33%;
  margin-bottom: 10px;
  text-align: center;
}

li:last-child {
  color: brown;
}
</style>