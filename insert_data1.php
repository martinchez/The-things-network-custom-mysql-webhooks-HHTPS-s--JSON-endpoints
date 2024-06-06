<?php

require_once ("DB_config.php"); // This includes the database connection details

// Read the raw POST data
$data = file_get_contents("php://input");

// Check if data is empty
if (empty($data)) {
    file_put_contents("debug_log.txt", "Received data: [empty]\n", FILE_APPEND);
    echo "No data received";
    exit;
}

// Log the raw data for debugging
file_put_contents("debug_log.txt", "Received data: " . $data . "\n", FILE_APPEND);

// Decode the JSON data
$json = json_decode($data, true);

// Check for JSON decode errors
if (json_last_error() !== JSON_ERROR_NONE) {
    // Log the error for debugging
    file_put_contents("debug_log.txt", "JSON decode error: " . json_last_error_msg() . "\nData: " . $data . "\n", FILE_APPEND);
    echo "Invalid JSON data";
    exit;
}

// Proceed if JSON is valid
$received_at = date('Y-m-d H:i:s');

// Extract the application information from the decoded JSON
$end_device_ids = $json['end_device_ids'];
$device_id = $end_device_ids['device_id'];
$application_id = $end_device_ids['application_ids']['application_id'];

// Extract the payload information from the decoded JSON
$uplink_message = $json['uplink_message'];
$decoded_payload = $uplink_message['decoded_payload'];

$distance = $decoded_payload['analog_in_1'];  // Analog Input 1: Distance
$pulse = $decoded_payload['analog_in_2'];     // Analog Input 2: Pulse
$flow_rate = $decoded_payload['analog_in_3']; // Analog Input 3: Flow Rate
$voltage_battery = $decoded_payload['analog_in_4']; // Analog Input 4: Battery Voltage
$voltage_solar = $decoded_payload['analog_in_5'];   // Analog Input 5: Solar Voltage
$voltage_temp = $decoded_payload['analog_in_6'];    // Analog Input 6: Temperature Voltage
$temp = $decoded_payload['analog_in_7'];            // Analog Input 7: Temperature

// Prepare the SQL command
$sqlCommand = "INSERT INTO discharge_data(device_id, application_id, received_at, distance, pulse, flow_rate, voltage_battery, voltage_solar, voltage_temp, temp) 
VALUES ('$device_id', '$application_id', '$received_at', '$distance', '$pulse', '$flow_rate', '$voltage_battery', '$voltage_solar', '$voltage_temp', '$temp')";

// Log the SQL command for debugging
file_put_contents("debug_log.txt", "SQL Command: " . $sqlCommand . "\n", FILE_APPEND);

// Execute the SQL command
if (mysqli_query($conn, $sqlCommand)) {
    echo "Data inserted successfully";
} else {
    // Log the SQL error for debugging
    file_put_contents("debug_log.txt", "SQL Error: " . mysqli_error($conn) . "\n", FILE_APPEND);
    echo "Error inserting data";
}

?>
