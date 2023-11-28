<?php

session_start();
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
$error_array = array();

if(isset($_POST['register_button'])){

    //registracion form values

    //first name
    $fname = strip_tags($_POST['reg_fname']); //remove HTML tags
    $fname = str_replace('','', $fname); //remove spaces
    $fname = ucfirst(strtolower($fname)); //uppercase first letter
    $_SESSION['reg_fname'] = $fname; //stores fname into session variables
    
    //last name
    $lname = strip_tags($_POST['reg_lname']); //remove HTML tags
    $lname = str_replace('','', $lname); //remove spaces
    $lname = ucfirst(strtolower($lname)); //uppercase first letter
    $_SESSION['reg_lname'] = $lname; //stores lname into session variables

    //email
    $em = strip_tags($_POST['reg_email']); //remove HTML tags
    $em = str_replace('','', $em); //remove spaces
    $em = ucfirst(strtolower($em)); //uppercase first letter
    $_SESSION['reg_email'] = $em; //stores email into session variables

    //email 2
    $em2 = strip_tags($_POST['reg_email2']); //remove HTML tags
    $em2 = str_replace('','', $em2); //remove spaces
    $em2 = ucfirst(strtolower($em2)); //uppercase first letter
    $_SESSION['reg_email2'] = $em2; //stores email 2 into session variables

    //password
    $password = strip_tags($_POST['reg_password']); //remove HTML tags

    //password 2
    $password2 = strip_tags($_POST['reg_password2']); //remove HTML tags

    //date
    $date = date("Y-m-d"); //current date

    if($em == $em2) {
        //email is same
        if(filter_var($em, FILTER_VALIDATE_EMAIL)) {
            $em = filter_var($em, FILTER_VALIDATE_EMAIL);

            //check if email exist
            $e_check = mysqli_query($con, "SELECT email FROM users WHERE email='$em'");

            //count the number of rows returned
            $num_rows = mysqli_num_rows($e_check);

            if($num_rows > 0) {
                array_push($error_array, "Email already in use<br>");
            }    


        }
        else{
            array_push($error_array,"Invalid format<br>");
        }

    }    
    else {
        array_push($error_array,"Emails dont match<br>");
    }

    //first name chech
    if(strlen($fname) > 25 || strlen($fname) < 2) {
        array_push($error_array, "Your first name must be between 2 and 25 characters<br>");
    }

    //last name chech
    if(strlen($lname) > 25 || strlen($lname) < 2) {
        array_push($error_array, "Your last name must be between 2 and 25 characters<br>");
    }

    //password chech
    if($password != $password2) {
        array_push($error_array, "Your passwords do not mach<br>");
    }
    else {
        if(preg_match('/[^A-Za-z0-9]/', $password)) {
            array_push($error_array, "Your password can only contain ENG characters and numbers<br>");
    }

    if(strlen($password) > 30|| strlen($password) < 5) {
        array_push($error_array, "Your password must be between 5 and 30 characters<br>");
    }

    if(empty($error_array)) {
        $password = md5($password); //encrypt password before sending to database

        //generete username
        $username = strtolower($fname . "_" . $lname);
        $check_username_query = mysqli_query($con,"SELECT username FROM users WHERE username='$username'");

        $i = 0;
        //if username exist add number to username
        while(mysqli_num_rows($check_username_query) != 0) {
            $i++;
            $username = $username . "_" . $i;
            $check_username_query = mysqli_query($con,"SELECT username FROM users WHERE username='$username'");
    }

    //profile picture assignment
    $rand = rand(1,2); //random number between 1 and 2

    if($rand == 1)
        $profile_pic = "assets/images/profile_pics/defaults/head_deep_blue.png";
    else if($rand == 2)
        $profile_pic = "assets/images/profile_pics/defaults/head_emerald.png";

    $query = mysqli_query($con,"INSERT INTO users VALUES ('', '$fname','$lname','$username', '$em','$password','$date', '$profile_pic', '0', '0', 'no',',')");

    }
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
        <input type="text" name="reg_fname" placeholder="First Name" value="<?php
        if(isset($_SESSION['reg_fname'])){
            echo $_SESSION['reg_fname'];
        } ?>"required>
        <br>
        <?php if(in_array("Your first name must be between 2 and 25 characters<br>", $error_array)) echo "Your first name must be between 2 and 25 characters<br>";?>
        

        <input type="text" name="reg_lname" placeholder="Last Name" value="<?php
        if(isset($_SESSION['reg_lname'])){
            echo $_SESSION['reg_lname'];
        } ?>"required>
        <br>
        <?php if(in_array("Your last name must be between 2 and 25 characters<br>", $error_array)) echo "Your last name must be between 2 and 25 characters<br>";?>

        <input type="email" name="reg_email" placeholder="Email" value="<?php
        if(isset($_SESSION['reg_email'])){
            echo $_SESSION['reg_email'];
        } ?>"required>
        <br>

        <input type="email" name="reg_email2" placeholder="Confirm Email"value="<?php
        if(isset($_SESSION['reg_email2'])){
            echo $_SESSION['reg_email2'];
        } ?>"required>
        <br>
        <?php if(in_array("Email already in use<br>", $error_array)) echo "Email already in use<br>";
        else if(in_array("Invalid format<br>", $error_array)) echo "Invalid format<br>";
        else if(in_array("Emails dont match<br>", $error_array)) echo "Emails dont match<br>";?>
        
        <input type="password" name="reg_password" placeholder="Password" required>
        <br>

        <input type="password" name="reg_password2" placeholder="Confirm Password" required>
        <br>
        <?php if(in_array("Your passwords do not mach<br>", $error_array)) echo "Your passwords do not mach<br>";
        else if(in_array("Your password can only contain ENG characters and numbers<br>", $error_array)) echo "Your password can only contain ENG characters and numbers<br>";
        else if(in_array("Your password must be between 5 and 30 characters<br>", $error_array)) echo "Your password must be between 5 and 30 characters<br>";?>

        <input type="submit" name="register_button" value="Register">
    </form>

</body>
</html>