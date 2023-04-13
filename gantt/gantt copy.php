<!DOCTYPE html>
<html>
<head>
  <title>Gantt Chart Example</title>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load('current', {'packages':['gantt']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Task ID');
      data.addColumn('string', 'Task Name');
      data.addColumn('date', 'Start Date');
      data.addColumn('date', 'End Date');
      data.addColumn('number', 'Duration');
      data.addColumn('number', 'Percent Complete');
      data.addColumn('string', 'Dependencies');

      data.addRows([
        ['Task 1', 'Task 1 Description', new Date(2023, 0, 1), new Date(2023, 0, 31), null, 100, null],
        ['Task 2', 'Task 2 Description', new Date(2023, 1, 1), new Date(2023, 1, 28), null, 100, null],
        ['Task 3', 'Task 3 Description', new Date(2023, 2, 1), new Date(2023, 2, 31), null, 100, null],
        ['Task 4', 'Task 4 Description', new Date(2023, 3, 1), new Date(2023, 3, 30), null, 0, 'Task 3'],
        ['Task 5', 'Task 5 Description', new Date(2023, 4, 1), new Date(2023, 4, 31), null, 0, 'Task 4']
      ]);

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
