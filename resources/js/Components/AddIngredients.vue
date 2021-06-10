<template>
  <ul>
    <li
      v-for="(item, index) in ingredientNumber"
      :key="index"
      :id="'li' + index"
      class="ingredientBlock"
    >
      <input
        type="text"
        :id="'ingredient' + index"
        @keyup="showHint(index)"
        className="ingredientInput"
        placeholder="Ingrédient"
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
          class="list"
        >
          {{ ingredient.name }}
        </li>
      </ul>
      <input :id="'ingredientId' + index" type="text" style="display: none" />
      <input
        type="text"
        :id="'createdQuantity' + index"
        className="quantity"
        placeholder="Quantité"
        autocomplete="off"
        size="8"
      />
      <input
        type="button"
        class="deleteIngredient"
        value="X"
        @click="deleteIngredient(index)"
      />
    </li>
    <li class="ingredientBlock">
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
.ingredientBlock {
  display: inline-block;
  vertical-align: middle;
  width: 27%;
  margin-right: 6%;
  margin-bottom: 20px;
  // text-align: center;
  box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
  padding: 20px 0px 20px 0px;

  @media (max-width: 1800px) {
    width: 44%;
  }

  @media (max-width: 1100px) {
    width: 100%;
    margin-right: 0;
  }
}

@media only screen and (max-width: 1801px) {
  .ingredientBlock:nth-last-child(2) {
    margin-right: 0;
  }
}

@media only screen and (min-width: 1801px) {
  .ingredientBlock:nth-child(3n) {
    margin-right: 0;
  }
}

.ingredientBlock:last-child {
  width: 33%;
  text-align: center;
  box-shadow: none;
  margin-left: 0;
  padding: 0;

  @media (max-width: 1800px) {
    width: 50%;
  }

  @media (max-width: 1100px) {
    width: 100%;
  }
}

.ingredientInput {
  margin-right: 14%;
  margin-left: 3%;
}

.dropdownToCreate {
  position: absolute;
  margin-left: 0.6%;
  width: 147px;
  text-align: center;
  background-color: #3fac7e;

  @media (max-width: 1800px) {
    margin-left: 1%;
  }

  @media (max-width: 1100px) {
    margin-left: 2.2%;
  }
}

.deleteIngredient {
  float: right;
  margin-right: 2%;
}

.list {
  margin: 10px 0 10px 0;
  cursor: pointer;
}
</style>