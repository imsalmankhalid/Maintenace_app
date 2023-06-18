
<?php
    // Include database connection script
    require_once 'db_connect.php';

    // Read the log file into a string
    $log_file = 'aircraft_maint_data.txt';
    $log_data = file_get_contents($log_file);
    $max_hours = [];
    // Parse the data from the log file
    eval($log_data);

    // Initialize the arrays for the aircraft and their corresponding hours
    $aircraft_array = array_keys($phase_arrays);

    $hours_array = array_unique(array_reduce($phase_arrays, function($result, $value) {
        return array_merge($result, array_keys($value));
    }, array()));

    // Sort the aircraft and hours arrays
    sort($aircraft_array);
    sort($hours_array);

    // Generate the HTML for the aircraft select options
    $aircraft_options = implode('', array_map(function($aircraft_name) {
        return '<option value="' . $aircraft_name . '">' . $aircraft_name . '</option>';
    }, $aircraft_array));

    $aircraft_hours = array();

    // Extract array subscript names
    foreach ($phase_arrays as $aircraft => $hours_array) {
        $hours = array_keys($hours_array);
        $aircraft_hours[$aircraft] = $hours;
    }
    
    // Convert to JSON array
    $json_array = json_encode($aircraft_hours);
    
    // Convert $max_hours to an associative array
    $max_hours_array = [];
    foreach ($max_hours as $index => $value) {
        $max_hours_array[$index] = $value;
    }
?>

