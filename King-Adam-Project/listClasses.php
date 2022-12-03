<?php
// This file was  developed primarily by Adam King (adam_king@student.uml.edu) with input from  Scott Gordon (scott_gordon@student.uml.edu)
  $data_files = scandir('data');
  $classes = array();
  $class_file_end = "_numbers.json";
  $cfe_len = strlen($class_file_end);
  foreach ($data_files as $f) {
    if ( substr_compare($f, $class_file_end, -$cfe_len) === 0 ) {
      $f_len = strlen($f);
      array_push($classes, substr($f, 0, $f_len - $cfe_len));
    }
  }
  echo implode("\n", $classes);
?>
