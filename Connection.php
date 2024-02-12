<?php
    $server="localhost";
    $username="root";
    $password="";
    $database="firstattempt";
    $con=mysqli_connect($server, $username, $password, $database);
    if (!$con){
        die("Connection to this database failed due to" . mysqli_connect_error());
    }
    // error_reporting(E_ALL ^ E_WARNING); 
    // echo "Successful database connection.<br>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        *{
            padding:10px;
        }
    </style>
</head>
<body>
    
</body>
</html>