<template>
  <div class="weatherSummary" v-show="showElement == id">

    <div class="current_weather">

      <div class="headingContainer">
        <div class="imgContainer">
          <span class="pill" v-show="current">Current Location</span>
          <img :src="getUrl" class="icon" />
        </div>
        <div style="align-self:flex-start;">
          <h1>{{ name }}</h1>
          <h2>{{ current_weather.condition }}</h2>
          <h3>{{ current_weather.description }}</h3>
        </div>
      </div>

      <div class="temperatureContainer">
        <div class="stats">
          <h4>Current Temperature</h4>
          <h2>{{ current_weather.temp }}&#8457;</h2>
        </div>
        <div class="stats">
          <h4>Humidity</h4>
          <h2>{{ current_weather.humidity }}</h2>
        </div>
      </div>
    </div>

    <h2>Forecast</h2>
    <div class="forecastContainer">
      <div v-for="(fc, date) in forecast" class="forecast">
        <h5>{{ date }}</h5>
        <p class="headingContainer">
          <h4>{{ fc.condition }}</h4>
        </p>
        <p class="high">High: {{ fc.high }}&#8457;</p>
        <p class="low">Low: {{ fc.low }}&#8457;</p>
      </div>
    </div>

    <div class="buttonTray">
      <button class="btn updateBtn" @click="update"  v-show="!current">
          Set as Your Current Location
      </button>
      <button class="btn deleteBtn" @click="remove">
          Remove City
      </button>
    </div>


  </div>
</template>

<script>
export default {
    methods: {
      remove() {
        this.$emit('remove', this.id);
      },
      update() {
        this.$emit('update', this.id);
      },
    },
    computed: {
      isActive() {
        return this.current === 1;
      },
      getUrl() {
        return this.current_weather.icon;
      },
      getFlag() {
        return "https://www.countryflags.io/" + this.country + "/shiny/32.png";
      }
    },
    props: ['id', 'name', 'country', 'current', 'current_weather', 'forecast', 'showElement']
}
</script>
