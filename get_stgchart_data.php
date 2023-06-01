<?php
// Connect to your database (replace the credentials with your own)
include 'db_connect.php';

// Get the tasks data from your database
$sql = "SELECT * FROM stgchart WHERE aircraft='" . $_REQUEST['aircraft'] . "' ORDER BY flying_hours";
if (isset($_REQUEST['tail_id'])) {
    $sql = "SELECT * FROM stgchart WHERE aircraft='" . $_REQUEST['aircraft'] . "' AND tail_id='" . $_REQUEST['tail_id'] . "'";
}


$result = $conn->query($sql);

// Format the tasks data as JSON
$tasks = array();

while ($row = $result->fetch_assoc()) {
    $task = array(
        "id" => intval($row["id"]),
        "aircraft" => $row["aircraft"],
        "tail_id" => $row["tail_id"],
        "flying_hours" => intval($row["flying_hours"]),
        "details" => $row["details"],
        "max_hours" => intval($row["max_hours"]),
        "last_updated" => $row["last_updated"]
    );

    $tasks[] = $task;
}

// Set the Content-Type header to application/json
header('Content-Type: application/json');

// Encode the tasks array as JSON and print it
echo json_encode($tasks);
?>
