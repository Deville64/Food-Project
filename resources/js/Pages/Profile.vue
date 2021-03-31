<template>
  <TheHeader />
  <main id="profile">
    <ProfileMenu />

    <section id="personalInfo" class="hide" style="display: inline-block">
      <h1><span>Information personnelles</span></h1>

      <form @submit.prevent="submit">
        <div>
          <label for="email">E-mail:</label>
          <div>Votre e-mail actuel: {{ $page.props.auth.user.email }}</div>
          <input
            type="email"
            v-model="form.email"
            placeholder="Entrez votre nouvel email"
            required
          />
        </div>

        <div class="button">
          <input type="submit" value="Enregistrer" />
        </div>
      </form>
    </section>

    <section id="picture" class="hide">
      <h1><span>Photo</span></h1>

      <form action="" method="post">
        <div>
          <label for="address">Adresse:</label>
          <input type="text" name="address" placeholder="Ex: 12 rue des bois" />
        </div>

        <div class="button">
          <input type="submit" value="Enregistrer" />
        </div>
      </form>
    </section>
  </main>
  <TheFooter />
</template>

<script>
import TheHeader from "@/Components/TheHeader";
import ProfileMenu from "@/Components/ProfileMenu";
import TheFooter from "@/Components/TheFooter";

export default {
  components: {
    TheHeader,
    TheFooter,
    ProfileMenu
  },

  data() {
    return {
      form: {
        email: "",
      },
    };
  },

  methods: {
    submit() {
      this.$inertia.post(this.route("updateEmail", this.form));
    },
  },
};
</script>

<style lang="scss" scoped>
#profile .hide {
  display: none;
}

#profile .hide:first-child {
  display: inline-block;
}
#profile {
  font-size: 0;
}
#profile section {
  vertical-align: top;
  font-size: 18px;
  margin-top: 22px;
  margin-left: 2%;
  width: 42%;
}
////////
/////// Line under H1
#profile h1 {
  overflow: hidden;
  position: relative;
}
#profile h1 span {
  display: inline-block;
  overflow: hidden;
}
#profile h1 span:before {
  content: "";
  height: 1em;
  display: inline-block;
  width: 100%;
  position: absolute;
}
#profile h1 span:before {
  margin-right: -100%;
  border-bottom: solid 1px;
  color: black;
  vertical-align: bottom;
}

/////////////////
///////////////// Postion for inputs in Profile

#profile section form {
  background-color: #ededed;
  height: 438px;
}
#profile section div:nth-child(1) {
  padding-top: 15px;
}
#profile section div {
  text-align: center;
  margin-top: 26px;
}

#profile section .button {
  vertical-align: bottom;
  text-align: right;
}
</style>