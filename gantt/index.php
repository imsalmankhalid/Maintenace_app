<!DOCTYPE html>
<html>
<head>
    <title>Add Task Form</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container mt-5">
    <h2>Add Task Form</h2>
    <form action="add_task.php" method="post">
        <div class="form-group">
            <label for="task_name">Task Name:</label>
            <input type="text" class="form-control" id="task_name" name="task_name" required>
        </div>
        <div class="form-group">
            <label for="start_date">Start Date:</label>
            <input type="date" class="form-control" id="start_date" name="start_date" required>
        </div>
        <div class="form-group">
            <label for="end_date">End Date:</label>
            <input type="date" class="form-control" id="end_date" name="end_date" required>
        </div>
        <div class="form-group">
            <label for="duration">Duration (in days):</label>
            <input type="number" class="form-control" id="duration" name="duration" min="1" required>
        </div>
        <div class="form-group">
            <label for="logged_days">Number of Logged Days:</label>
            <input type="number" class="form-control" id="logged_days" name="logged_days" min="0" required>
        </div>
        <input type="hidden" id="user_id" name="user_id" value="1">
        <button type="submit" class="btn btn-primary">Add Task</button>
    </form>
</div>

</body>
</html>
