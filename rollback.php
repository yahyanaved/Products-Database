<?php
require 'config.php';
mysqli_select_db($link,'project');
$link->rollback();
$link -> close();
header('location:orders.php');
?>