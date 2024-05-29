<?php

require_once ("DB_config.php"); // This includes the database connection details

$data = file_get_contents("php://input");
$json = json_decode($data, true);

$received_at = date('Y-m-d H:i:s');

// Extract the application information from the decoded JSON.
$end_device_ids = $json['end_device_ids'];
$device_id = $end_device_ids['device_id'];
$application_id = $end_device_ids['application_ids']['application_id'];

// Extract the payload information from the decoded JSON.
$uplink_message = $json['uplink_message'];
$decoded_payload = $uplink_message['decoded_payload'];

$distance = $decoded_payload[1];  // Analog Input 1: Distance
$pulse = $decoded_payload[2];     // Analog Input 2: Pulse
$flow_rate = $decoded_payload[3]; // Analog Input 3: Flow Rate
$voltage_battery = $decoded_payload[4]; // Analog Input 4: Battery Voltage
$voltage_solar = $decoded_payload[5];   // Analog Input 5: Solar Voltage
$voltage_temp = $decoded_payload[6];    // Analog Input 6: Temperature Voltage
$temp = $decoded_payload[7];            // Analog Input 7: Temperature

$sqlCommand = "INSERT INTO discharge_data(device_id, application_id, received_at, distance, pulse, flow_rate, voltage_battery, voltage_solar, voltage_temp, temp) 
VALUES ('$device_id', '$application_id', '$received_at', '$distance', '$pulse', '$flow_rate', '$voltage_battery', '$voltage_solar', '$voltage_temp', '$temp')";

mysqli_query($conn, $sqlCommand);

echo "1";

?>
