<template>
  <div id="app">
    <div class="appContainer">
      <div class="panel">
        <h2>Your Cities</h2>
         <h4 v-if="reports.length == 0">No Cities</h4>
        <weather-nav-button
          v-for="report in reports"
          v-bind="report"
          :key="report.id"
          :showElement="showElement"
          @changeElement="changeElement"
        ></weather-nav-button>
      </div>
      <div class="weather">
        <h2>Add a New City</h2>
        <span class="errorContainer" v-show="err != ''">{{ err }}</span>
        <new-city @create="create">
        </new-city>

        <weather-summary
          v-for="report in reports"
          v-bind="report"
          :key="report.id"
          :showElement="showElement"
          @update="update"
          @remove="remove"
        ></weather-summary>

      </div>
    </div>
  </div>
</template>


<script>
  function WeatherReport({ id, name, country, current, current_weather, forecast }) {
    this.id = id;
    this.name = name;
    this.country = country;
    this.current = current;
    this.current_weather = current_weather;
    this.forecast = forecast;
  }

  import NewCity from './components/NewCity.vue';
  import WeatherNavButton from './components/WeatherNavButton.vue';
  import WeatherSummary from './components/WeatherSummary.vue';


  export default {
    data() {
      return {
        showElement: 0,
        reports: [],
        err: "",
      }
    },
    methods: {
      async create(name, state, country) {
        this.err = "";

        var self = this;
        axios.post('/api/weather/city', {
          city_name: name,
          state: state,
          country: country
        }).then(function(response) {
          response.data.weather_reports.map(function(report, key) {
            // stupid typing
            if (!report.current){
              report.current = 0;
            } else {
              report.current = 1;
            }
             self.reports.push(new WeatherReport(report));
             if (report.current == 1) {
               self.showElement = report.id;
             }
           });

           self.reports.sort(
              function(a, b) {
                 if (a.current === b.current) {
                    return a.name > b.name ? 1 : -1;
                 }
                 return a.current === 1 ? -1 : 1;
              });

        }).catch(function(error) {
              console.log(error);
              self.err = "There was a problem locating your city. Please try again.";
            });
          },
      async read() {
        var self = this;
        axios.get('/api/weather').then(function(response) {
          response.data.weather_reports.map(function(report, key) {
             self.reports.push(new WeatherReport(report));
             if (report.current === 1) {
               self.showElement = report.id;
             }
           });
        }).catch(function(error) {
          console.log(error);
        });
      },
      async update(id) {
        var self = this;
        let newCurrent = this.reports.findIndex(report => report.id === id);
        let updatedElement = this.reports[newCurrent];

        let oldCurrent = this.reports.findIndex(report => report.current === 1);

        axios.put(`/api/weather/city/${id}`, {
          current: true,
        }).then(function(response) {
          // set the old current to false
          if (oldCurrent >= 0) {
            self.reports[oldCurrent].current = 0;
          }

          // push new current location to front
          updatedElement.current = 1;
          self.reports.splice(newCurrent, 1);
          self.reports.unshift(updatedElement);

          self.reports.sort(
             function(a, b) {
                if (a.current === b.current) {
                   return a.name > b.name ? 1 : -1;
                }
                return a.current === 1 ? -1 : 1;
             });
        }).catch(function(error) {
          console.log(error);
        });
      },
      async remove(id) {
        await axios.delete(`/api/weather/city/${id}`);
        let index = this.reports.findIndex(report => report.id === id);
        this.reports.splice(index, 1);
        if (this.reports.length > 0) {
          this.showElement = this.reports[0].id;
        } else {
          this.showElement = 0;
        }
      },
      changeElement(id) {
        this.showElement = id;
      }
    },
    components: {
      NewCity,
      WeatherNavButton,
      WeatherSummary
    },
    created() {
      this.read();
    }
  }
</script>
