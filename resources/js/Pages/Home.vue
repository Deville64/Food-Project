<template>
  <TheHeader />
  <main id="home" class="wrapper">
    <Banner />

    <h1>Un projet 100% indépendant</h1>

    <ul>
      <li>
        <img src="/img/home/noInfluence.png" alt="" />
        <p>
          Aucune marque ni groupe industriel ne peut influencer la notation et
          les recommandations proposées.
        </p>
      </li>
      <li>
        <img src="/img/home/noAdd.png" alt="" />
        <p>
          Aucune marque ne peut nous rémunérer pour faire la promotion de ses
          produits dans l'application.
        </p>
      </li>
    </ul>
  </main>
  <TheFooter />
</template>

<script>
import TheHeader from "@/Components/TheHeader";
import TheFooter from "@/Components/TheFooter";
import Banner from "@/components/Banner";

export default {
  components: {
    TheHeader,
    TheFooter,
    Banner,
  },
};
</script>

<style lang="scss" scoped>
#home h1 {
  display: flex;
  justify-content: center;
  font-size: 28px;
  font-weight: 600;
  margin-top: 20px;
}

#home ul {
  display: flex;
  margin-top: 20px;

    @media (max-width: 871px) {
    display: block;
  }
}

#home ul li {
  width: 176px;
  text-align: center;
  margin-left: auto;
  margin-right: auto;
}
#home ul li p {
  line-height: 20px;
  margin-bottom: 20px;
  margin-top: 10px;
}
</style>
