<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    use HasFactory;

    protected $fillable = [ 'name' , 'hourly_price'];

    // adding relationship where a sector has many places
    public function places () 
    {
        return $this->hasMany(Place::class);
    }
}
