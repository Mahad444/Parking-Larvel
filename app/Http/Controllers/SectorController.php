<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sector;
use App\Http\Resources\SectorResource;


class SectorController extends Controller
{
    //adding a new sector controller

    public function index(){
        return SectorResource::collection(Sector::all());

    }
}
