<?php
// Connect to MySQL database
$conn = mysqli_connect("127.0.0.1", "username", "password", "university");
if (!$conn) {
    die("Unable to connect" . mysqli_connect_error());
}
?>
