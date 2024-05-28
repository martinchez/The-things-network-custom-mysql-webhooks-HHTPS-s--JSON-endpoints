<?php
define('TIMEZONE','Africa/Nairobi');
date_default_timezone_set(TIMEZONE);

define("DB_HOST","https://rs1.rcnoc.com/");
define("DB_USER","anmartco_LoRaDataDB");
define("DB_PASSWORD","Martinwaish1.");
define("DB_DATABASE","anmartco_LoRaDataDB");

$conn = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);

if ($conn -> connect_error) {
    echo "Faliure";
    die("connection failed: ".$conn ->connect_error);
} else{
    echo "Connected successfully";
}
?>