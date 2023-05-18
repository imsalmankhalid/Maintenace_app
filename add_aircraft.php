<?php
    // Include database connection script
    require_once 'db_connect.php';

    // Read the log file into a string
    $log_file = 'aircraft_maint_data.txt';
    $log_data = file_get_contents($log_file);

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

    // Generate the HTML for the hours select options
    $hours_options = '';
    foreach ($hours_array as $hours_value) {
        $hours_options .= '<option value="' . $hours_value . '">' . $hours_value . '</option>';
    }
?>


<div class="col-md-8">
	<div class="card card-outline card-primary">
		<div class="card-body">
			<form action="" id="addAircraft">
                <div class="form-group row mb-3">
                    <label for="aircraft" class="col-sm-2 col-form-label">Aircraft:</label>
                    <div class="col-sm-10">
                    <select id="aircraft" name="aircraft" class="form-control">
                        <option value="">-- Select an aircraft --</option>
                        <option value="K8">K-8 (AJTS)</option>
                        <option value="SMK">Super Mushak (PFT)</option>
                        <option value="T37">T-37 (BFT)</option>
                        <!-- Add more aircraft options here -->
                    </select>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="tail_number" class="col-sm-2 col-form-label">Tail Number:</label>
                    <div class="col-sm-10">
                    <input type="text" id="tail_number" name="tail_number" class="form-control">
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="inspection_type" class="col-sm-2 col-form-label">Inspection Type:</label>
                    <div class="col-sm-10">
                    <select id="inspection_type" name="inspection_type" class="form-control">
                        <option value="">-- Select an inspection type --</option>
                        <option value="scheduled">Scheduled</option>
                        <option value="unscheduled">Unscheduled</option>
                    </select>
                    </div>
                </div>

                <div id="scheduled_inspection" style="display:none;">
                    <div class="form-group row mb-3">
                    <label for="hours" class="col-sm-2 col-form-label">Number of Hours:</label>
                    <div class="col-sm-10">
                        <select id="hours" name="hours" class="form-control">
                        <option value="">-- Select number of hours --</option>
                        </select>
                    </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="start_date" class="col-sm-2 col-form-label">Start Date:</label>
                        <div class="col-sm-10">
                            <input type="date" id="start_date" name="start_date" class="form-control form-control-sm" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                    </div>
                </div>

                <div id="unscheduled_inspection" style="display:none;">
                    <div class="form-group row mb-3">
                    <label for="details" class="col-sm-2 col-form-label">Details:</label>
                    <div class="col-sm-10">
                        <textarea id="details" name="details" class="form-control"></textarea>
                    </div>
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

<?php
    // fetch data from database
    $qry = $conn->query("SELECT project_name, details,  MAX(end_date) AS last_end_date FROM project_tasks GROUP BY project_name");

    // initialize array to store data
    $data = array();

    // loop through each row and calculate required fields
    while ($row = $qry->fetch_assoc()) {
        $project_name = $row['project_name'];
        $details = $row['details'];
        $last_end_date = $row['last_end_date'];
        $start_date = '';

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
        $result = $conn->query("SELECT SUM(completed_duration) AS total_completed_duration FROM project_tasks WHERE project_name = '$project_name'");
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($row['total_completed_duration'] === null) {
                $status = 0;
            } else {
                $status = round($row['total_completed_duration'] / $duration * 100);
            }
        } else {
            $status = 0;
        }

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
            'details' => $details
        );
    }

    // output data as HTML table
?>


