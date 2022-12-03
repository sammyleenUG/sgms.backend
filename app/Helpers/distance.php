<?php
if (!function_exists('find_distance_in_km')) {

    function find_distance_in_km(float $lat1,float $lat2,float $lon1,float $lon2): float
    {
        // calculating distance between
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);

        // convert distance to kilometers
        return $dist * 60 * 1.1515 * 1.609344;
    }
}
