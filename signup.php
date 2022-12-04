<?php
    require_once "config.php"; 
    mysqli_select_db($link,'project');
    $username= $_POST['username'];
    $password = $_POST['password'];
    $data = "INSERT INTO project.users (user_name,passphrase) VALUES ('$username','$password')";
    mysqli_query($link, $data);
    header('location:signupsuccessfull.php')
?>