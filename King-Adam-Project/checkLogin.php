<?php
// This file was  developed primarily by Adam King (adam_king@student.uml.edu) with input from  Scott Gordon (scott_gordon@student.uml.edu)
  $email = $_POST["fEmail"];
  $password = $_POST["fPassword"];
  $password_hash = hash("sha256", $password);
  $login_filename = 'data/login.json';
  if (!file_exists($login_filename)) {
    echo 'FAILURE';
    return;
  }
  $login_txt = file_get_contents($login_filename);
  $login_json = json_decode($login_txt, true);
  if($login_json['email'] == $email && $login_json['password'] == $password_hash) {
    echo "SUCCESS";
  } else{
    echo "FAILURE";
  }
?>
