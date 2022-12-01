<?php
    $student_email = $_POST["sEmail"];
    $class = $_POST["class"];
    $class_numbers_filename = "data/$class" . "_numbers.json";
    if (!file_exists($class_numbers_filename)) {
      echo "<p style='color:red'>Failed to find permission numbers for $class!</p>";
      return;
    }
    $numbers_txt = file_get_contents($class_numbers_filename);
    $numbers_json = json_decode($numbers_txt, true);

    $found_assigned_num = false;
    $perm_num = NULL;
    foreach ($numbers_json as $key => $value) {
      if ($value["taken"] == true) {
        if ($value["email"] == $student_email) {
          $found_assigned_num = true;
          $perm_num = $key;
          break;
        }
      }
    }

    if ($perm_num == NULL) {
      echo "<p>No assigned permission number found for email <b>$student_email</b> for class <b>$class</b>. If you need a permission number please go back and use the request form.</p>";
      return;
    }

    $result_str = "";
    if ($found_assigned_num == true){
      $result_str = "Student with email <b>" . $student_email . "</b> is currently assigned permission number <b>" . $perm_num . "</b> for class <b>" . $class . "</b>. Please use it promptly or it may be given to another student.";
    } else{
      $result_str = "Failed to find assigned permission number";
    }

    echo "<p>" . $result_str . "</p>";
?>
