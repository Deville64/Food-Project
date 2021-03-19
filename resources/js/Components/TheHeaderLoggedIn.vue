<template>
  <header id="sticky">
    <div class="wrapper">
      <inertia-link href="/" id="logo">Onylia</inertia-link>

      <nav id="menu">
        <SearchBar />

        <ul id="menuLogin">
          <li class="liMenuLogin">
            <inertia-link href="/recipes">Mes recettes</inertia-link>
          </li>
          <li class="liMenuLogin">
            <label for="showMenuLogin" id="icon"
              ><img src="/img/general/IconProfil.png" alt=""
            /></label>
            <input type="checkbox" id="showMenuLogin" role="button" />
            <ul id="iconMenuLogin">
              <li>
                  <inertia-link href="/recipes">Mes recettes</inertia-link>
              </li>
              <li>
                <inertia-link href="/profile">Profil</inertia-link>
              </li>
              <li>
                <inertia-link href="logout" method="post">Deconnexion</inertia-link>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
    </div>
  </header>
</template>

<script>
import SearchBar from "@/components/SearchBar";

export default {
  components: {
    SearchBar,
  },
};
</script>

<style lang="scss" scoped>
header #menuLogin {
    float: right;
    @media (max-width: 871px) {
        float: none;
        text-align: center;
    }
}

header #menuLogin .liMenuLogin {
    display: inline-block;
    vertical-align: top;
    margin-top: 18px;
}

header #menuLogin .liMenuLogin:nth-child(1) {
    @media (max-width: 1526px) {
        display: none;
    }
}

header #menuLogin .liMenuLogin:nth-child(2) {
    margin-left: 154px;
    margin-top: 10px;

    @media (max-width: 1526px) {
        margin-left: 0;
    }
    @media (max-width: 871px) {
        margin-left: 0;
        margin-top: 0;
    }
}

header #menuLogin .liMenuLogin a {
    font-size: 20px;
    color: #ffffff;
}

header #icon {
    float: right;
    width: 45px;
    cursor: pointer;
}

header #menuLogin #iconMenuLogin li {
    margin-top: 18px;
}
header #menuLogin #iconMenuLogin li:nth-child(1) {
    display: none;

    @media (max-width: 1526px) {
        display: block;
    }
}

header #menuLogin #iconMenuLogin li:nth-child(3) {
    margin-bottom: 18px;
}

/*Hide checkbox*/
header #showMenuLogin,
header #iconMenuLogin {
    display: none;
}

/*Show menu when invisible checkbox is checked*/
header #showMenuLogin:checked ~ #iconMenuLogin {
    display: block;
    width: 200px;
    text-align: center;
    background: #3fac7e;
    position: absolute;
    top: 68px;
    right: 15%;

    @media (max-width: 871px) {
        width: 70%;
        top: 164px;
    }
}
</style>