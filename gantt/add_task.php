<?php
include 'connect.php';

// Get task data from POST request
$task_name = $_POST["task_name"];
$start_date = $_POST["start_date"];
$end_date = $_POST["end_date"];
$start = new DateTime($start_date);
$end = new DateTime($end_date);

// Calculate duration based on difference in days
$duration = $end->diff($start)->days + 1;

$logged_days = $_POST["logged_days"];

// Add task for user with ID "root"
$sql = "INSERT INTO tasks (task_name, start_date, end_date, duration, logged_days, user_id) VALUES ('$task_name', '$start_date', '$end_date', '$duration', '$logged_days', 'root')";

if ($conn->query($sql) === TRUE) {
    echo "Task added successfully.";
} else {
    echo "Error adding task: " . $conn->error;
}

$conn->close();
?>
