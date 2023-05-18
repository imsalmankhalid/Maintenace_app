<?php include'db_connect.php' ?>




<script>
function loadGanttChart() {
  
    google.charts.load('current', {'packages':['gantt']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
      var selectedProject = $("#project-dropdown").val();
      var jsonData = $.ajax({
        url: "get_maint_data.php?project_id=" + selectedProject,
        dataType: "json",
        async: false
      }).responseText;

      var dataRowCount = JSON.parse(jsonData).length;
      var chartHeight = dataRowCount * 50 + 100; // height of each row is 50px, add 100px for chart title and axis labels
      
      //console.log(jsonData);
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Task ID');
      data.addColumn('string', 'Task Name');
      data.addColumn('date', 'Start Date');
      data.addColumn('date', 'End Date');
      data.addColumn('number', 'Duration');
      data.addColumn('number', 'Percent Complete');
      data.addColumn('string', 'Dependencies');

      const dataArray = JSON.parse(jsonData);
      
       for (var i = 0; i < dataArray.length; i++) {
        console.log(dataArray[i]);
            data.addRow([    dataArray[i].id,
                dataArray[i].name,
                new Date(dataArray[i].start),
                new Date(dataArray[i].end),
                dataArray[i].duration,
                dataArray[i].Percent,
                null
        ]);
      }
      var options = {
        height: chartHeight,
        hAxis: {
          format: 'MMM d'
        },
        gantt: {
          trackHeight: 50,
          barHeight: 30,
              barCornerRadius: 4,
          // Set the base color to green
          labelStyle: {
            fontName: 'Roboto',
            fontSize: 14,
            color: '#000000'
          },
          barCornerRadius: 4,
          barHeight: 30,
          palette: [
            {
              "color": "#db4437",
              "dark": "#0f9d58",
              "light": "#0f9d58"
            }
          ]
        }
};

      var chart = new google.visualization.Gantt(document.getElementById('chart_div'));

      chart.draw(data, options);
    }
}
  </script>


  <div class="col-md-12">
  <?php
    $where = "";
    if($_SESSION['login_type'] == 2){
      $where = " where manager_id = '{$_SESSION['login_id']}' ";
    }elseif($_SESSION['login_type'] == 3){
      $where = " where concat('[',REPLACE(user_ids,',','],['),']') LIKE '%[{$_SESSION['login_id']}]%' ";
    }
    $result = $conn->query("SELECT distinct project_name FROM project_tasks order by project_name asc");
  ?>
  <label for="project-dropdown">Select a Project:</label>
  <select id="project-dropdown" onchange="loadGanttChart()">
    <?php while ($row = $result->fetch_assoc()) { ?>
      <option value="<?php echo $row['project_name']; ?>"><?php echo $row['project_name']; ?></option>
    <?php } ?>
  </select>
  <script>
    loadGanttChart(); // call the function after the drop-down is loaded
  </script>
    <div id="chart_div"></div>
</div>

