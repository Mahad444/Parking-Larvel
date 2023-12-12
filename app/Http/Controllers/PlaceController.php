<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use App\Models\Place;

use Illuminate\Http\Request;

use App\Http\Resources\PlaceResource;

class PlaceController extends Controller
{
    // ceate a new place controller

    public function startParking(Request $request, Place $place)

    {
        $request -> validate([
            'user_id' => ['required', 'integer']
        ]);

        if ($place->where('user_id', $request->user_id)->whereNull('end_time')->exists()) {
            return response()->json([
                'error' => 'You already have an active parking session!!'
            ], 400);
        }

        // if the user has no active parking session, we can start a new one

        $place->update([
            'user_id' => $request->user_id,
            'start_time' => now(),
            'available' => 0,
            'end_time' => null,
            'total_price' => null,
        ]);

        $place->load('user', 'sector');

        return PlaceResource::make($place);
    }


    // end parking session

    public function endParking(Place $place)

    {
    
        $place->update([
            'available' => 1,
            'end_time' => now(),
            'total_price' => $this->calculatePrice($place->sector_id, $place->start_time),
        ]);


        return PlaceResource::make($place);
    }

    //  calculate price 

    public function calculatePrice($sector_id, $start_time)

    {
        $tart = Carbon::createMidnightDate($start_time);
        $end = Carbon::createMidnightDate(now());
        $totalDuration = $start->diffInHours($end);
        $sector_hourly_price = Sector::find($sector_id)->hourly_price;


       if ($totalDuration > 1) {
        return ceil($sector_hourly_price * $totalDuration);
       }
    //    OR
       return $sector_hourly_price;

    }

}