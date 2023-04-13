<?php
// Connect to your database (replace the credentials with your own)
include 'connect.php';

// Get the tasks data from your database
$sql = "SELECT * FROM tasks";
$result = $conn->query($sql);


// Format the tasks data as JSON
$tasks = array();

while ($row = $result->fetch_assoc()) {
    $task = array(
        "id" => $row["id"],
        "name" => $row["task_name"],
        "start" => date('Y-m-d', strtotime($row["start_date"])),
        "end" => date('Y-m-d', strtotime($row["end_date"])),
        "duration" => intval($row["duration"]),
        "Percent" => intval($row["logged_days"]),
        "dep" =>'None',
    );

    $tasks[] = $task;
}

// Set the Content-Type header to application/json
header('Content-Type: application/json');

// Encode the tasks array as JSON and print it
echo json_encode($tasks);

?>