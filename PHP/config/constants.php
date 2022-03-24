<?php 
    session_start();
    define('SITEURL', 'http://localhost/PHP');
    $conn = mysqli_connect('localhost', 'root', '') or die(mysqli_connect_error());
    $db_select = mysqli_select_db($conn, 'foodordering') or die(mysqli_connect_error());
?>