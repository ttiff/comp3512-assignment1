<?php

require_once 'includes/config.inc.php';
require_once 'includes/db-classes.inc.php';

try {
    $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));

    $constructorGateway = new ConstructorDB($conn);

    $constructors = $constructorGateway->getAll();
} catch (Exception $e) {
    die($e->getMessage());
}

if (isset($_GET['constructorRef'])) {
    $constructorRef = $_GET['constructorRef'];

    $constructor = $constructorGateway->getConstructorByConstructorRef($constructorRef);

    if ($constructor) {
        $raceResults = $constructorGateway->getRaceResultsByConstructorRef($constructorRef);
    } else {
        die("Constructor not found.");
    }
} else {
    $constructor = null;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>F1 Constructor Details and Race Results</title>
</head>

<body>
    <h3>Select a Constructor</h3>
    <form method="get" action="<?= $_SERVER['REQUEST_URI'] ?>">
        <label for="constructorSelect">Constructor:</label>
        <select name="constructorRef" id="constructorSelect">
            <option value="0">Select constructor</option>
            <?php
            foreach ($constructors as $row) {
                echo "<option value='" . ($row['constructorRef']) . "'";
                if (isset($constructorRef) && $constructorRef == $row['constructorRef']) {
                    echo " selected";
                }
                echo ">" . ($row['constructorName']) . "</option>";
            }
            ?>
        </select>
        <button type="submit">View Results</button>
    </form>

    <?php
    if ($constructor) {
        echo "<h1>Constructor Details</h1>";
        echo "<p>Name: " . ($constructor['name']) . "</p>";
        echo "<p>Nationality: " . ($constructor['nationality']) . "</p>";
        echo "<a href='" . ($constructor['url']) . "' target='_blank'>Constructor Biography</a>";

        echo "<h2>Race Results - 2022 Season</h2>";
        echo "<table>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Round</th>";
        echo "<th>Circuit</th>";
        echo "<th>Driver</th>";
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
                echo "<td>" . ($result['forename']) . " " . ($result['surname']) . "</td>";
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
        echo "<p>Please select a constructor to view details and race results for the 2022 season.</p>";
    }
    ?>


</body>

</html>