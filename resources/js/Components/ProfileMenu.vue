<template>
  <aside id="asideProfile">
    <table>
      <tr>
        <th>Profil</th>
      </tr>
      <tr>
        <td onclick="showHide('picture')">Informations Personnelles</td>
      </tr>
      <tr>
        <td>Mot de passe</td>
      </tr>
      <tr>
        <td>Fermeture du compte</td>
      </tr>
    </table>
  </aside>
</template>

<script>
export default {
  methods: {
    showHide(id) {
      var show = document.getElementById(id);
      var hide = document.getElementsByClassName("hide");

      if (document.getElementById(id)) {
        for (var i = 0; i < hide.length; i++) {
          hide[i].style.display = "none";
        }

        show.style.display = "inline-block";
      }
      return false;
    },
  },
};
</script>

<style lang="scss" scoped>
#asideProfile {
  display: inline-block;
  margin-left: 15%;
  font-size: 18px;
  margin-top: 40px;
}

#asideProfile table {
  width: 220px;
}
#asideProfile table:nth-child(1n + 2) {
  margin-top: 16px;
}

#asideProfile th,
#asideProfile td {
  border: 1px solid black;
  padding: 8px;
}

#asideProfile th {
  background-color: #ededed;
  text-align: left;
  padding-top: 10px;
  padding-bottom: 10px;
}

#asideProfile td:hover {
  background-color: #48bc8b;
  color: #ffffff;
  cursor: pointer;
}
</style>