<div class="row">
<div class="col-md-8">
    <div class="card card-outline card-primary">
        <div class="card-body">
            <div class="card-header" style="font-weight: bold; font-size: 20px;">
                Register aircraft for stagger chart
            </div>
            <form action="" id="addAircraft">
                <div class="form-group row mb-3">
                    <label for="aircraft" class="col-sm-2 col-form-label">Aircraft:</label>
                    <div class="col-sm-10">
                        <select id="aircraft" name="aircraft" class="form-control">
                            <option value="">-- Select an aircraft --</option>
                            <?php echo $aircraft_options; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="tail_id" class="col-sm-2 col-form-label">Tail Number:</label>
                    <div class="col-sm-10">
                        <input type="text" id="tail_id" name="tail_id" class="form-control">
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="flying_hours" class="col-sm-2 col-form-label">Flying Hours:</label>
                    <div class="col-sm-10">
                        <input type="text" id="flying_hours" name="flying_hours" class="form-control">
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="details" class="col-sm-2 col-form-label">Details:</label>
                    <div class="col-sm-10">
                        <textarea id="details" name="details" class="form-control"></textarea>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="max_hours" class="col-sm-2 col-form-label">Max Hours:</label>
                    <div class="col-sm-10">
                    <input type="text" id="max_hours" name="max_hours" class="form-control" disabled>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-2">
                        <button class="btn btn-primary" form="addAircraft">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="col">
    <div class="card card-outline card-primary">
        <div class="card-body">
            <div class="card-header" style="font-weight: bold; font-size: 20px;">
                Update Flying hours
            </div>
            <form action="" id="updateStatusForm" method="POST">
                <div class="form-group">
                    <label for="aircraftSelect">Select Aircraft:</label>
                    <select id="aircraftSelect" name="aircraftSelect" class="form-control">
                        <option value="">-- Select an aircraft --</option>
                        <?php 
                            $result = $conn->query("SELECT * FROM stgchart where airbase ='".$_SESSION['login_airbase']."'");
                            while ($row = $result->fetch_assoc()) {
                                $projectName = $row['aircraft']."_".$row['tail_id'];
                        ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo $projectName; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">

                    <label for="details" >Details:</label>
                    <div class="col">
                        <textarea id="details" name="details" class="form-control"></textarea>
                    </div>

                    <label for="status">Flying Hours:</label>
                    <input type="text" id="status" name="status" class="form-control" required>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit" name="update">Update</button>
                </div>
                <?php
                    if (isset($_POST['update'])) {
                        $projectName = $_POST['aircraftSelect'];
                        $status = $_POST['status'];
                        $details = $_POST['details'];

                        // Perform the update operation
                        $updateQuery = "UPDATE stgchart SET flying_hours = '$status', details = '$details' WHERE id = '$projectName'";
                        if ($conn->query($updateQuery)) {
                            echo "Update successful! ";
                        } else {
                            echo "Update failed: " . $conn->error;
                        }
                    }
                ?>
            </form>
        </div>
    </div>
</div>





</div>
<?php
    // fetch data from database
    $qry = $conn->query("SELECT  status,phase_name, project_name, details, inspectionType, MAX(end_date) AS last_end_date FROM project_tasks WHERE phase_name = 'stg' and airbase ='".$_SESSION['login_airbase']."' GROUP BY project_name");


    // initialize array to store data
    $data = array();

    // loop through each row and calculate required fields
    while ($row = $qry->fetch_assoc()) {
        $project_name = $row['project_name'];
        $details = $row['details'];
        $last_end_date = $row['last_end_date'];
        $inspectionType = $row['inspectionType'];
        $status = $row['status'];
        $start_date = '';
        $flyingdate = '';

        // fetch the start date for the project
        $result = $conn->query("SELECT start_date FROM project_tasks WHERE project_name = '$project_name' ORDER BY start_date ASC LIMIT 1");
        if ($result->num_rows > 0) {
            $start_date = $result->fetch_assoc()['start_date'];
        }

        // calculate duration by subtracting start date from last end date
        $start = new DateTime($start_date);
        $end = new DateTime($last_end_date);
        $duration = $end->diff($start)->format('%a');

        // calculate percentage of duration and completed duration
        $result = $conn->query("SELECT SUM(completed_duration) AS total_completed_duration FROM project_tasks WHERE project_name = '$project_name' and airbase ='".$_SESSION['login_airbase']."'");

        // split project name by underscore to get aircraft name and tail id
        $name_parts = explode('_', $project_name);
        $aircraft_name = $name_parts[0];
        $tail_id = $name_parts[1];

        // add data to array
        $data[] = array(
            'aircraft_name' => $aircraft_name,
            'tail_id' => $tail_id,
            'start_date' => $start_date,
            'completion_date' => $last_end_date,
            'duration' => $duration,
            'status' => $status,
            'flydate' => $flyingdate,
            'inspectionType' => $inspectionType,
            'details' => $details
        );
    }
?>

<div class="card-header" style="font-weight: bold; font-size: 20px;">
    Stagger Aircraft List (Flying Hours Graph)
</div>
<div class="card-body">
    <button class="btn btn-flat btn-primary" onclick="printChart()"><i class="fa fa-print"></i>Print</button>
    <form action="" id="showStgChart">
        <div class="form-group row mb-3">
            <label for="aircraft" class="col-sm-2 col-form-label">Aircraft:</label>
            <div class="col-sm-4">
                <select id="aircraftstg" name="aircraftstg" class="form-control" onchange="loadChart()">
                    <option value="">-- Select an aircraft --</option>
                    <?php 
                    $result = $conn->query("SELECT distinct aircraft FROM stgchart where airbase ='".$_SESSION['login_airbase']."'");
                    while ($row = $result->fetch_assoc()) {
                        $projectName = $row['aircraft'];
                    ?>
                    <option value="<?php echo $projectName; ?>"><?php echo $projectName; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </form>
    <style>
        canvas {
            max-width: 1000px;
        }
    </style>
    <canvas id="lineChart"></canvas>
    <div id="tableContainer">
    <p>Loading table...</p>
    </div>
</div>
    </div>


<div class="card card-outline card-success">
    <div class="card-body">
        <div class="card-header" style="font-weight: bold; font-size: 20px;">
            <div class="d-flex justify-content-between align-items-center">
            Stagger Aircraft List
            <button class="btn btn-flat btn-primary" onclick="printCard()"><i class="fa fa-print"></i>Print</button>
        </div></div>
        <div class="card-body">
            <input type="text" id="search-input" class="form-control mb-3" placeholder="Search">
            <table class="table table-hover table-condensed" id="list">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Aircraft</th>
                        <th class="text-center">Tail ID</th>
                        <th class="text-center">Flying Hours</th>
                        <th>Details</th>
                        <th>Max Hours</th>
                        <th>Last Updated</th>
                        <th class="text-center">Actions</th> <!-- New column for delete button -->
                    </tr>
                </thead>
                <tbody id="table-body">
                    <?php
                    // Include your database connection
                    include 'db_connect.php';

                    // Query to retrieve data from the stgchart table
                    $sql = "SELECT * FROM stgchart where airbase ='".$_SESSION['login_airbase']."'";
                    $result = $conn->query($sql);
                    $count=0;
                    // Check if there are any rows returned
                    if ($result->num_rows > 0) {
                        // Loop through each row and display the data in table rows
                        while ($row = $result->fetch_assoc()) {
                            $count=$count+1;
                            echo '<tr>';
                            echo '<td class="text-center">' . $count . '</td>';
                            echo '<td class="text-center">' . $row['aircraft'] . '</td>';
                            echo '<td class="text-center">' . $row['tail_id'] . '</td>';
                            echo '<td class="text-center">' . $row['flying_hours'] . '</td>';
                            echo '<td>';
                            echo '<button class="btn btn-link details-toggle" data-toggle="collapse" data-target="#details-row-' . $row['id'] . '">Show Details</button>';
                            echo '<div id="details-row-' . $row['id'] . '" class="collapse">' . $row['details'] . '</div>';
                            echo '</td>';
                            echo '<td>' . $row['max_hours'] . '</td>';
                            echo '<td>' . $row['last_updated'] . '</td>';
                            echo '<td class="text-center">'; // New column for delete button
                            echo '<button class="btn btn-danger delete-btn" data-row="' . htmlspecialchars(json_encode($row)) . '">Delete</button>';
                            echo '</td>';
                            echo '</tr>';
                        }
                    } else {
                        // If no rows are returned, display a message
                        echo '<tr><td colspan="8" class="text-center">No data found.</td></tr>';
                    }

                    // Close the database connection
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



<script>
    function printCard() {
        var printContents = document.getElementById("list").outerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
    function printChart() {
        var canvas = document.getElementById("lineChart");
        var printWindow = window.open('', '', 'width=' + canvas.width + ', height=' + canvas.height);
        printWindow.document.write('<html><head><title>Chart Print</title></head><body><img src="' + canvas.toDataURL() + '"/></body></html>');
        printWindow.document.close();
        printWindow.print();
    }
$(document).ready(function () {
   
    $(".delete-btn").click(function () {
        // Get the row data from the data attribute
        var rowData = ($(this).data('row'));
        console.log(rowData.id);
        var id = rowData.id;
        $.ajax({
            url:'ajax.php?action=add_aircraft_stgchart',
            data: {
                req: "delete",
                id: id,
            },
            method: 'POST',
            success:function(resp){
                
                if(resp == 1){
                    alert_toast('Data successfully saved',"success");
                    setTimeout(function(){
                        location.href = 'index.php?page=add_aircraft_stgchart'
                    },2000)
                }
                else
                {
                    alert_toast(resp, "error",50000);
                }
            }
        })
    });

    $('#aircraftstg').change(function() {
    var aircraft = $(this).val();
    var airbase = "<?php echo $_SESSION['login_airbase']; ?>";
    if (aircraft !== '') {
        $.ajax({
            url: 'get_stgchart_data.php',
            type: 'POST',
            data: { aircraft: aircraft, airbase:airbase},
            success: function(response) {
                var options = '<option> -- Select an tail id </option>';
                if (response.length > 0) {
                    for (var i = 0; i < response.length; i++) {
                        options += '<option value="' + response[i].tail_id + '">' + response[i].tail_id + '</option>';
                    }
                } else {
                    options = '<option value="">-- Select a tail id --</option>';
                }
                $('#tail_idstg').html(options);
                }
            });
        }
    });

});
var maxHoursArray = <?php echo json_encode($max_hours_array); ?>;

    $('#aircraft').change(function() {
            var selectedAircraft = $(this).val();
            console.log(maxHoursArray);
            // Check if the selected value matches any index in maxHoursArray
            if (maxHoursArray.hasOwnProperty(selectedAircraft)) {
                // Access the value from maxHoursArray
                var maxHours = maxHoursArray[selectedAircraft];
                
                // Do something with the maxHours value
                console.log(maxHours);
                
                // Set the value of the max_hours input field
                $('#max_hours').val(maxHours);
            }
            else
            {
                $('#max_hours').val(0);
            }
        });



    // Filter table rows based on search term
    $("#search-input").on("keyup", function() {
        var searchTerm = $(this).val().toLowerCase();
        $("#list tbody tr").each(function() {
            var $row = $(this);
            var rowData = $row.text().toLowerCase();
            if (rowData.indexOf(searchTerm) === -1) {
                $row.hide();
            } else {
                $row.show();
            }
        });
    });


    $('#addAircraft').submit(function(e){
        e.preventDefault(); // Prevent form submission
        var aircraft = $('#aircraft').val();
        if (aircraft === "") {
            alert('Please select an aircraft.');
            exit;
        }
        var tail_id = $('#tail_id').val();
        var flying_hours = $('#flying_hours').val();
        var details = $('#details').val();
        var max_hours = $('#max_hours').val();
        var airbase = "<?php echo $_SESSION['login_airbase']; ?>";
        $.ajax({
            url:'ajax.php?action=add_aircraft_stgchart',
            data: {
                req: "stgchart",
                aircraft: aircraft,
                tail_id: tail_id,
                flying_hours: flying_hours,
                details: details,
                max_hours: max_hours,
                airbase: airbase
            },
            method: 'POST',
            success:function(resp){
                
                if(resp == 1){
                    alert_toast('Data successfully saved',"success");
                    setTimeout(function(){
                        location.href = 'index.php?page=add_aircraft_stgchart'
                    },2000)
                }
                else
                {
                    alert_toast(resp, "error",50000);
                }
            }
        })
    })
    var chart = null;
    var suggestionsTable = null;
    var tableContainer = document.getElementById('tableContainer');

    function loadChart() {
      if (chart) {
        chart.destroy();
      }

      var aircraft = $('#aircraftstg').val();
      var airbase = "<?php echo $_SESSION['login_airbase']; ?>";

      $.getJSON("get_stgchart_data.php", { aircraft: aircraft, airbase: airbase })
        .done(function (jsonData) {
          const tailIds = jsonData.map(item => item.tail_id);
          const flyingHours = jsonData.map(item => item.flying_hours);
          const maxHours = jsonData.map(item => item.max_hours);
          const flyingHours2 = jsonData.map(item => Math.min(item.flying_hours, item.max_hours));
          // Calculate the slope line values
          const slopeLine = [];
          const initialFlyingHours = 0;
          const slope = (maxHours[maxHours.length - 1] - initialFlyingHours) / (flyingHours.length - 1);
          for (let i = 0; i < flyingHours.length; i++) {
            slopeLine.push(initialFlyingHours + slope * i);
          }

          const ctx = document.getElementById('lineChart').getContext('2d');
          chart = new Chart(ctx, {
            type: 'line',
            data: {
              labels: tailIds,
              datasets: [{
                label: 'Flying Hours',
                data: flyingHours2,
                borderColor: 'blue',
                backgroundColor: 'rgba(0, 0, 255, 0.2)',
                pointBackgroundColor: 'blue',
                pointRadius: 4,
                pointHoverRadius: 6,
                fill: false
              }, {
                label: 'Slope Line',
                data: slopeLine,
                borderColor: 'red',
                borderDash: [5, 5],
                fill: false
              }],
            },
            options: {
              scales: {
                y: {
                  min: 0,
                  max: Math.max(...maxHours),
                  ticks: {
                    stepSize: 20
                  }
                }
              },
              plugins: {
                tooltip: {
                  callbacks: {
                    label: function (context) {
                      const dataIndex = context.dataIndex;
                      const yValue = context.raw.y;
                      const diff = yValue - slopeLine[dataIndex];
                      return `Difference: ${diff}`;
                    }
                  }
                }
              }
            }
          });

          // Create suggestions table
          createSuggestionsTable(tailIds, flyingHours, slopeLine);
        })
        .fail(function (jqxhr, textStatus, error) {
          console.log("Error retrieving data: " + error);
          showTablePlaceholder("Failed to load data.");
        });
    }

    function createSuggestionsTable(tailIds, flyingHours, slopeLine) {
  suggestionsTable = document.createElement('table');
  suggestionsTable.classList.add('table', 'table-bordered');

  var tableHeader = suggestionsTable.createTHead();
  var headerRow = tableHeader.insertRow();
  headerRow.insertCell().innerHTML = '<b>Tail ID</b>';
  headerRow.insertCell().innerHTML = '<b>Flying Hours</b>';
  headerRow.insertCell().innerHTML = '<b>Suggested Value (+/-)</b>';

  for (let i = 0; i < tailIds.length; i++) {
    const tailId = tailIds[i];
    const flyingHour = flyingHours[i];
    const suggestion = flyingHour - slopeLine[i] > 0 ? 'Over Flying: ' : (flyingHour - slopeLine[i] < 0 ? 'Under Flying: ' : '');
    const diff = Math.abs(flyingHour - slopeLine[i]).toFixed(2); // Limit decimal to 2 points

    const newRow = suggestionsTable.insertRow();
    newRow.insertCell().textContent = tailId;
    newRow.insertCell().textContent = flyingHour;
    
    const suggestionCell = newRow.insertCell();
    suggestionCell.innerHTML = suggestion + diff + ' Hours';
    
    if (suggestion === 'Over Flying: ') {
      suggestionCell.style.fontWeight = 'bold';
      suggestionCell.style.color = 'red';
    } else if (suggestion === 'Under Flying: ') {
      suggestionCell.style.fontWeight = 'bold';
      suggestionCell.style.color = 'blue';
    }
    else{
        suggestionCell.style.fontWeight = 'bold';
      suggestionCell.style.color = 'green'; 
    }
  }

  tableContainer.innerHTML = `
  <div class="card card-outline card-success">
      <div class="card-header" style="font-weight: bold; font-size: 20px;">
        <h5 class="card-title">Flying Analysis</h5>
      </div>
      <div class="card-body">
        <table class="table table-hover table-condensed" id="list">
          ${suggestionsTable.outerHTML}
        </table>
      </div>
    </div>
  `;
}


    function showTablePlaceholder(message) {
      tableContainer.innerHTML = '<p>' + message + '</p>';
    }

</script>
