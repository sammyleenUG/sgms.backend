<?php

namespace App\Services;

use App\Models\Hostel;

use App\Services\NearService;

class NearMe implements NearService
{
  private $near_km = 0.05;

  public function get_nearest($lat, $lon): array
  {

    //array of hostels ID's
    $near_hostels = array();

    $all_hostels  = Hostel::select('id', 'h_lat', 'h_long')->get();

    //get distances of these hostels from user location
    foreach ($all_hostels as $hostel) {
      $distance = find_distance_in_km($lat, $hostel->h_lat, $lon, $hostel->h_long);

      if ($distance <= $this->near_km) {
        $near_hostels[] = $hostel->id;
      }
    }

    if (count($near_hostels) == 0 && $this->near_km < 1) {
      $this->near_km += 0.2;
      return $this->get_nearest($lat, $lon);
    } else {
      return $near_hostels;
    }
  }
}
