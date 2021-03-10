<template>
  <div id="banner">
    <button v-on:click="slide()" id="previous-btn"></button>
    <button v-on:click="backSlide()" id="next-btn">></button>
    <img id="home-banner" />
  </div>
</template>

<script>
export default {
  name: "Banner",

  data: function () {
    return {
      images: ["vegetables.jpg", "bananas.jpg"],
      index: 0
    };
  },

  methods: {
    slide() {
      var indexMax= this.images.length - 1
      console.log("next click");
      if (this.index == indexMax) {
        this.index = 0;
        document.getElementById("home-banner").src ="/img/slideShow/" + this.images[this.index];
      } else {
        this.index++;
        document.getElementById("home-banner").src ="/img/slideShow/" + this.images[this.index];
      }
    },
    backSlide() {
      var indexMax= this.images.length - 1
      console.log("previous click");
      if (this.index == 0) {
        this.index = indexMax;
        document.getElementById("home-banner").src ="/img/slideShow/" + this.images[this.index];
      } else {
        this.index--;
        document.getElementById("home-banner").src ="/img/slideShow/" + this.images[this.index];
      }
    },
  },
  mounted() {
    document.querySelector("#home-banner").src ="/img/slideShow/" + this.images[this.index];
  }
};
</script>

<style lang="scss" scoped>
#banner {
  width: 960px;
  height: 350px;
  overflow: hidden;
  margin: auto;
  box-shadow: 0 8px 6px -6px rgba(0, 0, 0, 1);

  @media (max-width: 1370px) {
    display: none;
  }
}

#home-banner {
  display: block;
  width: 960px;
  float: left;
  transition: all 0.75s;
}

#previous-btn,
#next-btn {
  position: absolute;
  z-index: 0;
  display: block;
  padding: 0 10px;
  width: auto;
  height: 350px;
  background: rgba(0, 0, 0, 0);
  color: #ffffff;
  font-size: 26px;
  cursor: pointer;
  border: none;
  outline: none;
}

#previous-btn:hover,
#next-btn:hover {
  background: rgba(0, 0, 0, 0.8);
}

#next-btn {
  margin-left: 920px;
}
</style>