<?php
    $db_server="localhost";
    $db_user= "root";
    $db_pass= "";
    $db_name= "user";

    $conn = mysqli_connect("$db_server", "$db_user","$db_pass","$db_name");

    if($conn->connect_error){
        die("Connection Failed". $conn->connect_error);
    }
?>