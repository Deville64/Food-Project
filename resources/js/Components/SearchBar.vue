<template>
  <form action="" method="get">
    <label for="search">Recherche</label>
    <input
      id="search"
      type="text"
      placeholder="Rechercher une marque"
      autocomplete="off"
      v-on:keyup="searchFood()"
      v-on:click="showHideDropDown()"
    />
    <div id="dropDown" class="dropdown-content"></div>
  </form>
</template>

<script>
export default {
  methods: {
    searchFood() {
      const vm = this;
      const xhr = new XMLHttpRequest(); // Creating the XMLHttpRequest object
      const text = document.getElementById("search").value; //Take text from search bar
      const url ="https://fr.openfoodfacts.org/cgi/search.pl?search_simple=1&action=process&json=true&search_terms=" + text;

      //Check there is at least 3 characters to search food
      if (text.length >= 3) {
        xhr.open("GET", url); // Instantiating the request object
        xhr.onload = function () {
          const openFoodFactDb = JSON.parse(xhr.responseText);
          const listElem = document.getElementById("dropDown");

          //Purge old results
          while (listElem.firstChild) {
            listElem.removeChild(listElem.firstChild);
          }

          for (let info = 0; info < 4; info++) {
            let foodName = openFoodFactDb.products[info].product_name_fr;
            let picFood = openFoodFactDb.products[info].image_front_small_url;
            let nutriscore = openFoodFactDb.products[info].nutriscore_grade;
            let imgNutriscore ="https://static.openfoodfacts.org/images/misc/nutriscore-" + nutriscore + ".svg";
            let nova = openFoodFactDb.products[info].nova_groups;
            let imgNova = "https://static.openfoodfacts.org/images/misc/nova-group-" + nova + ".svg";
            let foodID = openFoodFactDb.products[info].id;

            const node = document.createElement("div");
            node.foodID = foodID;
            node.className = "resultFoodSearch";

            //When clicked, save ID and send to food page
            node.addEventListener("click", function (event) {
              console.log(event.target.foodID);
              sessionStorage.setItem("foodID", event.target.foodID); // keep foodID in memory
              location.assign('http://127.0.0.1:8000/food');
            });

            //Food Picture
            if (picFood != undefined) {
              const createPicFood = document.createElement("img");
              createPicFood.setAttribute("src", picFood);
              createPicFood.className = "foodPicture";
              createPicFood.foodID = foodID;
              node.appendChild(createPicFood);
            }

            //Food Name
            if (foodName != undefined) {
              const spanFoodName = document.createElement("span");
              const foodNameNode = document.createTextNode(foodName);
              spanFoodName.className = "foodName";
              spanFoodName.foodID = foodID;
              spanFoodName.appendChild(foodNameNode);
              node.appendChild(spanFoodName);
            }

            //Nutriscore Image
            if (nutriscore != undefined) {
              const createImgNutriscore = document.createElement("img");
              createImgNutriscore.setAttribute("src", imgNutriscore);
              createImgNutriscore.className = "nutriscore";
              createImgNutriscore.foodID = foodID;
              node.appendChild(createImgNutriscore);
            }

            //Nova Image
            if (nova != undefined) {
              const createImgNova = document.createElement("img");
              createImgNova.setAttribute("src", imgNova);
              createImgNova.className = "nova";
              createImgNova.foodID = foodID;
              node.appendChild(createImgNova);
            }
            listElem.appendChild(node);
          }
        };
        xhr.send(); // Sending the request to the server
        console.log("Request Succesfull");
      }
    },

    //When the user clicks on the button,
    //toggle between hiding and showing the dropdown content
    showHideDropDown() {
      document.getElementById("dropDown").classList.toggle("show");
    },
  },

  mounted() {
    // Close the dropdown for search bar the user clicks outside of it
    window.onclick = function (event) {
      if (!event.target.matches("#search")) {
        const dropdown = document.getElementById("dropDown");
        dropdown.classList.remove("show");
      }
    };
  },
};
</script>

<style lang="scss" scoped>
#search {
  margin-bottom: 15px;
  width: 100%;
  padding: 2.5%;
  border-radius: 18px 18px 18px 18px;
  height: 34px;
}
.dropdown-content {
  display: none;
  position: absolute;
  width: 19.5%;
  background-color: #f9f9f9;
  box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
  z-index: 1;
  font-size: 18px;

  @media (max-width: 1526px) {
    width: 30%;
  }

  @media (max-width: 871px) {
    width: 70%;
  }
}

.show {
  display: block;
}

#dropDown .resultFoodSearch {
  cursor: pointer;
}

#dropDown .resultFoodSearch .foodPicture {
  display: inline-block;
  width: 25%;
}

#dropDown .resultFoodSearch .foodName {
  display: inline-block;
  width: 75%;
  vertical-align: top;
  text-align: center;
}

#dropDown .resultFoodSearch .nutriscore {
  display: inline-block;
  width: 100px;
}

#dropDown .resultFoodSearch .nova {
  display: inline-block;
  width: 45px;
}
</style>