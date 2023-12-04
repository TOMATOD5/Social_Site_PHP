
<?php

session_start();

if(isset($_POST['login_button'])) {
    $email = filter_var($_POST['log_email'], FILTER_SANITIZE_EMAIL);
    $_SESSION['log_email'] = $email;

    // Hash the password using a stronger method (e.g., password_hash)
    $password = password_hash($_POST['log_password'], PASSWORD_DEFAULT);

    // Establish database connection
    $con = mysqli_connect("localhost", "root", "", "social");
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $check_database_query = mysqli_query($con, "SELECT * FROM users WHERE email='$email'");
    if (!$check_database_query) {
        die('Query Error: ' . mysqli_error($con));
    }

    $row = mysqli_fetch_array($check_database_query);
    if (password_verify($_POST['log_password'], $row['password'])) {
        $username = $row['username'];
        $_SESSION['username'] = $username;

        // ... Additional logic

        header("Location: index.php");
        exit();
    } else {
        array_push($error_array, "Email or password was incorrect<br>");
    }
}

?>
