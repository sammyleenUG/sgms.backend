<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hostel;
use App\Http\Requests\AddHostelRequest;
use App\Http\Requests\UpdateHostelRequest;

class HostelsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $results = $request->results;
        $with_room_types = $request->with_room_types;

        //if results param is not set
        if ($results == null) {
            $results = 10;
        }

        // retrieve results


        if ($with_room_types) {
            //get paginated results iof hostels with only room types
            return Hostel::join('room_type', 'hostels.id', 'room_type.hostel_id')
                ->select(
                    'hostels.id',
                    'hostels.h_name',
                    'hostels.h_location',
                    'h_lat',
                    'h_long',
                    'h_min_price',
                    'h_max_price',
                    'h_imagepath'
                )
                ->latest('hostels.id')
                ->simplePaginate($results);
        } else {
            //get paginated results of all hostels
            return Hostel::leftJoin('room_type', 'hostels.id', 'room_type.hostel_id')
                ->select(
                    'hostels.id',
                    'hostels.h_name',
                    'hostels.h_location',
                    'h_lat',
                    'h_long',
                    'h_min_price',
                    'h_max_price',
                    'h_imagepath'
                )
                ->latest('hostels.id')
                ->simplePaginate($results);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddHostelRequest $request)
    {

        // insert into the database
        $add = Hostel::create(
            [
                'h_name' => strtolower($request->h_name),
                'h_location' => strtolower($request->hostel_location),
                'h_lat' => $request->hostel_latitude,
                'h_long' => $request->hostel_longitude,
                'h_min_price' => $request->hostel_min_price,
                'h_max_price' => $request->hostel_max_price,
                'h_amenities' => strtolower($request->hostel_amenities),
                'h_imagepath' => $request->hostel_image_url,
                'created_at' => NOW(),
            ]
        );

        if ($add != null) {

            return response(['message' => 'Hostel added successfully']);
        } else {


            return response(['message' => 'An error occured']);
        }
    }




    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateHostelRequest $request, $id)
    {

        //find the hostel
        $hostel = Hostel::find($id);

        if ($hostel != null) {

            // make sure their is no duplicate hostel
            $check = Hostel::where('id', '!=', $id)->where('h_name', $request->h_name)->first();

            if ($check == null) {
                // insert into the database
                $add = Hostel::where('id', $id)
                    ->update(
                        [
                            'h_name' => strtolower($request->h_name),
                            'h_location' => strtolower($request->hostel_location),
                            'h_lat' => $request->hostel_latitude,
                            'h_long' => $request->hostel_longitude,
                            'h_min_price' => $request->hostel_min_price,
                            'h_max_price' => $request->hostel_max_price,
                            'h_amenities' => strtolower($request->hostel_amenities),
                            'h_imagepath' => $request->hostel_image_url,
                            'created_at' => NOW(),
                        ]
                    );

                if ($add != null) {


                    return response(['message' => 'Hostel updated successfully']);
                } else {


                    return response(['message' => 'An error occured']);
                }
            } else {


                return response(['message' => 'Hostel with the name ' . $request->h_name . ' already exists']);
            }
        } else {

            return response(['message' => 'Hostel with id ' . $id . ' not found']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hostel = Hostel::find($id);

        if ($hostel != null) {

            $hostel->delete();
        } else {

            return response(['message' => 'Hostel with id ' . $id . ' not found']);
        }


        return response(['message' => 'Hostel deleted successfully']);
    }
}
