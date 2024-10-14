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
    <!-- Stylesheet sourced from Semantic UI CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css">
    <link rel="stylesheet" href="css/style_drivers.css">

</head>

<body>
    <header>
        <div class="ui dark large secondary pointing menu">
            <a class="item" href="index.php">Home</a>
            <a class="item" href="browse.php">Browse</a>
            <a class="active item" href="drivers.php">Drivers</a>
            <a class="item" href="constructors.php">Constructors</a>
            <a class="item" href="api-tester.php">APIs</a>
            <a class="item" href="https://github.com/ttiff/comp3512-assignment1">GitHub</a>
        </div>
    </header>

    <main class="ui container">
        <div class="ui grid">
            <div class="four wide column">
                <form method="get" action="<?= $_SERVER['REQUEST_URI'] ?>">
                    <label for="driverSelect" class="label">Select Driver</label>
                    <select class="ui fluid dropdown" name="driverRef" id="driverSelect">
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
                    <button class="medium ui button" type="submit"> <i class="eye icon"></i>View Results</button>
                </form>
            </div>
            <div class="twelve wide column">
                <div class="ui segment">
                    <?php if ($driver): ?>
                        <h1>Driver Details</h1>
                        <p>Name: <?= ($driver['forename'] . " " . $driver['surname']); ?></p>
                        <p>Date of Birth: <?= ($driver['dob']); ?></p>
                        <p>Age: <?= ($driver['age']); ?></p>
                        <p>Nationality: <?= ($driver['nationality']); ?></p>
                        <a href="<?= ($driver['url']); ?>" target="_blank">Driver Biography</a>
                </div>
                <h2>Race Results - 2022 Season</h2>
                <table class="ui celled table">
                    <thead>
                        <tr>
                            <th>Round</th>
                            <th>Circuit</th>
                            <th>Position</th>
                            <th>Points</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($raceResults): ?>
                            <?php foreach ($raceResults as $result): ?>
                                <tr>
                                    <td><?= ($result['round']); ?></td>
                                    <td><?= ($result['circuit']); ?></td>
                                    <td><?= ($result['position']); ?></td>
                                    <td><?= ($result['points']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4">No results available for the 2022 season.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="message">Please select a driver to view details and race results for the 2022 season.</p>
            <?php endif; ?>

            </div>
        </div>
    </main>
    <footer class="ui inverted vertical footer segment">
        <div class="ui container">
            <div class="ui section divider"></div>
            <div class="ui center aligned container">
                <p>&copy; MRU COMP 3512 Assignment #1 by Tiffany Tran. Built using HTML, CSS, PHP, MySQL, and Semantic UI.</p>
            </div>
        </div>
    </footer>


</body>

</html>