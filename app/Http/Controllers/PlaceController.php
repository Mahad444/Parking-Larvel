<?php

namespace App\Http\Controllers;

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
            'start_time' => $request->start_time,
            available => 0,
            'end_time' => null,
            'total_price' => null,
        ]);

        $place->load('user', 'sector');

        return PlaceResource::make($place);
    }
}
