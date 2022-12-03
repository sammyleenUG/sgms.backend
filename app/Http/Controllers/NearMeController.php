<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NearService;
use App\Models\Hostel;

class NearMeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(NearService $Near, Request $request)
    {
        $lat = $request->latitude;
        $lon = $request->longitude;

        //if latitude or longitude are not set
        if ($lat == null || $lon == null) {

            return response(['message' => 'Missing one or more required parameters']);
        }


        $ids = $Near->get_nearest($lat, $lon);

        $hostels = Hostel::whereIn('id', $ids)
            ->select('id', 'h_name','h_lat','h_long')
            ->get();

        return response($hostels);
    }
}
