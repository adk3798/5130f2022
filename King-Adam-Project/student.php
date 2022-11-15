<?php
    $first_name = $_POST["fName"];
    $last_name = $_POST["lName"];
    $student_email = $_POST["sEmail"];
    $student_id = $_POST["sID"];
    $class = $_POST["class"];
    $class_numbers_filename = "data/$class" . "_numbers.json";
    if (!file_exists($class_numbers_filename)) {
      echo "<p style='color:red;font-size:50px;'>Failed to find permission numbers for $class!</p>";
      exit(1);
    }
    // $class_numbers_file = fopen("$class_numbers_filename", "r");
    $numbers_txt = file_get_contents($class_numbers_filename);
    echo "$numbers_txt<br>";
    $numbers_json = json_decode($numbers_txt, true);
    print_r($numbers_json);
    // foreach ($numbers_json as $key => $value) {
    //   echo "<p style='margin-top:3px;margin-bottom:3px'>$key</p>";
    //   foreach ($value as $num_key => $num_value) {
    //     if (is_bool($num_value)) {
    //       $bool_str = $num_value ? 'true' : 'false';
    //       echo "<p style='margin-top:3px;margin-bottom:3px'>$num_key -> $bool_str</p>";
    //     } else {
    //       echo "<p style='margin-top:3px;margin-bottom:3px'>$num_key -> $num_value</p>";
    //     }
    //   }
    //   echo "<br><br>";
    // }

    echo "OLD VALUES<br>";
    foreach ($numbers_json as $key => $value) {
      if ($value["taken"] == true) {
        $num_fname = $value["fname"];
        $num_lname = $value["lname"];
        $num_id = $value["id"];
        $num_email = $value["email"];
        echo "<p>$key is taken by $num_fname $num_lname with id $num_id and email $num_email</p>";
      } else {
        echo "<p>$key is available</p>";
      }
    }

    $found_free_num = false;
    foreach ($numbers_json as $key => $value) {
      if ($value["taken"] == false) {
        $numbers_json[$key]["taken"] = true;
        $numbers_json[$key]["fname"] = $first_name;
        $numbers_json[$key]["lname"] = $last_name;
        $numbers_json[$key]["id"] = $student_id;
        $numbers_json[$key]["email"] = $student_email;
        echo "<br><p>$key is being given to $first_name $last_name</p>";
        $found_free_num = true;
        break;
      }
    }

    if ($found_free_num == false) {
      echo "<p style='color:red;font-size:50px;'>All permission numbers for $class already taken!</p>";
      exit(1);
    }

    echo "<br><br>NEW VALUES<br>";
    foreach ($numbers_json as $key => $value) {
      if ($value["taken"] == true) {
        $num_fname = $value["fname"];
        $num_lname = $value["lname"];
        $num_id = $value["id"];
        $num_email = $value["email"];
        echo "<p>$key is taken by $num_fname $num_lname with id $num_id and email $num_email</p>";
      } else {
        echo "<p>$key is available</p>";
      }
    }

    $new_numbers_json_txt = json_encode($numbers_json, JSON_PRETTY_PRINT);
    $class_numbers_file = fopen("$class_numbers_filename", "w");
    fwrite($class_numbers_file, $new_numbers_json_txt);
    fclose($class_numbers_file);
    $numbers_txt2 = file_get_contents($class_numbers_filename);
    echo "$numbers_txt2<br>";
    $numbers_json2 = json_decode($numbers_txt2, true);
    print_r($numbers_json2);
    // $info = "$first_name | $last_name | $student_email | $student_id";
    // echo "Welcome $first_name, to the best new, six part, Danish crime drama.";
    // if (file_exists($filename)) {
    //   echo "The file $filename exists";
    // } else {
    //   echo "The file $filename does not exist";
    // }
    // $studentfile = fopen("data/$student_id.txt", "w");
    // fwrite($studentfile, $info);
?>
