<template>
  <div id="products">
    <header>
      <h1>Product List</h1>
      <a @click="$router.push('/add-product')">ADD</a>
      <a id="delete-product-btn" @click="massDelete">MASS DELETE</a>
    </header>
    <div class="list">
      <div v-for="(product, i) in products" :key="i" class="product">
        <input
          type="checkbox"
          class="delete-checkbox"
          v-model="product.checked"
        />
        {{ product.sku }}<br />
        {{ product.name }}<br />
        {{ product.price }} $<br />
        {{ product.text }}
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "Products",
  props: ["products"],
  methods: {
    massDelete() {
      var list = [];
      var vm = this;
      for (var i = 0; i < this.products.length; i++)
        if (this.products[i].checked) list.push(this.products[i].sku);
      axios.post("/mass_delete.php", { list }).then(() => {
        vm.$emit("updateProducts");
      });
    },
  },
};
</script>

<style lang="sass" scoped>
#products
  flex: 1
  .list
    display: grid
    grid-template-columns: repeat( auto-fill, minmax(200px, 1fr) )
    grid-column-gap: 20px
    grid-row-gap: 20px
    padding: 20px 0
    .product
      width: 200px
      height: 150px
      border: 1px solid black
      display: flex
      position: relative
      text-align: center
      align-items: center
      justify-content: center
      input
        position: absolute
        top: 10px
        left: 10px
</style>
