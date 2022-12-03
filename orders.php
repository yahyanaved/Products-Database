<?php
require 'config.php';
//mysqli_select_db($link,'project');
$nonce = file_get_contents("nonce.txt");
$sql = "DELETE FROM orders where nonce = ?" ;
if($stmt = mysqli_prepare($link, $sql)){
    mysqli_stmt_bind_param($stmt, "s", $nonce);
    if(mysqli_stmt_execute($stmt)){
        header("location: order.php");
        exit();
    } else{
        echo "Oops! Something went wrong. Please try again later.";
    }
}
header('location:order.php');
?>