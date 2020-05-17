<?php

  require 'config.php';

$name_error=$email_error=$phone_error=$message_error="";
$name=$email=$phone=$message="";
$div="";
if(isset($_POST["submit"])){
if($_SERVER['REQUEST_METHOD']=='POST'){
  if(empty($_POST["name"])){
    $name_error="Shkruani emrin tuaj";
  }else {
    $name=$_POST["name"];
    if(!preg_match("/^[a-z A-Z]*$/",$name)){
      $name_error="Vetem shkronjat lejohen";
    }
  }

  if(empty($_POST["email"])){
    $email_error="Shkruani email-in tuaj";
  }
  else{
    $email=$_POST["email"];
    if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
      $email_error="Format i gabuar i email-it";
    }
  }

  if(empty($_POST["phone"])){
    $phone_error="Shkruani numrin e telefonit";
  }else{
    $phone=$_POST["phone"];
    if(!preg_match("/^[+][\d]{3}[-][\d]{2}[-][\d]{3}[-][\d]{3}$/",$phone)){
     $phone_error="Format i gabuar i numrit. '+xxx-xx-xxx-xxx'";
    }
  }

  if(empty($_POST["message"])){
    $message_error="Shkruani mesazhin";
  }
  else{
    $message=$_POST["message"];
  }

}

if($name_error=='' and $email_error=='' and $message_error=='' and $phone_error==''){
  $div="Te dhenat u proceduan me sukses";
  $msg_type="success";
  $query=$conn->prepare("INSERT INTO kerkesat(emri,email,phone,mesazhi) VALUES (?,?,?,?)");
  $query->bind_param("ssss",$name,$email,$phone,$message);
  $query->execute();
}
else {
  $div="Te dhenat nuk jane proceduar";
  $msg_type="danger";
}




}

 ?>
