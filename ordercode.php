<?php
require 'config.php';
mysqli_select_db($link,'project');
//$link->begin_transaction();
$sql = "start transaction;" ;
$link->query($sql);
$sql = "savepoint cart;";
$link->query($sql);
$filename = 'nonce.txt';

if (file_exists($filename)) {
    $myfile = fopen($filename, "a");
    $nonce = "a";
    fwrite($myfile, $nonce);
    fclose($myfile);
}
else {
    $myfile = fopen($filename, "w");
    $nonce = "a";
    fwrite($myfile, $nonce);
    fclose($myfile);
}
header('location:ordercreate.php');
?>