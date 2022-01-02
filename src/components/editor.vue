<template>
  <div id="editor">
    <header>
      <h1>Product Add</h1>
      <a @click="save">Save</a>
      <a id="delete-product-btn" @click="$router.push('/')">Cancel</a>
    </header>
    <form id="product_form">
      <div
        v-for="(field, i) in shownFields()"
        :key="i"
        :style="{ color: field.missing || field.invalid ? 'red' : '' }"
      >
        <label :for="field.id">{{ field.label }}</label>
        <select
          v-if="field.type == 'select'"
          v-model="field.value"
          :id="field.id"
          @change="$data[field.id] = field.value"
        >
          <option v-for="item in field.list" :id="item" :key="item">
            {{ item }}
          </option>
        </select>
        <input
          type="number"
          v-else-if="field.type == 'number'"
          :id="field.id"
          v-model="field.value"
        />
        <input v-else :id="field.id" v-model="field.value" />
        <br />
        <span v-if="field.missing">Please, submit required data<br /></span>
        <span v-if="field.invalid">
          Please, provide the data of indicated type
          <br />
        </span>
        <br />
      </div>
      <div v-if="productType == 'DVD'">Please, provide size</div>
      <div v-else-if="productType == 'Book'">Please, provide weight</div>
      <div v-else-if="productType == 'Furniture'">
        Please, provide dimensions
      </div>
    </form>
  </div>
</template>
<script>
import axios from "axios";

export default {
  name: "Editor",
  props: ["products"],
  data: () => {
    return {
      productType: "",
      fields: [
        {
          label: "SKU",
          id: "sku",
          type: "unique",
          value: "",
          missing: false,
          invalid: false,
        },
        {
          label: "Name",
          id: "name",
          type: "text",
          value: "",
          missing: false,
          invalid: false,
        },
        {
          label: "Price ($)",
          id: "price",
          type: "number",
          value: "",
          missing: false,
          invalid: false,
        },
        {
          label: "Type Switcher",
          id: "productType",
          type: "select",
          list: ["DVD", "Book", "Furniture"],
          value: "",
          missing: false,
          invalid: false,
        },
        {
          label: "Size (MB)",
          id: "size",
          type: "number",
          if: "DVD",
          value: "",
          missing: false,
          invalid: false,
        },
        {
          label: "Weight (KG)",
          id: "weight",
          type: "number",
          if: "Book",
          value: "",
          missing: false,
          invalid: false,
        },
        {
          label: "Height (CM)",
          id: "height",
          type: "number",
          if: "Furniture",
          value: "",
          missing: false,
          invalid: false,
        },
        {
          label: "Width (CM)",
          id: "width",
          type: "number",
          if: "Furniture",
          value: "",
          missing: false,
          invalid: false,
        },
        {
          label: "Length (CM)",
          id: "length",
          type: "number",
          if: "Furniture",
          value: "",
          missing: false,
          invalid: false,
        },
      ],
    };
  },
  methods: {
    visible(field) {
      if (!field.if) return true;
      return field.if == this.productType;
    },
    shownFields() {
      return this.fields.filter(this.visible);
    },
    validate() {
      for (var i = 0; i < this.fields.length; i++) {
        this.fields[i].missing = false;
        this.fields[i].invalid = false;
      }
      for (i = 0; i < this.fields.length; i++) {
        if (!this.visible(this.fields[i])) continue;
        if (!this.fields[i].value) {
          this.fields[i].missing = true;
        }
        if (this.fields[i].type == "number") {
          if (this.fields[i].value != parseFloat(this.fields[i].value)) {
            this.fields[i].invalid = true;
          }
        }
        if (this.fields[i].type == "unique") {
          for (var j = 0; j < this.products.length; j++) {
            if (this.fields[i].value == this.products[j][this.fields[i].id]) {
              this.fields[i].invalid = true;
            }
          }
        }
      }
      for (i = 0; i < this.fields.length; i++) {
        if (this.fields[i].invalid || this.fields[i].missing) {
          return false;
        }
      }
      return true;
    },
    save() {
      if (!this.validate()) return false;
      var fields = this.shownFields();
      var data = {};
      for (var i = 0; i < fields.length; i++) {
        data[fields[i].id] = fields[i].value;
      }
      var vm = this;
      axios
        .post("/add_product.php", data)
        .then(() => {
          vm.$emit("updateProducts");
          vm.$router.push("/");
        })
        .catch(() => {});
    },
  },
};
</script>

<style lang="sass" scoped>
#editor
  flex: 1
  #product_form
    padding: 15px 0
    label
      display: inline-block
      margin-right: 15px
      width: 95px
</style>
