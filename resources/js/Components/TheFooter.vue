<template>
  <footer>
    <div class="wrapper">
      <nav>
        <ul>
          <li>
            <a href="">A Propos</a>
          </li>
          <li>
            <a href="">Contact</a>
          </li>
          <li>
            <a href=""
              >Conditions d'utilisation</a
            >
          </li>
        </ul>
      </nav>

      <p id="right">© 2021 Onylia</p>
    </div>
  </footer>
</template>

<script>
export default {
  name: "TheFooter",
};
</script>


<style lang="scss" scoped>
footer {
    background-color: #3fac7e;
    padding-top: 25px;
    padding-bottom: 25px;
    font-size: 0;
}
footer .wrapper {
    width: 70%;
    margin-left: auto;
    margin-right: auto;
}

footer nav {
    display: block;
    margin-bottom: 20px;
    @media (max-width: 700px) {
        margin-left: 30%;
    }
}

footer ul li {
    display: inline-block;
    font-size: 16px;
    font-weight: 600;
    @media (max-width: 700px) {
        display: block;
    }
}

footer ul li:nth-child(1) {
    float: left;
    @media (max-width: 700px) {
        float: none;
        margin-bottom: 14px;
    }
}

footer ul li:nth-child(2) {
    margin-left: 44%;
    @media (max-width: 1526px) {
        margin-left: 40%;
        margin-bottom: 14px;
    }
    @media (max-width: 1050px) {
        margin-left: 35%;
    }
    @media (max-width: 700px) {
        margin-left: 0;
        margin-bottom: 14px;
    }
}

footer ul li:nth-child(3) {
    float: right;
    @media (max-width: 700px) {
        float: none;
        margin-bottom: 5px;
    }
}

footer #right {
    font-size: 16px;
    text-align: center;
    color: white;
}

footer ul li a {
    color: white;
}

</style>
