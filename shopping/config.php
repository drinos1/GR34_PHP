<?php
  $conn=new mysqli("localhost","root","admin","shopping");
  if($conn->connect_error){
    die("Lidhja me bazen e te dhenave deshtoi!".$conn->connect_error);
  }

 ?>
