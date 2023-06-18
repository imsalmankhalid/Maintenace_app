<?php

include 'db_connect.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get input values from form
    $taskId = $_POST['task_id'];
    $userId = 0;

    // Get current logged days and duration for the task
    $sql = "SELECT logged_days, duration FROM tasks WHERE id = '$taskId' AND user_id = '$userId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $loggedDays = $row['logged_days'];
        $duration = $row['duration'];
        
        // Check if the task has reached its duration
        if ($loggedDays < $duration) {
            $loggedDays++;
            
            // Update the logged days for the task
            $sql = "UPDATE tasks SET logged_days = '$loggedDays' WHERE id = '$taskId' AND user_id = '$userId'";
            if ($conn->query($sql) === TRUE) {
                echo "Task logged successfully!";
            } else {
                echo "Error logging task: " . $conn->error;
            }
        } else {
            echo "Task has already reached its duration!";
        }
    } else {
        echo "Task not found for user!";
    }
}
?>