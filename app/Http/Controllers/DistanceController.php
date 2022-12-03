<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hostel;

class DistanceController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request): String
    {

        $lat1 = $request->latitude;
        $lon1 = $request->longitude;
        $hostel_id = $request->id;

        //if id, latitude or longitude are not set
        if ($lat1 == null || $lon1 == null || $hostel_id == null) {

            return response(['message' => 'Missing one or more required parameters']);
        }


        //check if hostel exists
        $hostel = Hostel::select('h_lat', 'h_long')->find($hostel_id);

        if ($hostel == null) {

            return response(['message' => 'Hostel with id ' . $hostel_id . ' not found']);
            
        } 

        $lat2 = $hostel->h_lat;
        $lon2 = $hostel->h_long;
        

        if (($lat1 == $lat2) && ($lon1 == $lon2)) {

            return 0 . 'km';

        } else {

            // calculating distance between
            $distance = find_distance_in_km($lat1,$lat2,$lon1,$lon2);

            return response(['Distance' => round($distance, 2) . 'km']);
        }
    }
}
