<?php
require("backend.php");
session_start();
$output = "";
echo $output;
$user_input = $_POST["search"];
$result = $mysqli->query("SELECT * from employee WHERE name LIKE '%{$user_input}%' LIMIT 5");
if (mysqli_num_rows($result) > 0) {
    while ($row = $result->fetch_array()) {
        $emp_id = $row['emp_id'];
        $output .= "<a href='view.php?viewid={$emp_id}' title='view'><p>" . $row["name"] . "</p></a>";
    }
    echo $output;
} else {
    echo "Employee Not Found";
}
