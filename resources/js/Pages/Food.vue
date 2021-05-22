<template>
  <TheHeader />
  <main id="food" class="wrapper">
    <div id="wrap">
      <h1 id="foodName"></h1>
      <img id="picFood" src="" alt="" />

      <h2>Informations nutritionnelles</h2>
      <img id="imgNutriscore" src="" alt="" />

      <h2>Repères nutritionnels pour 100 g</h2>
      <ul>
        <li><span id="energy"></span>kJ</li>
        <li><span id="fat"></span>g de matières grasses dont</li>
        <li><span id="saturatedFat"></span>g de gras saturés</li>
        <li><span id="protein"></span>g de protéines</li>
        <li><span id="sugar"></span>g de glucides</li>
        <li><span id="salt"></span>g de sel</li>
      </ul>
    </div>

    <div id="wrap1">
      <h2>Ingrédients:</h2>
      <p id="ingredients"></p>

      <h2>Additifs:</h2>
      <ul id="additives"></ul>

      <h2>Groupe Nova</h2>
      <img id="imgNova" src="" alt="" />

      <AddApiIngredient v-if="$page.props.auth.user" />
      <inertia-link id="button" href="register" as="button" v-else>Ajouter à ma recette</inertia-link>
    </div>
  </main>
  <TheFooter />
</template>

<script>
import TheHeader from "@/Components/TheHeader";
import AddApiIngredient from "@/Components/AddApiIngredient";
import TheFooter from "@/Components/TheFooter";
export default {
  components: {
    TheHeader,
    AddApiIngredient,
    TheFooter,
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
      const energy = product.nutriments.energy;
      const fat = product.nutriments.fat_100g;
      const saturatedFat = product.nutriscore_data.saturated_fat_value;
      const protein = product.nutriments.proteins_100g;
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
      document.getElementById("energy").innerText = energy;
      document.getElementById("fat").innerText = fat;
      document.getElementById("saturatedFat").innerText = saturatedFat;
      document.getElementById("protein").innerText = protein;
      document.getElementById("sugar").innerText = sugar;
      document.getElementById("salt").innerText = salt;
      document.getElementById("ingredients").innerText = ingredients;
    };
    xhr.send(); //Sends request to server
  },
};
</script>

<style lang="scss">
#wrap,
#wrap1 {
  display: inline-block;
  width: 50%;
  vertical-align: top;
  margin-top: 20px;
  margin-bottom: 20px;

  @media (max-width: 871px) {
    width: 100%;
  }
}

#foodName {
  font-size: 22px;
  font-weight: 600;
  width: 90%;
}
#picFood {
  max-height: 300px;
}

h2 {
  font-size: 22px;
  text-decoration: underline;
  margin-bottom: 10px;
}

#ingredients,
#additives,
#imgNutriscore,
#picfood,
#foodName {
  margin-bottom: 20px;
}

#button{
  display: block;
  background-color: #48bc8b;
  border-radius: 18px;
  margin-top: 20px;
}
</style>