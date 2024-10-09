<?php
require_once 'includes/config.inc.php';
require_once 'includes/db-classes.inc.php';

try {
    $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));

    $racesGateway = new RacesDB($conn);

    $races = $racesGateway->getAllRacesFor2022();

    if (isset($_GET['raceId'])) {
        $raceId = $_GET['raceId'];
        $qualifyingResults = $racesGateway->getQualifyingResultsFor2022($raceId);
        $raceResults = $racesGateway->getRaceResultsFor2022($raceId);
        $top3Racers = $racesGateway->getTop3Racers($raceId);
        $raceDetails = $racesGateway->getRaceDetailsByRaceId($raceId);
    }
} catch (Exception $e) {
    die($e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse F1 Races - 2022 Season</title>
</head>

<body>

    <h3>2022 Races</h3>
    <ul>
        <?php
        foreach ($races as $race) {
            echo "<li>";
            echo "Round " . $race['round'] . " - " . $race['circuit'];
            echo " <a href='browse.php?raceId=" . $race['raceId'] . "'>Results</a>";
            echo "</li>";
        }
        ?>
    </ul>

    <?php if (isset($_GET['raceId'])): ?>
        <h3>Race Details</h3>
        <?php if (!empty($raceDetails)): ?>
            <p>Race Name: <?= $raceDetails['raceName'] ?></p>
            <p>Round: <?= $raceDetails['round'] ?></p>
            <p>Circuit Name: <?= $raceDetails['circuitName'] ?></p>
            <p>Location: <?= $raceDetails['location'] ?></p>
            <p>Country: <?= $raceDetails['country'] ?></p>
            <p>Date of Race: <?= $raceDetails['date'] ?></p>
            <a href='<?= $raceDetails['url'] ?>' target='_blank'>Race Information</a>
        <?php else: ?>
            <p>No race details available. Please select a race to view the details.</p>
        <?php endif; ?>

        <h3>Qualifying Results</h3>
        <table>
            <thead>
                <tr>
                    <th>Position</th>
                    <th>Driver</th>
                    <th>Constructor</th>
                    <th>Q1</th>
                    <th>Q2</th>
                    <th>Q3</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($qualifyingResults)) {
                    foreach ($qualifyingResults as $result) {
                        echo "<tr>";
                        echo "<td>" . $result['position'] . "</td>";
                        echo "<td>" . $result['forename'] . " " . $result['surname'] . "</td>";
                        echo "<td>" . $result['constructorName'] . "</td>";
                        echo "<td>" . $result['q1'] . "</td>";
                        echo "<td>" . $result['q2'] . "</td>";
                        echo "<td>" . $result['q3'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No qualifying results available.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <h3>Top 3 Racers</h3>
        <table>
            <thead>
                <tr>
                    <th>Position</th>
                    <th>Driver</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($top3Racers)) {
                    foreach ($top3Racers as $racer) {
                        echo "<tr>";
                        echo "<td>" . $racer['position'] . "</td>";
                        echo "<td>" . $racer['forename'] . " " . $racer['surname'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>No top 3 racers available.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <h3>Race Results</h3>
        <table>
            <thead>
                <tr>
                    <th>Position</th>
                    <th>Driver</th>
                    <th>Constructor</th>
                    <th>Laps</th>
                    <th>Points</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($raceResults)) {
                    foreach ($raceResults as $result) {
                        echo "<tr>";
                        echo "<td>" . $result['position'] . "</td>";
                        echo "<td>" . $result['forename'] . " " . $result['surname'] . "</td>";
                        echo "<td>" . $result['constructorName'] . "</td>";
                        echo "<td>" . $result['laps'] . "</td>";
                        echo "<td>" . $result['points'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No race results available.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    <?php endif; ?>

</body>

</html>