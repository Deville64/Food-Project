<template>
  <TheHeader />
  <main class="wrapper">
    <form @submit.prevent="submit(recipe[0].id)">
      <h1>Modification de ma recette</h1>
      <input type="text" id="recipeName" v-model="form.name" autocomplete="off"/>
      <ul id="time">
        <li><input type="text" v-model="form.preparation_time" autocomplete="off"/></li>
        <li><input type="text" v-model="form.cooking_time" autocomplete="off"/></li>
      </ul>

      <h2>Ingrédients:</h2>
      <ul id="apiDropdownToUpdate">
        <li
          v-for="(api, index) in ingredientsApi"
          :key="index"
          :id="'updateIngredient' + index"
          class="ApiIngredientBlock"
        >
          <img
            :src="
              'https://static.openfoodfacts.org/images/products/' + api.picture
            "
            class="ingredientPicture"
          />
          <span class="apiName">
            {{ api.name }}
          </span>
          <span style="display: none" :id="'apiIngredientId' + index">{{
            api.id
          }}</span>
          <input
            type="text"
            :id="'apiQuantity' + index"
            v-model="api.quantity"
            size="8"
            class="apiQuantity"
            autocomplete="off"
          />
          <img
            :src="
              'https://static.openfoodfacts.org/images/misc/nutriscore-' +
              api.nutriscore +
              '.svg'
            "
            class="ingredientNutriscore"
          />
          <input type="button" value="X" @click="deleteIngredient(index)" />
        </li>
      </ul>
      <ul id="dropdownToUpdate">
        <li
          v-for="(ingredient, index) in ingredients"
          :key="index"
          :id="'updateIngredient' + index"
          class="ingredientBlock"
        >
          <span class="ingredientName">
            {{ ingredient.name }}
          </span>
          <span style="display: none" :id="'ingredientId' + index">{{
            ingredient.id
          }}</span>
          <input
            type="text"
            :id="'quantity' + index"
            v-model="ingredient.quantity"
            size="8"
            autocomplete="off"
          />
          <input
            type="button"
            value="X"
            id="deleteIngredient"
            @click="deleteIngredient(index)"
          />
        </li>
      </ul>
      <AddIngredients />
      <textarea v-model="form.description"></textarea>
      <div id="button">
        <input type="submit" value="Enregistrer" />
      </div>
    </form>
  </main>
  <TheFooter />
</template>

<script>
import TheHeader from "@/Components/TheHeader";
import AddIngredients from "@/Components/AddIngredients";
import TheFooter from "@/Components/TheFooter";
export default {
  components: {
    TheHeader,
    AddIngredients,
    TheFooter,
  },
  props: {
    recipe: Object,
    ingredients: Object,
    ingredientsApi: Object,
  },
  data() {
    return {
      form: {
        id: this.recipe[0].id,
        name: this.recipe[0].name,
        preparation_time: this.recipe[0].preparation_time,
        cooking_time: this.recipe[0].cooking_time,
        description: this.recipe[0].description,
        ingredientsToUpdate: [],
        ingredientsToDelete: [],
        ingredientsToAdd: [],
      },
    };
  },
  methods: {
    deleteIngredient(index) {
      let getIngredientId = document.getElementById(
        "ingredientId" + index
      ).innerText;
      this.form.ingredientsToDelete.push({
        ingredients_id: getIngredientId,
      });
      const myLi = document.getElementById("updateIngredient" + index);
      myLi.remove();
    },
    submit() {
      //Send to the form updated data from api list
      const apiDropdownToUpdateLength = document.getElementById(
        "apiDropdownToUpdate"
      ).childElementCount;

      for (let index = 0; index <= apiDropdownToUpdateLength - 1; index++) {
        let getApiQuantity = document.getElementById(
          "apiQuantity" + index
        ).value;
        let getApiIngredientId = document.getElementById(
          "apiIngredientId" + index
        ).innerText;
        this.form.ingredientsToUpdate.push({
          ingredients_id: getApiIngredientId,
          quantity: getApiQuantity,
        });
      }
      
      //Send to the form updated data
      const dropdownToUpdateLength =
        document.getElementById("dropdownToUpdate").childElementCount;

      for (let index = 0; index <= dropdownToUpdateLength - 1; index++) {
        let getQuantity = document.getElementById("quantity" + index).value;
        let getIngredientId = document.getElementById(
          "ingredientId" + index
        ).innerText;
        this.form.ingredientsToUpdate.push({
          ingredients_id: getIngredientId,
          quantity: getQuantity,
        });
      }

      //Add new ingredients to the form
      const dropdownToCreateLength =
        document.getElementsByClassName("dropdownToCreate").length;

      for (let index = 0; index <= dropdownToCreateLength - 1; index++) {
        let getQuantity = document.getElementById(
          "createdQuantity" + index
        ).value;
        let getIngredientId = document.getElementById(
          "ingredientId" + index
        ).value;
        this.form.ingredientsToAdd.push({
          ingredients_id: getIngredientId,
          quantity: getQuantity,
        });
      }
      this.$inertia.post(this.route("updateRecipe", this.form));
    },
  },
};
</script>

<style lang="scss" scoped>
h1,
h2 {
  margin-top: 20px;
  margin-bottom: 10px;
  font-size: 28px;
  font-weight: 600;
}

#recipeName {
  display: block;
  margin-left: auto;
  margin-right: auto;
}

h1,
#time {
  text-align: center;
}

#time li {
  display: inline-block;
  margin-top: 20px;
  margin-bottom: 20px;
}

#time li:first-child {
  margin-right: 6%;
}

.ingredientPicture {
  margin-left: 3%;
  margin-right: 3%;
  height: 52px;
  vertical-align: middle;
}

.apiQuantity {
  margin-left: 10%;
  margin-right: 5%;
}

.apiQuantity,
.apiName {
  margin-bottom: 1%;
}

.ingredientNutriscore {
  margin-right: 3%;
  width: 90px;
  vertical-align: middle;
}

.ingredientName {
  margin-left: 14%;
  margin-right: 30%;
}

.ingredientQuantity {
  float: right;
  margin-right: 14%;
}

.ingredientBlock,
.ApiIngredientBlock {
  display: inline-block;
  vertical-align: middle;
  width: 27%;
  margin-right: 6%;
  margin-bottom: 20px;
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
  .ApiIngredientBlock:nth-last-child(2) {
    margin-right: 0;
  }
}

@media only screen and (min-width: 1801px) {
  .ingredientBlock:nth-child(3n) {
    margin-right: 0;
  }
  .ApiIngredientBlock:nth-child(3n) {
    margin-right: 0;
  }
}

.ApiIngredientBlock {
  padding: 0;
}

#deleteIngredient {
  float: right;
  margin-right: 2%;
}
textarea {
  width: 100%;
  margin-top: 10px;
  height: 400px;
}

#button {
  text-align: right;
  margin-top: 20px;
  margin-bottom: 20px;
}
</style>