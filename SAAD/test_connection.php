<?php
include 'connection.php';

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
echo "Database connection successful!";
?>
