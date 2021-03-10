<template>
  <header id="sticky">
    <div class="wrapper">
      <inertia-link href="/" id="logo">Onylia</inertia-link>

      <nav id="menu">
        <SearchBar />

        <div id="custom">
          <label for="showMenuPublic" id="menuPublic">Menu</label>
          <input type="checkbox" id="showMenuPublic" role="button" />

          <ul id="subMenuPublic">
            <li>
              <inertia-link href="login">Connexion</inertia-link>
            </li>
            <li>
              <inertia-link href="register">Inscription</inertia-link>
            </li>
          </ul>
        </div>
      </nav>
    </div>
  </header>
</template>

<script>
import SearchBar from "@/components/SearchBar";
export default {
  components: {
    SearchBar
  },
};
</script>

<style lang="scss">
header {
  background-color: #48bc8b;
  font-size: 0;
  height: 68px;

  @media (max-width: 871px) {
    height: 164px;
  }
}

header #logo {
  float: left;
  font-size: 20px;
  font-weight: 600;
  color: #ffffff;
  margin-top: 18px;
  text-transform: uppercase;

  @media (max-width: 871px) {
    margin-bottom: 14px;
  }
}

header #menu {
  float: right;
  width: 70%;
  font-size: 0;

  @media (max-width: 871px) {
    width: 100%;
  }
}

header #menu form {
  display: inline-block;
  width: 40%;
  margin-top: 14px;

  @media (max-width: 1526px) {
    display: inline-block;
    width: 61%;
  }

  @media (max-width: 871px) {
    width: 100%;
    margin-top: 4px;
  }
}

header #menu #custom {
  display: inline;

  @media (max-width: 1526px) {
    position: absolute;
    width: 19%;
  }

  @media (max-width: 871px) {
    display: contents;
  }
}

header #subMenuPublic {
  float: right;
  margin-top: 18px;

  @media (max-width: 1526px) {
    display: none;
    background-color: #3fac7e;
    margin-top: 0;
  }
}

header #subMenuPublic li {
  display: inline-block;

  @media (max-width: 1526px) {
    width: 100%;
    margin-top: 18px;
  }
}

header #subMenuPublic li:nth-child(2) {
  margin-left: 100px;
  margin-bottom: 18px;

  @media (max-width: 1526px) {
    margin-left: 0;
  }
}

header #subMenuPublic li a {
  font-size: 20px;
  color: #ffffff;
}

/*Style 'show menu' label button and hide it by default*/
header #menuPublic {
  background: #fff;
  color: #48bc8b;
  text-align: center;
  padding: 10px 10px;
  border-radius: 18px;
  display: none;
  font-size: 18px;
  cursor: pointer;
  font-weight: 600;

  @media (max-width: 1526px) {
    display: inline-block;
    float: right;
    margin-top: 18px;
  }

  @media (max-width: 871px) {
    float: none;
    display: block;
    margin-top: 0;
    margin-right: auto;
    margin-left: auto;
  }
}
/*Hide checkbox*/
header #showMenuPublic {
  display: none;
}
/*Show menu when invisible checkbox is checked*/
header #showMenuPublic:checked ~ #subMenuPublic {
  display: block;
  width: 200px;
  text-align: center;
  position: absolute;
  top: 68px;
  right: 0;

  @media (max-width: 871px) {
    width: 70%;
    top: 164px;
    right: 15%;
  }
}
</style>