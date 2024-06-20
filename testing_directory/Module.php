<?php

class Weather{
    public $json_response;
    public $responseArray;
    public function __construct()
    {
        $this->weather_report_array();
    }
    function weather_report_array(){
        $opencageApiKey = '88accf2c52d04a86bfecfacfcac45fbe';
        $tomorrowIoApiKey = '8BGotHZzLsqfzhFlTZ0cCkC09UGTyYEy';
        $country = 'Philippines'; 
        $city = 'Manila'; 

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


        $tomorrowIoApiUrl = "https://api.tomorrow.io/v4/weather/forecast?location=$latitude,$longitude&apikey=$tomorrowIoApiKey";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $tomorrowIoApiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch);
        } 

        curl_close($ch);

        $data = json_decode($response, true);

        // Check if decoding was successful
        if ($data === null) {
            echo "Error decoding JSON";
        } else {
            // Access the "minutely" property and convert each item to an object
            $minutelyArray = array_map(function ($item) {
                return (object)$item;
            }, $data['timelines']['minutely']);

        }
        
        $this->json_response = $response;

        $this->responseArray = $minutelyArray;
        

        

    }

}

class SERVER {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database_name = null;
    public $ServerConnection = null;
    
    public function __construct($databasename)
    {
        $this->database_name = $databasename;
        $this->initiate_connection();
    }

    public function initiate_connection(){
        $conn = new mysqli($this->host, $this->username,  $this->password, $this->database_name); 

        if($conn->connect_error){
            die("Connection Failed." . $conn->connect_error);
        }else{
            $this->ServerConnection = $conn;
        }
        
    }
}

class MorePlant{
    public $id;
    public $plant_type;
    public $planting_procedure;
    public $plant_temp;
    public $plant_scientific_name;
    public $plant_trivia;
    public $plant_images;
    public $planting_vid_link;
    public $Lowest_Temp;
    public $Highest_Temp;

    public function __construct($row)
    {
        $this->id = $row['id'];
        $this->plant_type = $row['plant_type'];
        $this->planting_procedure = $row['planting_procedure'];
        $this->plant_temp= $row['plant_temp'];
        $this->plant_scientific_name = $row['plant_scientific_name'];
        $this->plant_trivia = $row['plant_trivia'];
        $this->planting_vid_link = $row['planting_vid_link'];
        $this->plant_images = $row['plant_images'];


        $this->format_temp();
    }

    private function format_temp(){
        $temp_range = explode(",", $this->plant_temp);
        $this->Lowest_Temp = $temp_range[0] . "°C";
        $this->Highest_Temp = $temp_range[1] . "°C";
    }
}


class ObjectTools{
    public static function more_plant_to_MorePlant_Object($result){
        $MorePlantObjectArray = array();

        if($result){

            while($row = $result->fetch_assoc()){

                $MorePlantObjectArray[] = new MorePlant($row);

            }
            $result->free_result();
            
            return $MorePlantObjectArray;
        }
        else{
            return null;
        }
    }
}


class WeatherForecast{
    
}





?>