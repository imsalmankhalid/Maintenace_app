<!DOCTYPE html>
<html>
<head>
<?php include 'db_connect.php'; ?>
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
    <h2>Log Task Form</h2>
    <form action="">
    <div class="form-group">
	            <label for="aircraft_id">Aircraft:</label>
	            <select class="form-control" id="aircraft_id" name="aircraft_id">
	                <option>Select aircraft</option>
	            </select>
	        </div>
        <div class="form-group">
	            <label for="tail_id">Tail ID:</label>
	            <select class="form-control" id="tail_id" name="tail_id">
	                <option>Select tail ID</option>
	            </select>
	    </div>
        <div class="form-group">
	            <label for="phase_name">Phase Name:</label>
	            <select class="form-control" id="phase_name" name="phase_name">
	                <option>Select Phase</option>
	            </select>
	    </div>
        <div class="form-group">
	            <label for="task_name">Task Name:</label>
	            <select class="form-control" id="task_name" name="task_name">
	                <option>Select Task</option>
	            </select>
	    </div>
        <div class="form-group">
            <div class="row">
                <div class="col">
                    <label for="task_start">Task ID:</label>
                    <input type="text" class="form-control" id="task_id" name="task_id" readonly>
                </div>
                <div class="col">
                    <label for="task_start">Task Start Date:</label>
                    <input type="text" class="form-control" id="task_start" name="task_start" readonly>
                </div>
                <div class="col">
                    <label for="task_end">Task Expected End Date:</label>
                    <input type="text" class="form-control" id="task_end" name="task_end" readonly>
                </div>
                <div class="col">
                    <label for="task_duration">Task Duration:</label>
                    <input type="text" class="form-control" id="task_duration" name="task_duration" readonly>
                </div>
                <div class="col">
                    <label for="task_duration">Task Remaining Duration:</label>
                    <input type="text" class="form-control" id="task_remain_duration" name="task_remain_duration" readonly>
                </div>
            </div>
        </div>
        <input type="hidden" id="user_id" name="user_id" value="1">
        <div class="form-group">
    <div class="row">
        <div class="col-sm-3">    
            <label for="days">Select Days to log:</label>
            <select class="form-control" id="days" name="days"></select>
        </div>
        <div class="col">
            <label for="details">Details:</label>
            <input type="text" class="form-control" id="details" name="details">
        </div>
    </div>
</div>

        <button type="submit" class="btn btn-primary" id="log-task-button">Log Task for Today</button>
    </form>
</div>

</body>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script>
        function load_tail_id()
        {
            var aircraft_id = $("#aircraft_id").val();
                $.ajax({
                    url: "load_maint_data.php",
                    type: "POST",
                    data: {aircraft_id: aircraft_id},
                    success: function(data){
                        data = JSON.parse(data);
                        var options = "<option>Select Tail ID</option>";
                        $.each(data, function(index, value){
                            options += "<option value='" + value.project_name + "'>" + value.project_name + "</option>";
                        });
                        $("#tail_id").html(options);
                    }
                });
        }

            $(document).ready(function(){
                // Load aircraft options
                $.ajax({
                    url: "load_maint_data.php",
                    type: "POST",
                    data: {type: "aircraft"},
                    success: function(data){
                        data = JSON.parse(data);
                        var options ="";
                        $.each(data, function(index, value){
                            options += "<option value='" + value.project_name + "'>" + value.project_name + "</option>";
                        });
                        $("#aircraft_id").html(options);
                        load_tail_id();
                    }
                });
            });


			// Load tail ID options
            $("#aircraft_id").change(function(){
                load_tail_id();
            });

			// Load phase name options
			$("#tail_id").change(function(){
                var project_name = $("#tail_id").val();
				$.ajax({
					url: "load_maint_data.php",
					type: "POST",
					data: {project_name: project_name},
					success: function(data){
                        data = JSON.parse(data);
                        var options =  "<option>Select Phase</option>";
                        $.each(data, function(index, value){
                            options += "<option value='" + value.phase_name + "'>" + value.phase_name + "</option>";
                        });
                        $("#phase_name").html(options);
					}
				});
				$("#task_name").html("<option>Select phase name first</option>");
			});

			// Load task name options
			$("#phase_name").change(function(){
				var project_name = $("#tail_id").val();
				var phase_name = $(this).val();
				$.ajax({
					url: "load_maint_data.php",
					type: "POST",
					data: {project_name: project_name, phase_name: phase_name},
					success: function(data){
                        data = JSON.parse(data);
                        var options = "<option>Select Task</option>";
                        $.each(data, function(index, value){
                            options += "<option value='" + value.task_name + "'>" + value.task_name + "</option>";
                        });
						$("#task_name").html(options);
					}
				});
			});
            $("#task_name").change(function(){
				var project_name = $("#tail_id").val();
				var phase_name = $("#phase_name").val();
                var task_name = $("#task_name").val();

				$.ajax({
					url: "load_maint_data.php",
					type: "POST",
					data: {project_name: project_name, phase_name: phase_name, task_name: task_name},
					success: function(data){
                        console.log(data);
                        data = JSON.parse(data)[0];
                        $("#task_id").val(data.id);
                        $("#task_duration").val(data.duration);
                        $("#task_start").val(data.start_date);
                        $("#task_end").val(data.end_date);
                        $("#task_remain_duration").val(data.duration - data.completed_duration);
                        var options = "<option>Select Days to Log</option>";
                        for (var i = 1; i <= data.duration; i++) {
                            options += "<option value='" + i + "'>" + i + "</option>";
                        }
                        $("#days").html(options);
					}
				});
			});

            $("#log-task-button").click(function(event) {
                event.preventDefault(); // prevent form submission
                var hasEmpty = false;
                $("select").each(function() {
                if ($(this).attr("id") !== "aircraft_id" && $(this).prop('selectedIndex') <= 0) {
                    hasEmpty = true;
                    return false;
                }
                });
                if (hasEmpty) {
                    alert("Please fill in all the fields before submitting.");
                } else {
                    var project_name = $("#tail_id").val();
                    var phase_name = $("#phase_name").val();
                    var task_name = $("#task_name").val();
                    var details = $("#details").val();
                    if($("#task_remain_duration").val() == 0)
                    {
                        alert_toast("Task already completed", "error");
                        return false;
                    }

                    $.ajax({
					url: "load_maint_data.php",
					type: "POST",
					data: {project_name: project_name, phase_name: phase_name, task_name: task_name, duration:0, details:details},
					success: function(data){
                        console.log(data);
                        alert_toast("Task updated", "success");
                        setTimeout(function(){
						location.href = 'index.php?page=add_maint_log'
					    },2000)
					}
				});
                }
            });
	</script>

</html>

