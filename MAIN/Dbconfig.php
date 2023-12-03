
<?php


    $host = "localhost";
    $port = 3306;
    $socket = "";
    $user = "root";
    $password = "Techstas@123";
    $dbname = "nazeem_delivery";
    //$dbname = "delivery_db";

    $con = mysqli_connect($host, $user, $password, $dbname, $port, $socket);


    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit;
    }




?>