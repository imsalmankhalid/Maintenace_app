<?php
$filename = 'aircraft_maint_data.txt';
  $contents = file_get_contents($filename);
    eval($contents);
    $data = $phase_arrays['K8']['500'];
    foreach ($data as $pt) {
        $phase = $pt[0];
        $task = $pt[1];
        $trade = $pt[2];
        $duration = $pt[3];
        $change = $pt[4];
    
        // Do something with the extracted data
        echo "Phase: $phase, Task: $task, Trade: $trade, Duration: $duration, Change: $change\n"."<br>";
    }
?>