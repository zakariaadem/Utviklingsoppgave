<?php
// Server kobling info
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "utviklingsoppgave db";

// Create connection
$kobling = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($kobling->connect_error) {
  die("Connection failed: " . $kobling->connect_error);
}
?>