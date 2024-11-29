<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomModel extends Model {
    protected $table = 'rooms';
    protected $fillable = ['name', 'price_per_day', 'price_per_month', 'status'];

    public $timestamps = false;
}

