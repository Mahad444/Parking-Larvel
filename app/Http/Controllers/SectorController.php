<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SectorController extends Controller
{
    //adding a new sector controller

    public function index(){
        return SectorResource::collection(Sector::all());

    }
}
