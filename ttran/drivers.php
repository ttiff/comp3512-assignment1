<?php

require_once 'includes/config.inc.php';
require_once 'includes/db-classes.inc.php';

try {
    $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));

    $driverGateway = new DriverDB($conn);

    $drivers = $driverGateway->getAll();
} catch (Exception $e) {
    die($e->getMessage());
}

if (isset($_GET['driverRef'])) {
    $driverRef = $_GET['driverRef'];

    $driver = $driverGateway->getDriverByDriverRef($driverRef);

    if ($driver) {
        $raceResults = $driverGateway->getRaceResultsByDriverRef($driverRef);
    } else {
        die("Driver not found.");
    }
} else {
    $driver = null;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>F1 Driver Details and Race Results</title>

</head>

<body>

    <body>
        <h3>Select a Driver</h3>
        <form method="get" action="<?= $_SERVER['REQUEST_URI'] ?>">
            <label for="driverSelect">Driver:</label>
            <select name="driverRef" id="driverSelect">
                <option value="0">Select Driver</option>
                <?php
                foreach ($drivers as $row) {
                    echo "<option value='" . ($row['driverRef']) . "'";
                    if (isset($driverRef) && $driverRef == $row['driverRef']) {
                        echo " selected";
                    }
                    echo ">" . ($row['forename']) . " " . ($row['surname']) . "</option>";
                }
                ?>
            </select>
            <button type="submit">View Results</button>
        </form>

        <?php
        if ($driver) {
            echo "<h1>Driver Details</h1>";
            echo "<p>Name: " . ($driver['forename']) . " " . ($driver['surname']) . "</p>";
            echo "<p>Date of Birth: " . ($driver['dob']) . "</p>";
            echo "<p>Age: " . ($driver['age']) . "</p>";
            echo "<p>Nationality: " . ($driver['nationality']) . "</p>";
            echo "<a href='" . ($driver['url']) . "' target='_blank'>Driver Biography</a>";

            echo "<h2>Race Results - 2022 Season</h2>";
            echo "<table>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>Round</th>";
            echo "<th>Circuit</th>";
            echo "<th>Position</th>";
            echo "<th>Points</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            if ($raceResults) {
                foreach ($raceResults as $result) {
                    echo "<tr>";
                    echo "<td>" . ($result['round']) . "</td>";
                    echo "<td>" . ($result['circuit']) . "</td>";
                    echo "<td>" . ($result['position']) . "</td>";
                    echo "<td>" . ($result['points']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No results available for the 2022 season.</td></tr>";
            }

            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<p>Please select a driver to view details and race results for the 2022 season.</p>";
        }
        ?>


    </body>

</html>