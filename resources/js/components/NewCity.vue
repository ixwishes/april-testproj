<template>
    <div class="new-city">
        <div class="city-input">
          <label for="name">City Name *</label>
            <input id="name" type="text" name="name" v-model="name">
        </div>
        <div class="state-input">
          <label for="state">State (Optional)</label>
            <input id="state" type="text" name="state" v-model="state">
        </div>
        <div class="country-input">
          <label for="country">Country *</label>
            <input id="country" type="text" name="country" v-model="country">
        </div>
        <button class="btn btn-primary" :disabled=isDisabled @click="create">
            Add New City
        </button>
    </div>

</template>

<script>
    export default {
        data() {
          return {
            name: "",
            state: "",
            country: "US"
          }
        },
        methods: {
          create() {
            this.$emit('create', this.name, this.state, this.country);
            this.name = "";
            this.state = "";
            this.country = "US";
          }
        },
        computed: {
        isDisabled() {
          // must search with at least city and country
          return this.name == "" || this.country == "";
        }
      }
    }
</script>
