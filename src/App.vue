<template>
  <div id="app">
    <router-view :products="products" @updateProducts="updateProducts()" />
    <footer>Scandiweb Test assignment</footer>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "App",
  data: () => {
    return {
      products: [],
    };
  },
  mounted() {
    this.updateProducts();
  },
  methods: {
    updateProducts() {
      var vm = this;
      axios
        .get("/product_list.php")
        .then((response) => {
          vm.products = response.data;
        })
        .catch(() => {});
    },
  },
};
</script>

<style lang="sass">
html, body
  height: 100%
  margin: 0
  #app
    min-height: calc(100% - 35px)
    padding: 15px
    padding-top: 20px
    display: flex
    flex-direction: column
    header
      display: flex
      border-bottom: 1px solid black
      h1
        margin-top: 5px
        margin-bottom: 5px
        margin-right: auto
      a
        cursor: pointer
        margin-top: auto
        margin-bottom: 10px
        margin-right: 20px
        border: 1px solid black
        padding: 2px 5px
        box-shadow: 2px 2px 2px black
        &:hover
          background: #ddd
        &:active
          transform: translateY(1px)
          box-shadow: 1px 1px 1px black
    footer
      border-top: 1px solid black
      padding: 10px
      text-align: center
</style>
