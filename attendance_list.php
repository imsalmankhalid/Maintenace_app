<!DOCTYPE html>
<html>
<head>
    <title>Attendance List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="card mt-5">
            <div class="card-header">
                <h1 class="text-center">Attendance List</h1>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            // Include database connection code
                            include 'db_connect.php';

                            // Query to fetch attendance records from the database
                            $query = "SELECT * FROM attendance";
                            $result = mysqli_query($conn, $query);

                            // Loop through each row in the result set and display the data in a table
                            while($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>".$row['name']."</td>";
                                echo "<td>".$row['date']."</td>";
                                echo "<td>".$row['status']."</td>";
                                echo "</tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
