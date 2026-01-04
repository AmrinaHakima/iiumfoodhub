<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cafe extends Model
{
    protected $fillable = ['name', 'location', 'open_time', 'close_time'];

    public function menuItems() {
        return $this->hasMany(MenuItem::class);
    }
}
