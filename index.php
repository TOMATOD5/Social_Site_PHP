<?php

$con = mysqli_connect("localhost", "root", "", "social");

if(mysqli_connect_errno())
{
    echo "Failed to connect". mysqli_connect_errno();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Friendfinder</title>
</head>
<body>
    <p>Hi!</p>
</body>
</html>