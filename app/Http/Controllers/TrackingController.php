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

        // using a service we can separate the business logic from the other layers of the application
        // this also allows for reusing the code from other points (should the need of it arises)
        // it is also the first step for easier testing, or for more advanced decoupling of the structure
        // such as the use of interfaces or composer packages
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
