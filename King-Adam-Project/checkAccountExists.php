<?php
// This file was  developed primarily by Adam King (adam_king@student.uml.edu) with input from  Scott Gordon (scott_gordon@student.uml.edu)
  $login_filename = 'data/login.json';
  if (!file_exists('data')) {
    mkdir('data', 0777, true);
  }
  if (!file_exists($login_filename)) {
    echo 'FAILURE';
    return;
  }
  $login_txt = file_get_contents($login_filename);
  $login_json = json_decode($login_txt, true);
  if(array_key_exists('email', $login_json) && array_key_exists('password', $login_json)) {
    echo "SUCCESS";
    return;
  } else{
    echo "FAILURE";
    return;
  }
?>
