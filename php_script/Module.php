<?php


function LoginResult($email, $password)
{

    $MyServer = new SERVER('plant');
    $sql = "SELECT * FROM user WHERE Email = '$email' AND Password = '$password'";
    $result = $MyServer->ServerConnection->query($sql);

    $UserObject = ObjectTools::user_to_user_Object($result);

    if ($UserObject != null) {

        return $UserObject[0]->id;
    } else {

        return null;
    }
}

function get_userInfo($id)
{
    $MyServer = new SERVER('plant');
    $sql = "SELECT * FROM user WHERE id = $id";
    $result = $MyServer->ServerConnection->query($sql);

    $UserObjectArray = ObjectTools::user_to_user_Object($result);

    if ($UserObjectArray != null) {
        return  $UserObjectArray[0];
    } else {
        return null;
    }
}


//function to do update operation using the pass parameter
function update_userInfo($id, $Username, $Gender, $Age, $Address)
{
    $MyServer = new SERVER('plant');
    $sql = "UPDATE user
            SET Username = '$Username', Age = '$Age', Gender = '$Gender'
            WHERE id = $id
    ";

    $MyServer->ServerConnection->query($sql);
}

function Changepassword($id, $newpass)
{

    //

    // $matchCurrentPassword = MatchPassword($id, $current);

    // if($matchCurrentPassword){
    //     if($newpass != $confirmpass){
    //         return;
    //     }

    //     $MyServer = new SERVER('plant');
    //     $sql = "UPDATE user
    //             SET Password = '$newpass'
    //             WHERE id = $id
    //     ";
    //     $MyServer->ServerConnection->query($sql);
    // }

    $MyServer = new SERVER('plant');
    $sql = "UPDATE user
            SET Password = '$newpass'
            WHERE id = $id
    ";
    $MyServer->ServerConnection->query($sql);
}

function MatchPassword($id, $matchCurrentPass)
{
    $MyServer = new SERVER('plant');
    $sql = "SELECT Password FROM user WHERE id = $id";
    $result = $MyServer->ServerConnection->query($sql);
    // echo $result[0];

    $rowInformation = array();

    while ($row = $result->fetch_assoc()) {
        $rowInformation[] = $row;
    }

    return  $rowInformation[0];

    // if ($retPass == $matchCurrentPass) {
    //     return true;
    // } else {
    //     return false;
    // }

    // if ($result == $matchCurrentPass) {
    //     return true;
    // } else {
    //     return false;
    // }
}

function Register($Username, $Email, $Password, $Gender, $Age, $Address)
{

    $Age = ($Age == "Male") ? "M" : "F";

    $MyServer = new SERVER('plant');
    $sql = "INSERT INTO user (Username, Email, Password, Gender, Age)
            VALUES ('$Username', '$Email', $Password, '$Gender', '$Age')
    ";
    $MyServer->ServerConnection->query($sql);
}


function get_AllPlantTypes()
{

    $MyServer = new SERVER('plant');
    $sql = "SELECT * FROM more_plant";
    $result = $MyServer->ServerConnection->query($sql);

    $MorePlantObjectArray = ObjectTools::more_plant_to_MorePlant_Object($result);

    //get all the type of the plant
    $types_array = array();

    foreach ($MorePlantObjectArray as $Plant) {

        if (in_array($Plant->plant_type, $types_array)) {
            continue;
        } else {
            $types_array[] = $Plant->plant_type;
        }
    }

    return $types_array;
}


function get_PlantInfo($plant_type)
{
    $MyServer = new SERVER('plant');
    $sql = "SELECT * FROM more_plant WHERE plant_type = \"$plant_type\"";
    $result = $MyServer->ServerConnection->query($sql);

    $MorePlantObjectArray = ObjectTools::more_plant_to_MorePlant_Object($result);

    return $MorePlantObjectArray[0];
}

function get_MyPlant()
{
    $MyServer = new SERVER('plant');
    $sql = "SELECT my_plant.id, my_plant.user_id, my_plant.plant_nickname, more_plant.plant_temp FROM my_plant INNER JOIN more_plant ON my_plant.plant_type = more_plant.plant_type;";
    $result = $MyServer->ServerConnection->query($sql);

    $plantArray = [];

    while ($row = $result->fetch_assoc()) {
        $plantArray[] = $row;
    }

    return $plantArray;
}

function removePlant($id){
    $MyServer = new SERVER('plant');
    $sql = "DELETE FROM my_plant 
        WHERE id = $id
    ";
    $MyServer->ServerConnection->query($sql);

    
}

class Weather
{
    public $json_response;
    public $responseArray;
    public function __construct()
    {
        $this->weather_report_array();
    }
    function weather_report_array()
    {
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

class SERVER
{
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

    public function initiate_connection()
    {
        $conn = new mysqli($this->host, $this->username,  $this->password, $this->database_name);

        if ($conn->connect_error) {
            die("Connection Failed." . $conn->connect_error);
        } else {
            $this->ServerConnection = $conn;
        }
    }
}

class MorePlant
{
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
        $this->plant_temp = $row['plant_temp'];
        $this->plant_scientific_name = $row['plant_scientific_name'];
        $this->plant_trivia = $row['plant_trivia'];
        $this->planting_vid_link = $row['planting_vid_link'];
        $this->plant_images = $row['plant_images'];


        $this->format_temp();
    }

    private function format_temp()
    {
        $temp_range = explode(",", $this->plant_temp);
        $this->Lowest_Temp = $temp_range[0] . "°C";
        $this->Highest_Temp = $temp_range[1] . "°C";
    }

    public function getPlantImages()
    {

        return explode(',', $this->plant_images);
    }
}


class MyPlant
{
    public $id;
    public $user_id;
    public $plant_nickname;
    public $plant_type;
    public $plant_age;
    public $plant_image;
    public $action_suggest;

    public function __construct($row)
    {
        $this->id = $row['id'];
        $this->user_id = $row['user_id'];
        $this->plant_nickname = $row['plant_nickname'];
        $this->plant_type = $row['plant_type'];
        $this->plant_age = $row['plant_age'];
        $this->plant_image = $row['plant_image'];
        $this->action_suggest = $row['action_suggest'];
    }
}

class User
{
    public $id;
    public $Email;
    public $Password;
    public $Username;
    public $Age;
    public $Gender;

    public function __construct($row)
    {
        $this->id = $row['id'];
        $this->Email = $row['Email'];
        $this->Password = $row['Password'];
        $this->Username = $row['Username'];
        $this->Age = $row['Age'];
        $this->Gender = $row['Gender'];
    }
}


class ObjectTools
{
    public static function more_plant_to_MorePlant_Object($result)
    {
        $MorePlantObjectArray = array();

        if ($result) {

            while ($row = $result->fetch_assoc()) {

                $MorePlantObjectArray[] = new MorePlant($row);
            }
            $result->free_result();

            return $MorePlantObjectArray;
        } else {
            return null;
        }
    }

    public static function user_to_user_Object($result)
    {
        $userObjectArray = array();

        if ($result) {
            while ($row = $result->fetch_assoc()) {

                $userObjectArray[] = new User($row);
            }
            $result->free_result();
            return $userObjectArray;
        } else {
            return null;
        }
    }

    public static function my_plant_to_MyPlant_Object($result)
    {
        $MyPlantObjectArray = array();

        if ($result) {
            while ($row = $result->fetch_assoc()) {

                $MyPlantObjectArray[] = new MyPlant($row);
            }
            $result->free_result();

            return $MyPlantObjectArray;
        } else {
            return null;
        }
    }
}


class WeatherForecast
{
}
