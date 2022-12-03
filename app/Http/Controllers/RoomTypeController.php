<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoomType;
use App\Models\Hostel;
use App\Http\Requests\RoomTypeRequest;

class RoomTypeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(RoomTypeRequest $request)
    {
      

        //check if hostel exists or not
        $hostel = Hostel::find($request->hostel_id);

        if ($hostel != null) {

            //generate json
            $room_details = [
                strtolower($request->room_type) => [
                    'room_price' => $request->room_price,
                    'room_description' => strtolower($request->room_description),
                ],
            ];


            //check if hostel rooms are there or not
            $rooms = RoomType::where('hostel_id', $request->hostel_id)->value('rooms');

            if ($rooms != null) {

                //edit rooms json array
                $rooms_array = json_decode($rooms, true);

                $room_details += $rooms_array;

            }


            //insert to database
            $add = RoomType::updateOrInsert(
                [
                    'hostel_id' => $request->hostel_id
                ],
                [
                    'rooms' => json_encode($room_details),
                    'created_at' => NOW(),
                ]
            );

            if ($add != null) {


                return response(['message' => 'Room type added successfully']);


            } else {


                return response(['message' => 'An error occurred']);


            }
        } else {


            return response(['message' => 'Hostel with id ' . $request->hostel_id . ' not found']);

        }
    }
}
