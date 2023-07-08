<?php

/**
 *
 * Function to generate reference number
 *
 */
function gen_ref_number(int $id)
{
    if ($id < 10) {
        $id = '00' . $id;
    } else if ($id < 100) {
        $id = '0' . $id;
    }

    return 'SGMS-' . date('Ymd') . '-' . $id;
}



/**
 *
 * Function to get name of a place using coordinates
 *
 */

function getLocation($latitude, $longitude)
{
    $apiKey = env('GOOGLE_MAPS_API_KEY');

    // Create a request URL
    $requestUrl = "https://maps.googleapis.com/maps/api/geocode/json?latlng={$latitude},{$longitude}&key={$apiKey}";

    // Make a GET request to the API
    $response = file_get_contents($requestUrl);

    // Parse the JSON response
    $data = json_decode($response, true);

    // Check if the request was successful
    if ($data['status'] === 'OK') {
        // Retrieve the first result
        $result = $data['results'][0];

        // Extract the formatted address
        $formattedAddress = $result['formatted_address'];

        return $formattedAddress;
    } else {
        return  "Error";
    }
}


function saveNotification($title,$icon,$category,$action = Null){
    \App\Models\Notification::query()->insert([
        'title' => $title,
        'icon' => $icon,
        'category' => $category,
        'action'=> $action,
        'created_at' => now(),
    ]);
}
