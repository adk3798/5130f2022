<?php
    $first_name = $_POST["fName"];
    $last_name = $_POST["lName"];
    $student_email = $_POST["sEmail"];
    $student_id = $_POST["sID"];
    $class = $_POST["class"];
    $class_numbers_filename = "data/$class" . "_numbers.json";
    if (!file_exists($class_numbers_filename)) {
      echo "<p style='color:red'>Failed to find permission numbers for $class!</p>";
      exit(1);
    }
    $numbers_txt = file_get_contents($class_numbers_filename);
    $numbers_json = json_decode($numbers_txt, true);

    $found_assigned_num = false;
    $found_free_num = false;
    $perm_num = NULL;
    foreach ($numbers_json as $key => $value) {
      if ($value["taken"] == true) {
        if ($value["id"] == $student_id) {
          if ($value["email"] != $student_email) {
            # update email if student provides different one for same id
            $numbers_json[$key]["email"] = $student_email;
          }
          $found_assigned_num = true;
          $perm_num = $key;
          break;
        }
      }
    }

    if ($found_assigned_num == false) {
      foreach ($numbers_json as $key => $value) {
        if ($value["taken"] == false) {
          $numbers_json[$key]["taken"] = true;
          $numbers_json[$key]["fname"] = $first_name;
          $numbers_json[$key]["lname"] = $last_name;
          $numbers_json[$key]["id"] = $student_id;
          $numbers_json[$key]["email"] = $student_email;
          $found_free_num = true;
          $perm_num = $key;
          break;
        }
      }
    }

    if ($perm_num == NULL) {
      echo "<p style='color:red'>All permission numbers for class $class already taken!</p>";
      return;
    }

    $new_numbers_json_txt = json_encode($numbers_json, JSON_PRETTY_PRINT);
    $class_numbers_file = fopen("$class_numbers_filename", "w");
    fwrite($class_numbers_file, $new_numbers_json_txt);
    fclose($class_numbers_file);


    $result_str = "";
    if ($found_free_num == true) {
      $result_str = "You have been assigned permission number " . $perm_num . " for class " . $class . ". Please use it promptly or it may be given to another student.";
    } elseif ($found_assigned_num == true){
      $result_str = "Student with ID " . $student_id . " already assigned permission number " . $perm_num . " for class " . $class . ". Please use it promptly or it may be given to another student.";
    } else{
      $result_str = "Failed to acquire permission number";
    }

    echo "<p>" . $result_str . "</p>";
?>
