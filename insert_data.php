<?php

require_once ("DB_config.php");

// Get the incoming information from the raw input
$data = file_get_contents("php://input");

$json = json_decode($data, true);

$received_at = date('Y-m-d H:i:s');

// application information
$end_device_ids = $json['end_device_ids'];
$device_id = $end_device_ids['device_id'];
$application_id = $end_device_ids['application_ids']['application_id'];

// payload information
$uplink_message = $json['uplink_message'];
$humidity = $uplink_message['decoded_payload']['humidity'];
$temperature = $uplink_message['decoded_payload']['temperature'];

$sqlCommand = "INSERT INTO dht22(device_id, application_id, received_at, humidity, temperature) VALUES ('$device_id', '$application_id', '$received_at', '$humidity', '$temperature')";

mysqli_query($conn, $sqlCommand);

// $arr = array('response' => "1");
// echo json_encode($arr);

echo "1";

?>
