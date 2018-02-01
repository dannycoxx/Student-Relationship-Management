<?php
// echo ("db_config");
    // $db_hostname = "mysql";
    // $db_database = "u5dc";
    // $db_username = "u5dc";
    // $db_password = "12-abcd-34";

    $db_hostname = "localhost";
    $db_database = "srm";
    $db_username = "root";
    $db_password = "";

    $db_con = mysqli_connect($db_hostname, $db_username, $db_password, $db_database);
    mysqli_set_charset($db_con,"utf8");

    if (!$db_con) {
        die("Connection failed: ".mysqli_connect_error);
    } 
    // echo ("/db_config");
?>