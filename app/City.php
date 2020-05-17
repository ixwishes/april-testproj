<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
  protected $fillable = [
    'user_id', 'name', 'state', 'country', 'latitude', 'longitude', 'current'
  ];
}
