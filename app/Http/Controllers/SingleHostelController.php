<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hostel;
use App\Models\RoomType;

class SingleHostelController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($hostel_id, Request $request)
    {

        $lat = $request->latitude;
        $lon = $request->longitude;

        //if latitude or longitude are not set
        if ($lat == null || $lon == null) {

            return response(['message' => 'Missing one or more required parameters']);
        }
        // check if hostel exists
        $hostel = Hostel::leftJoin('room_type', 'hostels.id', 'room_type.hostel_id')
            ->where('hostels.id', $hostel_id)
            ->select('hostels.*', 'room_type.rooms')
            ->first();

        if ($hostel == null) {
            return response(['message' => 'Hostel with id ' . $hostel_id . ' not found']);
        }

        $distance = find_distance_in_km($lat, $hostel->h_lat, $lon, $hostel->h_long);

        

        return response(['hostel' => $hostel, 'distance' => $distance]);
    }
}
