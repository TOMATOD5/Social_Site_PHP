<?php  
require 'config/config.php';

if (isset($_SESSION['username'])) {
    $userLoggedIn = $_SESSION['username'];
}

?>

<html>
<head>
	<title>Welcome to Social!</title>
</head>
<body>

    radom