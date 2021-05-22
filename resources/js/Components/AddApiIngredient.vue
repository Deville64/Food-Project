<template>
  <input
    id="button"
    type="button"
    value="Ajouter à ma recette"
    @click="showRecipes"
  />
  <ul>
    <li
      v-for="(recipe, index) in recipes"
      :key="index"
      :id="'recipename' + index"
    >
      <span @click="addIngredient(index)">{{ recipe.name }}</span>
      <span :id="'idRecipe' + index" style="display: none">{{
        recipe.id
      }}</span>
    </li>
  </ul>
</template>

<script>
export default {
  data() {
    return {
      recipes: [],
      form: {},
    };
  },
  methods: {
    showRecipes() {
      const vm = this;
      let xmlhttp = new XMLHttpRequest();
      xmlhttp.open("GET", "http://127.0.0.1:8000/getrecipesnames");
      xmlhttp.onload = function () {
        const recipes = JSON.parse(xmlhttp.responseText);
        for (let recipe of recipes) {
          //Check if input with lower case and no accent match with ingredients from DB with lower case and no accent
          let element = {};
          element.id = recipe["id"];
          element.name = recipe["name"];
          vm.recipes.push(element);
        }
      };
      xmlhttp.send();
    },
    addIngredient(index) {
      const getIdRecipe = document.getElementById("idRecipe" + index).innerText;
      const objIdRecipe = { recipe_id: getIdRecipe };
      Object.assign(this.form, objIdRecipe);

      const foodIdAPI = sessionStorage.getItem("foodID");
      const objFoodIdApi = { id_api: foodIdAPI };
      Object.assign(this.form, objFoodIdApi);

      const getFoodName = document.getElementById("foodName").innerText;
      const objFoodName = { name_api: getFoodName };
      Object.assign(this.form, objFoodName);

      const getPicture = document.getElementById("picFood").src;
      const picture = getPicture.substring(49);
      const objPicture = { picture: picture };
      Object.assign(this.form, objPicture);

      const getNutriscore = document.getElementById("imgNutriscore").src;
      const nutriscore = getNutriscore.substring(56, 57);
      const objNutriscore = { nutriscore: nutriscore };
      Object.assign(this.form, objNutriscore);

      this.$inertia.post(this.route("addApiIngredient", this.form));
    },
  },
};
</script>

<style lang="scss" scoped>
ul {
  background-color: #ededed;
  width: 150px;
  margin-top: 10px;
  box-shadow: 10px 10px 5px gray;
}

li:first-child {
  padding-top: 5px;
}

li {
  padding-top: 5px;
  padding-bottom: 5px;
  text-align: center;
}

li:hover{
  color: white;
  background-color: #48bc8b;
}

span{
  cursor: pointer;
}
</style>