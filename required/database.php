<?php
// Connecting to the Database
$servername="localhost";
$dbusername="root";
$dbpassword="root";
$dbname="Bid2Buy";

$conn = mysqli_connect($servername,$dbusername,$dbpassword,$dbname);
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
?>
