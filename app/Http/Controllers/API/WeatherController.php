<?php

namespace App\Http\Controllers\API;

use Auth;
use App\City;
use DateTime;
use Illuminate\Http\Request;


class WeatherController extends BaseController
{
    public function index()
    {
      $cities = \App\City::where('user_id', '=', Auth::user()->id)->orderBy('current', 'desc')->orderBy('name', 'asc')->get();
      $weatherData = $cityData = [];

      foreach ($cities as $city) {
        $weatherData = $this->getWeatherData($city);
        if (!$weatherData) {
          return $this->sendError("There was a problem contacting our weather service");
        }

        $cityData[] = $this->buildResponse($city, $weatherData);
      }

      return $this->sendResponse($cityData, 'weather_reports', null);
    }

    public function store(Request $request)
    {
      $userCities = \App\City::where('user_id', '=', Auth::user()->id)->orderBy('id', 'desc')->get();
      $cityData = $this->getCityCoordinates([$request->city_name, $request->state, $request->country]);
      $result = null;

      if (!$cityData) {
        return $this->sendError("There was a problem contacting our weather service");
      }

      // create City only if a valid location was found
      $newCity = City::create([
        'user_id'   => Auth::id(),
        'name'      => $cityData['name'],
        'state'     => $request->state,
        'country'   => $cityData['country'],
        'latitude'  => strval($cityData['coord']['lat']),
        'longitude' => strval($cityData['coord']['lon']),
        'current'   => $userCities->count() > 0 ? false : true
      ]);

        $weatherData = $this->getWeatherData($newCity);
        $result = $this->buildResponse($newCity, $weatherData);


      return $this->sendResponse([$result], 'weather_reports', null);
    }

    public function show($id)
    {
      $city = \App\City::where('id', $id)->first();
      $result = [];

      if ($city->user_id == Auth::user()->id) {
        $weatherData = $this->getWeatherData($city);

        if (!$weatherData) {
          return $this->sendError("There was a problem contacting our weather service");
        }

        $result[] = $this->buildResponse($city, $weatherData);
      }

      return $this->sendResponse($result, 'weather_reports', null);
    }

    public function update(Request $request)
    {
      $city = \App\City::where('id', $request->id)->first();
      $result = null;

      if ($city->user_id == Auth::user()->id) {
        // update any other city marked as current
        $userCities = \App\City::where('user_id', '=', Auth::user()->id)->orderBy('id', 'desc')->get();
        foreach ($userCities as $oldCity) {
          if ($oldCity->current) {
            $oldCity->current = false;
            $oldCity->save();
          }
        }

        // set new city as current
        $city->current = $request->current;
        $city->save();
        $result = $city;
      }

      return $this->sendResponse([$result], 'weather_reports', null);
    }

    public function destroy($id)
    {
        $city = \App\City::where('id', $id)->first();
        $result = null;

        if ($city->user_id == Auth::user()->id) {
          $result = \App\City::where('id', $id)->delete();
        }

        return $this->sendResponse([$result], 'weather_reports', null);
    }

    public function getWeatherData($city)
    {
      $params = [];
      $params['lat'] = $city->latitude;
      $params['lon'] = $city->longitude;
      $params['units'] = "imperial";
      $weatherUrl = "https://api.openweathermap.org/data/2.5/onecall";

      $weatherData = $this->executeRequest($weatherUrl, $params);
      return $weatherData;
    }

    public function getCityCoordinates($locationData)
    {
      $searchStr = implode(",", $locationData);
      $params['q'] = $searchStr;
      $cityUrl = "https://api.openweathermap.org/data/2.5/weather";

      $result = [];

      $cityData = $this->executeRequest($cityUrl, $params);

      if (isset($cityData['coord'])){
        $result['coord']   = $cityData['coord'];
        $result['country'] = $cityData['sys']['country'];
        $result['name']    = $cityData['name'];

        return $result;
      }

      return null;
    }

    public function executeRequest($url, $params)
    {
      $params['appid'] = env("WEATHER_API_KEY", "");
      $url = $url . '?' . http_build_query($params);
      $results = [];

      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL, $url);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');

      $data = curl_exec($curl);
      $result = json_decode($data, true);

      curl_close($curl);

      return $result;

    }

    public function buildResponse($city, $weatherData)
    {
      $forecast = $current_weather = [];

      // select data from today's weather
      if (isset($weatherData['current'])){
        $current = $weatherData['current'];
        $current_weather = [
          "temp"        => round($current['temp']),
          "humidity"    => $current['humidity'] . "%",
          "condition"   => $current['weather'][0]['main'],
          "description" => ucfirst($current['weather'][0]['description']),
          "icon"        => "http://openweathermap.org/img/wn/" . $current['weather'][0]['icon'] . "@2x.png"
        ];
      }

      // select data from forecast
      if (isset($weatherData['daily'])) {
        $daily = $weatherData['daily'];

        for ($i = 1; $i < count($daily); $i++){
          $day = $daily[$i];

          // key forecast data by pretty date
          $stamp = intval($day['dt']);
          $dt = \DateTime::createFromFormat("U", $stamp);
          $dateKey = $dt->format('M d');

          $forecast[$dateKey] = [
            "high"        => round($day['temp']['max']),
            "low"         => round($day['temp']['min']),
            "humidity"    => $day['humidity'] . "%",
            "condition"   => $day['weather'][0]['main'],
            "description" => ucfirst($day['weather'][0]['description']),
            "icon"        => "http://openweathermap.org/img/wn/" . $day['weather'][0]['icon'] . "@2x.png"
          ];
        }
      }

      $response = [
        "id"              => $city->id,
        "name"            => $city->name,
        "country"         => strtolower($city->country),
        "current"         => $city->current,
        "current_weather" => $current_weather,
        "forecast"        => $forecast,
      ];

      return $response;
    }
}