<div class="card card-outline card-primary">
    <div class="card-body">
        <div class="card card-outline card-success">
            <div class="card-header" style="font-weight: bold; font-size: 20px;">
                Maintenance Aircraft List
            </div>
            <div class="card-body">
                <table class="table table-hover table-condensed" id="list">
                    <colgroup>
                        <col width="5%">
                        <col width="35%">
                        <col width="15%">
                        <col width="15%">
                        <col width="20%">
                        <col width="10%">
                    </colgroup>
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Aircraft Name</th>
                            <th class="text-center">Tail ID</th>
                            <th>Date Started</th>
                            <th>Completion Date</th>
                            <th>Duration</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $i => $row) { ?>
                            <tr class="expandable-row">
                                <td class="text-center"><?php echo $i + 1 ?></td>
                                <td class="text-center"><?php echo $row['aircraft_name']; ?></td>
                                <td class="text-center"><?php echo $row['tail_id']; ?></td>
                                <td><?php echo $row['start_date'] ?></td>
                                <td><?php echo $row['completion_date'] ?></td>
                                <td><?php echo $row['duration'] ?></td>
                                <td><?php echo $row['status'] ?>%</td>
                            </tr>
                            <tr class="expanded-row" style="display: none;">
                                <td colspan="7">
                                    <!-- Placeholder for the expanded table -->
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<script>

$(document).ready(function () {
    $('.expandable-row').click(function () {
        var expandedRow = $(this).next('.expanded-row');

        if (expandedRow.is(':visible')) {
            expandedRow.hide();
        } else {
            // Remove the previous expanded rows to ensure only one expanded row is visible at a time
            $('.expanded-row').hide();

            // Generate the content for the expanded table based on the clicked row's data
            var rowData = $(this).find('td').map(function () {
                return $(this).text();
            }).get();

            // Create the expanded table with the desired content
            var expandedTable = $('<table>').addClass('table table-hover table-condensed');
            var headers = ['Header 1', 'Header 2', 'Header 3']; // Replace with your actual header names

            // Create table headers
            var headerRow = $('<tr>');
            headers.forEach(function (header) {
                headerRow.append($('<th>').text(header));
            });
            expandedTable.append(headerRow);

            // Create table rows
            var dataRow = $('<tr>');
            rowData.forEach(function (data) {
                dataRow.append($('<td>').text(data));
            });
            expandedTable.append(dataRow);

            // Replace the placeholder with the generated expanded table
            expandedRow.find('td').html(expandedTable);
            expandedRow.show();
        }
    });
});

    document.addEventListener("DOMContentLoaded", function() {
        const inspectionTypeSelect = document.getElementById("inspection_type");
        const scheduledInspectionDiv = document.getElementById("scheduled_inspection");
        const unscheduledInspectionDiv = document.getElementById("unscheduled_inspection");
        inspectionTypeSelect.addEventListener("change", function() {
            if (inspectionTypeSelect.value === "scheduled") {
                scheduledInspectionDiv.style.display = "block";
                unscheduledInspectionDiv.style.display = "none";
            } else {
                scheduledInspectionDiv.style.display = "none";
                unscheduledInspectionDiv.style.display = "block";
            }
        });
    });

    $("#aircraft").change(function(){
        var aircraft = $(this).val();
        var options = [];
        
        switch (aircraft) {
            case "SMK":
                options = ["100", "400"];
                break;
            case "K8":
                options = ["500", "100", "1500"];
                break;
            case "T37":
                options = ["500", "1000"];
                break;
            default:
                break;
        }
        
        var optionsHtml = "";
        for (var i = 0; i < options.length; i++) {
            optionsHtml += "<option value='" + options[i] + "'>" + options[i] + "</option>";
        }
        
        $("#hours").html(optionsHtml);
    });



    $('#addAircraft').submit(function(e){
        e.preventDefault(); // Prevent form submission
        var aircraft = $('#aircraft').val();
        var tail_number = $('#tail_number').val();
        var inspection_type = $('#inspection_type').val();
        var hours = $('#hours').val();
        var start_date = $('#start_date').val();
        var details = $('#details').val();
        console.log(hours);
        $.ajax({
            url:'ajax.php?action=add_aircraft_maint',
            data: {
                aircraft: aircraft,
                tail_number: tail_number,
                inspection_type: inspection_type,
                hours: hours,
                start_date: start_date,
                details: details
            },
            method: 'POST',
            success:function(resp){
                
                if(resp == 1){
                    alert_toast('Data successfully saved',"success");
                    setTimeout(function(){
                        location.href = 'index.php?page=maint_list'
                    },2000)
                }
                else
                {
                    alert_toast(resp, "error",50000);
                }
            }
        })
    })

</script>
