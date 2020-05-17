<template>
  <button @click="changeElement" v-bind:class="isActive">
    <img :src="getFlag" class="flag" v-show="!(current === 1)"/>
    <span class="pill_white" v-show="(current === 1)">CURRENT</span>
    {{ name }}
  </button>
</template>

<script>
export default {
    methods: {
      changeElement() {
        this.$emit('changeElement', this.id);
      },
    },
    computed: {
      isActive() {
        return this.showElement == this.id ? "highlighted" : "";
      },
      getFlag() {
        return "https://www.countryflags.io/" + this.country + "/shiny/32.png";
      }
    },
    props: ['id', 'name', 'current', 'country', 'current_weather', 'forecast', 'showElement']
}
</script>
