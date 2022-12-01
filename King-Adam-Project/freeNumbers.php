<?php
    $class = $_POST["class"];
    $numbers_txt = $_POST["numbers"];
    $numbers = explode("\n", $numbers_txt);

    $data_files = scandir('data');
    $class_file = NULL;
    $class_file_end = "_numbers.json";
    $cfe_len = strlen($class_file_end);
    foreach ($data_files as $f) {
      if ( substr_compare($f, $class_file_end, -$cfe_len) === 0 ) {
        $f_len = strlen($f);
        if (substr($f, 0, $f_len - $cfe_len) == $class) {
          $class_file = "data/" . $f;
        }
      }
    }

    if ($class_file == NULL) {
      echo "<p style='color:red'>Unknown class $class!</p>";
      return;
    }

    $class_numbers_txt = file_get_contents($class_file);
    $class_numbers_json = json_decode($class_numbers_txt, true);
    $number_exists = [];
    $numbers_free = [];

    foreach ($numbers as $n) {
      if (empty($n)) {
        unset($numbers[array_search($n, $numbers)]);
      }
    }

    foreach ($class_numbers_json as $key => $value) {
      if (in_array($key, $numbers)) {
        if($class_numbers_json[$key]['taken'] == false) {
          array_push($numbers_free, $key);
          unset($numbers[array_search($key, $numbers)]);
        } else {
          array_push($number_exists, $key);
          unset($numbers[array_search($key, $numbers)]);
        }
      }
    }

    foreach ($number_exists as $num) {
      $class_numbers_json[$num]['taken'] = false;
    }

    $new_numbers_json_txt = json_encode($class_numbers_json, JSON_PRETTY_PRINT);
    $class_numbers_file = fopen("$class_file", "w");
    fwrite($class_numbers_file, $new_numbers_json_txt);
    fclose($class_numbers_file);

    $out = "<span style='white-space: pre-line'>Successfully freed permission numbers!\n";
    if (!empty($number_exists)) {
      $out = $out . "\nPermission numbers freed for class $class:\n";
      $out = $out . implode("\n", $number_exists);
      $out = $out . "\n";
    } else {
      $out = $out . "\nNo permission numbers provided that existed and were taken for $class\n";
    }
    if (!empty($numbers_free)) {
      $out = $out . "\nPermission numbers that were already free for class $class:\n";
      $out = $out . implode("\n", $numbers_free);
      $out = $out . "\n";
    }
    if (!empty($numbers)) {
      $out = $out . "\nPermission numbers that did not exist for class $class:\n";
      $out = $out . implode("\n", $numbers);
    }
    $out = $out . "</span>";
    echo $out;
?>
