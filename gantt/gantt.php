<!DOCTYPE html>
<html>
<head>
  <title>Gantt Chart Example</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load('current', {'packages':['gantt']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
      var jsonData = $.ajax({
        url: "get_tasks.php",
        dataType: "json",
        async: false
      }).responseText;

      
      console.log(jsonData);
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Task ID');
      data.addColumn('string', 'Task Name');
      data.addColumn('date', 'Start Date');
      data.addColumn('date', 'End Date');
      data.addColumn('number', 'Duration');
      data.addColumn('number', 'Percent Complete');
      data.addColumn('string', 'Dependencies');

      const dataArray = JSON.parse(jsonData);
      
      //data.addRows(dataArray[0]);
                //  ['1', 'fdgsfgf', '2023-04-14', '2023-04-27', 45, 45, 45]
      //data.addRows([ [dataArray[0].id, dataArray[0].name, new Date(dataArray[0].start), new Date(dataArray[0].end), dataArray[0].duration, dataArray[0].Percent, null]]);
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

    //   data.addRows([
    //     ['Task 1', 'Task 1 Description', new Date(2023, 0, 1), new Date(2023, 0, 31), null, 100, null],
    //     ['Task 2', 'Task 2 Description', new Date(2023, 1, 1), new Date(2023, 1, 28), null, 100, null],
    //     ['Task 3', 'Task 3 Description', new Date(2023, 2, 1), new Date(2023, 2, 31), null, 100, null],
    //     ['Task 4', 'Task 4 Description', new Date(2023, 3, 1), new Date(2023, 3, 30), null, 0, 'Task 3'],
    //     ['Task 5', 'Task 5 Description', new Date(2023, 4, 1), new Date(2023, 4, 31), null, 0, 'Task 4']
    //   ]);

      var options = {
        height: 400,
        gantt: {
          trackHeight: 30
        }
      };

      var chart = new google.visualization.Gantt(document.getElementById('chart_div'));

      chart.draw(data, options);
    }
  </script>
</head>
<body>
  <div id="chart_div"></div>
</body>
</html>
