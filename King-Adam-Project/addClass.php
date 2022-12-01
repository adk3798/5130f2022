<?php
    $class = $_POST["class"];

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

    if ($class_file != NULL) {
      echo "<p style='color:red'>Class $class already exists!</p>";
      return;
    }

    $class_file = "data/" . $class . "_numbers.json";
    $new_class_json_txt = json_encode(array(), JSON_PRETTY_PRINT);
    $class_numbers_file = fopen("$class_file", "w");
    fwrite($class_numbers_file, $new_class_json_txt);
    fclose($class_numbers_file);

    $out = "<span style='white-space: pre-line'>Successfully added class $class!\n";
    $out = $out . "</span>";
    echo $out;
?>
