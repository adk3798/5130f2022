<?php
    $student_id = $_POST["sID"];
    $class = $_POST["class"];
    $class_numbers_filename = "data/$class" . "_numbers.json";
    if (!file_exists($class_numbers_filename)) {
      echo "<p style='color:red;font-size:50px;'>Failed to find permission numbers for $class!</p>";
      exit(1);
    }
    // $class_numbers_file = fopen("$class_numbers_filename", "r");
    $numbers_txt = file_get_contents($class_numbers_filename);
    // echo "$numbers_txt<br>";
    $numbers_json = json_decode($numbers_txt, true);
    // print_r($numbers_json);

    $found_assigned_num = false;
    $perm_num = NULL;
    foreach ($numbers_json as $key => $value) {
      if ($value["taken"] == true) {
        if ($value["id"] == $student_id) {
          // echo "<br><p>$key belongs to $first_name $last_name</p>";
          $found_assigned_num = true;
          $perm_num = $key;
          break;
        }
      }
    }

    if ($perm_num == NULL) {
      echo "<p style='font-size:20px;'>No assigned permission number found for student ID <b>$student_id</b> for <b>$class</b>. If you need a permission number please go back and use the request form.</p>";
      exit(1);
    }

    $result_str = "";
    if ($found_assigned_num == true){
      $result_str = "Student with ID <b>" . $student_id . "</b> is currently assigned permission number <b>" . $perm_num . "</b> for class <b>" . $class . "</b>. Please use it promptly or it may be given to another student.";
    } else{
      $result_str = "Failed to find assigned permission number";
    }

    echo "<p style='font-size:20px;'>" . $result_str . "</p>";
?>
