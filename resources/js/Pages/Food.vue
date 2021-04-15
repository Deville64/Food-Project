<template>
  <TheHeader />
  <main id="food" class="wrapper">
    <div id="Wrap">
      <h1 id="foodName"></h1>
      <img id="picFood" src="" alt="" />

      <h2>Informations nutritionnelles</h2>
      <img id="imgNutriscore" src="" alt="" />

      <h2>Repères nutritionnels pour 100 g</h2>
      <ul>
        <li><span id="fat"></span>g</li>
        <li><span id="saturatedFat"></span>g</li>
        <li><span id="sugar"></span>g</li>
        <li><span id="salt"></span>g</li>
      </ul>
    </div>

    <div id="wrap1">
      <h2>Ingrédients:</h2>
      <p id="ingredients"></p>

      <h2>Additifs:</h2>
      <ul id="additives"></ul>

      <h2>Groupe Nova</h2>
      <img id="imgNova" src="" alt="" />

      <input type="button" value="Ajouter à ma recette" @click="showRecipes" />
      <ul v-for="(recipe, index) in recipes" :key="index">
        <li :id="'recipename' + index">{{ recipe.name }}</li>
      </ul>
    </div>
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
      recipes: [],
    };
  },
  mounted() {
    //Use the food ID in local Storage to show main info in food page
    const foodID = sessionStorage.getItem("foodID"); // get back foodID from the food search
    const xhr = new XMLHttpRequest(); // interact with server
    const url =
      "https://world.openfoodfacts.org/api/v0/product/" + foodID + ".json"; //url to go to JSON file
    console.log(foodID);
    xhr.open("GET", url);

    xhr.onload = function () {
      const openFoodFactDb = JSON.parse(xhr.responseText);
      const product = openFoodFactDb.product;

      const foodName = product.product_name_fr;
      const picFood = product.image_front_url;
      const nutriscore = product.nutriscore_grade;
      const imgNutriscore =
        "https://static.openfoodfacts.org/images/misc/nutriscore-" +
        nutriscore +
        ".svg";
      const nova = product.nova_groups;
      const imgNova =
        "https://static.openfoodfacts.org/images/misc/nova-group-" +
        nova +
        ".svg";
      const ingredients = product.ingredients_text;
      const fat = product.nutriments.fat_100g;
      const saturatedFat = product.nutriscore_data.saturated_fat_value;
      const sugar = product.nutriments.sugars_100g;
      const salt = product.nutriments.salt_100g;

      //Go through all additives from API
      for (
        let index = 0;
        index < product.additives_original_tags.length;
        index++
      ) {
        const list = document.getElementById("additives");
        const li = document.createElement("li");

        const additives = product.additives_original_tags[index];

        const additivesNode = document.createTextNode(additives.substring(3));
        li.appendChild(additivesNode);
        list.appendChild(li);
      }

      if (nutriscore != undefined) {
        document.getElementById("imgNutriscore").src = imgNutriscore;
      }
      if (nova != undefined) {
        document.getElementById("imgNova").src = imgNova;
      }
      document.getElementById("foodName").innerText = foodName;
      document.getElementById("picFood").src = picFood;
      document.getElementById("fat").innerText = fat;
      document.getElementById("saturatedFat").innerText = saturatedFat;
      document.getElementById("sugar").innerText = sugar;
      document.getElementById("salt").innerText = salt;
      document.getElementById("ingredients").innerText = ingredients;
    };
    xhr.send(); //Sends request to server
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
  },
};
</script>