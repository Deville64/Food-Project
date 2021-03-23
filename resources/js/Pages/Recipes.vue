<template>
  <TheHeader />
  <main id="myRecipes" class="wrapper">
    <h1>Mes recettes</h1>
    <ul id="recipes">
      <li>
        <h2></h2>
      </li>
      <li>
        <inertia-link href="/recipeform"><img id="addMore" src="/img/general/addMore.png" alt=""
        /></inertia-link>
      </li>
    </ul>
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
};
</script>