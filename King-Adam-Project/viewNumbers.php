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

    if ($class_file == NULL) {
      echo "<p style='color:red'>Unknown class $class!</p>";
      return;
    }

    $class_numbers_txt = file_get_contents($class_file);
    $class_numbers_json = json_decode($class_numbers_txt, true);

    $out = "<table border='2' style='font-size:20px;margin:5px'>";
    $out = $out . "<tr><td>Number</td><td>Taken</td><td>First Name</td><td>Last Name</td><td>Student ID</td><td>Email</td></tr>";

    foreach ($class_numbers_json as $key => $value) {
      $out = $out . "<tr><td>" . $key . "</td>";
      if ($value["taken"] == true) {
        $out = $out . "<td>True</td><td>" . $value['fname'] . "</td><td>" . $value['lname'] . "</td>";
        $out = $out . "<td>" . $value['id'] . "</td><td>" . $value['email']. "</td>";
      } else {
        $out = $out . "<td>False</td><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td>";
      }
      $out = $out . "</tr>";
    }

    $out = $out . "</table>";
    echo $out;
?>
