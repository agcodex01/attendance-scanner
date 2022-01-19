<?php

namespace App\Http\Controllers;

use App\Constants\LocationConstant;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        return LocationConstant::locations();
    }
}
