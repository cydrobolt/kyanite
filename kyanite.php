<?php
/*
 * Kyanite core tracking component
 */
require_once 'req.php';
$ip = $_SERVER['REMOTE_ADDR'];
$ua = $_SERVER['HTTP_USER_AGENT'];
$ref = $_SERVER['HTTP_REFERER']||"NOT AVAILABLE";
$date = date("m/d/Y");
$now = date("m/d/Y G:i:s");
$query = "INSERT INTO info (ip,ua,ref,date) VALUES ('$ip','$ua','$ref','$date')";
$res = $mysqli->query($query) or kyalog("$now - Could not send data to the database.");
$mysqli->query($query);
$mysqli->close();
?>