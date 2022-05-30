<?php

namespace App\Http\Controllers;

use App\Models\Tracking;
use Illuminate\Http\Request;

class TrackingController extends Controller
{

    public function index(){
        return view('tracking.index');
    }

    /**
     * Returns a tracking instance
     *
     * @param string $tracking_code
     * @return Tracking
     */
    public function show(string $tracking_code) : Tracking {
        return Tracking::where('tracking_code', $tracking_code)->firstOrFail();
    }
}
