<?php

$opencageApiKey = '88accf2c52d04a86bfecfacfcac45fbe';
$tomorrowIoApiKey = '8BGotHZzLsqfzhFlTZ0cCkC09UGTyYEy';
$country = 'Philippines'; // Replace with the actual country name
$city = 'Manila'; // Replace with the actual city name

// Step 1: Get latitude and longitude from OpenCage Geocoding API
$opencageApiUrl = "https://api.opencagedata.com/geocode/v1/json?q=$city,$country&key=$opencageApiKey";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $opencageApiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
curl_close($ch);

$geocodingData = json_decode($response, true);

if (!$geocodingData || !isset($geocodingData['results'][0]['geometry']['lat']) || !isset($geocodingData['results'][0]['geometry']['lng'])) {
    echo 'Error getting coordinates from OpenCage Geocoding API.';
    exit;
}

$latitude = $geocodingData['results'][0]['geometry']['lat'];
$longitude = $geocodingData['results'][0]['geometry']['lng'];

// Step 2: Make Tomorrow.io API request
$tomorrowIoApiUrl = "https://api.tomorrow.io/v4/weather/forecast?location=$latitude,$longitude&apikey=$tomorrowIoApiKey";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $tomorrowIoApiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Error: ' . curl_error($ch);
} else {
    // Process the $response data here
    echo $response;
}

curl_close($ch);
?>
