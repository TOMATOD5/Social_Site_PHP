<?php

$con = mysqli_connect("localhost", "root", "", "social");

if(mysqli_connect_errno())
{
    echo "Failed to connect". mysqli_connect_errno();
}

//declaring variebles
$fname = ""; 
$lname = "";
$em = "";
$em2 = "";
$password = "";
$password2 = "";
$date = "";
$error_array = "";

if(isset($_POST['register_button'])){

    //registracion form values

    //first name
    $fname = strip_tags($_POST['reg_fname']); //remove HTML tags
    $fname = str_replace('','', $fname); //remove spaces
    $fname = ucfirst(strtolower($fname)); //uppercase first letter
    
    //last name
    $lname = strip_tags($_POST['reg_lname']); //remove HTML tags
    $lname = str_replace('','', $lname); //remove spaces
    $lname = ucfirst(strtolower($lname)); //uppercase first letter

    //email
    $em = strip_tags($_POST['reg_email']); //remove HTML tags
    $em = str_replace('','', $em); //remove spaces
    $em = ucfirst(strtolower($em)); //uppercase first letter

    //email 2
    $em2 = strip_tags($_POST['reg_email2']); //remove HTML tags
    $em2 = str_replace('','', $em2); //remove spaces
    $em2 = ucfirst(strtolower($em2)); //uppercase first letter

    //password
    $password = strip_tags($_POST['reg_password']); //remove HTML tags

    //password 2
    $password2 = strip_tags($_POST['reg_password2']); //remove HTML tags

    //date
    $date = date("Y-m-d"); //current date

    if($em == $em2) {
        //email is same
    }
    else {
        echo"Emails dont match";
    

    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>

<body>
    <form action="register.php" method="POST">
        <input type="text" name="reg_fname" placeholder="First Name" required>
        <br>
        <input type="text" name="reg_lname" placeholder="Last Name" required>
        <br>
        <input type="email" name="reg_email" placeholder="Email" required>
        <br>
        <input type="email" name="reg_email2" placeholder="Confirm Email" required>
        <br>
        <input type="password" name="reg_password" placeholder="Password" required>
        <br>
        <input type="password" name="reg_password2" placeholder="Confirm Password" required>
        <br>
        <input type="submit" name="register_button" value="Register">
    </form>

</body>
</html>