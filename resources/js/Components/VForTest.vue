<template>
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

    <li v-for="(item, index) in items" :key="index">
      <input
        type="text"
        :id="'ingredient' + index"
        @keyup="showHint(index)"
        className="ingredient"
        placeholder="Selectionner un ingrédient"
      />
      <ul>
        <li
          :id="'dropdown' + index"
          v-for="ingredient in ingredients"
          :key="ingredient.name"
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
      />
    </li>
  </ul>
</template>

<script>
export default {
  data() {
    return {
      items: [],
      ingredients: {},
      data: {},
    };
  },
  created() {
    axios
      .get("http://127.0.0.1:8000/ingredients")
      .then((response) => (this.data = response.data))
      .catch((error) => console.log(error));
  },
  methods: {
    createIngredient() {
      let index = 0;
      this.items.push(index++);
    },
    showHint(id) {
      console.log(id);
      const dropdown = document.getElementById("dropdown" + id);
      const text = document.getElementById("ingredient" + id).value;

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