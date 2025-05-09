<?php 
    $connect=mysqli_connect("localhost","root","","expense");
    if(!$connect)
        die("Connection failed: " . mysqli_connect_error());
    // else
    //     echo "connection successfull";
?>