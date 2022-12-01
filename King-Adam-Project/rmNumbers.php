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

    foreach ($numbers as $n) {
      if (empty($n)) {
        unset($numbers[array_search($n, $numbers)]);
      }
    }

    foreach ($class_numbers_json as $key => $value) {
      if (in_array($key, $numbers)) {
        array_push($number_exists, $key);
        unset($numbers[array_search($key, $numbers)]);
      }
    }

    foreach ($number_exists as $num) {
      unset($class_numbers_json[$num]);
    }

    $new_numbers_json_txt = json_encode($class_numbers_json, JSON_PRETTY_PRINT);
    $class_numbers_file = fopen("$class_file", "w");
    fwrite($class_numbers_file, $new_numbers_json_txt);
    fclose($class_numbers_file);

    $out = "<span style='white-space: pre-line'>Successfully removed permission numbers!\n";
    if (!empty($number_exists)) {
      $out = $out . "\nPermission numbers removed from $class:\n";
      $out = $out . implode("\n", $number_exists);
      $out = $out . "\n";
    } else {
      $out = $out . "\nNo permission numbers provided that existed for $class\n";
    }
    if (!empty($numbers)) {
      $out = $out . "\nPermission numbers that already did not exist for $class:\n";
      $out = $out . implode("\n", $numbers);
    }
    $out = $out . "</span>";
    echo $out;
?>
