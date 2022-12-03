<?php
// This file was  developed primarily by Adam King (adam_king@student.uml.edu) with input from  Scott Gordon (scott_gordon@student.uml.edu)
  $email = $_POST["email"];
  $password = $_POST["password"];
  $password_hash = hash("sha256", $password);
  $login_filename = 'data/login.json';
  $info = array("email" => $email, "password" => $password_hash);
  $login_json_txt = json_encode($info, JSON_PRETTY_PRINT);
  $login_file = fopen("$login_filename", "w");
  fwrite($login_file, $login_json_txt);
  fclose($login_file);
  echo "SUCCESS";
?>
