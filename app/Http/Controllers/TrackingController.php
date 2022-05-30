<?php

namespace App\Http\Controllers;

use App\Models\Tracking;
use App\Services\TrackingService;
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
    public function show(Request $request) : Tracking {
        // When using complex forms, a FormRequest class should be used to handle the validation
        if (!$request->has('tracking_code') || empty($request->tracking_code)) {
            abort("400", 'Tracking code is missing');
        }

        sleep(1); // simulate network

        $tracking = (new TrackingService())->find($request->tracking_code);
        
        if ($request->ajax()){
            return $tracking;
        } else {
            // return a  view to support javascript disabled browsers
            // in a more complex scenario we could have different routes, but for now this will work
            dd( $tracking->toJson() );
        }
    }
}
