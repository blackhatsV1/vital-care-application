<?php

include_once 'assets/conn/dbconnect.php';

// Check if 'q' parameter is set and not empty
if(isset($_GET['q']) && !empty($_GET['q'])) {
    $q = $_GET['q'];
    // Perform query
    $res = mysqli_query($con, "SELECT * FROM doctorschedule WHERE scheduleDate='$q'");

    if (!$res) {
        die("Error running query: " . mysqli_error($con));
    }
} else {
    // If 'q' parameter is not set or empty, show error message
    die("Error: Date parameter is missing or empty.");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Schedule</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php 
    // Check if there are any rows returned by the query
    if (mysqli_num_rows($res) == 0) {
        echo "<div class='alert alert-danger' role='alert'>Doctor is not available at the moment. Please try again later.</div>";
    } else {
        echo "<table class='table table-hover'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Day</th>";
        echo "<th>Date</th>";
        echo "<th>Start</th>";
        echo "<th>End</th>";
        echo "<th>Availability</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        
        // Fetch and display rows
        while($row = mysqli_fetch_array($res)) { 
            // Determine availability label color
            $avail = ($row['bookAvail'] != 'available') ? "danger" : "primary";
            echo "<tr>";
            echo "<td>" . $row['scheduleDay'] . "</td>";
            echo "<td>" . $row['scheduleDate'] . "</td>";
            echo "<td>" . $row['startTime'] . "</td>";
            echo "<td>" . $row['endTime'] . "</td>";
            echo "<td><span class='label label-$avail'>" . $row['bookAvail'] . "</span></td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    }
    ?>
</body>
</html>