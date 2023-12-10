<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;

    protected $fillable = [ 'name' , 'available' , 'sector_id' , 'user_id' , 'start_time' , 'end_time' , 'total_price'];

    protected $cats = [
        'start_time' => 'datetime',
        'end_time' => 'datetime'
    ];

    // adding relationship where a place belongs to a sector

    public function sector(){
        return $this->belongsTo(Sector::class);
    }

    // adding relationship where a place belongs to a user

    public function user(){
        return $this->belongsTo(User::class);
    }

    // adding relationship where a place has time bookings

    public function getStartTimeAttribute($value){
        return Carbon::parse($value)->format('Y-m-d\TH:i');
    }
}

