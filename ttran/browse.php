<?php
require_once 'includes/config.inc.php';
require_once 'includes/db-classes.inc.php';
require_once 'includes/helper.php';

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
        $countryCode = Helper::getCountryCodeByCountry($raceDetails['country']);
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
    <meta name="description" content="COMP 3512 Browse F1 Races - 2022 Season Page">
    <meta name="keywords" content="F1, Formula 1, race results, driver performances, constructors, 2022 season">
    <meta name="author" content="Tiffany Tran">
    <title>Browse F1 Races - 2022 Season</title>
    <!-- Stylesheet sourced from Semantic UI CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css">
    <!-- Flag Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css">
    <link rel="stylesheet" href="css/style_browse.css">
</head>

<body>
    <header>
        <div class="ui dark large secondary pointing menu">
            <a class="item" href="index.php">Home</a>
            <a class="active item" href="browse.php">Browse</a>
            <a class="item" href="drivers.php">Drivers</a>
            <a class="item" href="constructors.php">Constructors</a>
            <a class="item" href="api-tester.php">APIs</a>
            <a class="item" href="https://github.com/ttiff/comp3512-assignment1">GitHub</a>
        </div>
    </header>
    <main class="ui fluid container">
        <div class="ui grid stackable">
            <div class="four wide column">
                <h1 class="ui centered header">2022 Races</h1>
                <div class="ui stackable doubling three column grid" id="race-grid">
                    <?php foreach ($races as $race): ?>
                        <div class="column">
                            <div class="ui card">
                                <div class="content">
                                    <div class="header"><?= "Round " . $race['round']; ?></div>
                                    <div class="meta"><?= $race['circuit']; ?></div>
                                </div>
                                <div class="extra content">
                                    <a class="ui tiny button fluid" href="browse.php?raceId=<?= $race['raceId']; ?>">Results</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="eleven wide column">
                <?php if (isset($_GET['raceId'])): ?>
                    <div class="ui segment">
                        <h2>Race Details</h2>
                        <?php if (!empty($raceDetails)):  ?>
                            <p><span class="label-bold">Race Name: </span><?= $raceDetails['raceName'] ?></p>
                            <p><span class="label-bold">Round: </span><?= $raceDetails['round'] ?></p>
                            <p><span class="label-bold">Circuit Name: </span><?= $raceDetails['circuitName'] ?></p>
                            <p><span class="label-bold">Location: </span><?= $raceDetails['location'] ?></p>
                            <p><span class="label-bold">Country: </span><?= $raceDetails['country'] ?> <span class="flag-icon flag-icon-<?= $countryCode; ?>"></span></p>
                            <p><span class="label-bold">Date of Race: </span><?= $raceDetails['date'] ?></p>
                            <a href='<?= $raceDetails['url'] ?>' target='_blank'>Race Information</a>
                        <?php else: ?>
                            <p>No race details available. Please select a race to view the details.</p>
                        <?php endif; ?>
                    </div>
                    <div class="ui two column grid">
                        <div class="column">
                            <h3>Qualifying Results</h3>
                            <table class="ui celled striped padded table">
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
                                            echo "<td> <a class='underline-link' href='drivers.php?driverRef=" . $result['driverRef'] . "'>" . $result['forename'] . " " . $result['surname'] . "</td>";
                                            echo "<td> <a class='underline-link' href='constructors.php?constructorRef=" . $result['constructorRef'] . "'>" . $result['constructorName'] . "</td>";
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
                        </div>
                        <div class="column">
                            <h3>Top 3 Racers</h3>
                            <table class="ui celled striped padded table">
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
                                            echo "<td> <a class='underline-link' href='drivers.php?driverRef=" . $racer['driverRef'] . "'>" . $racer['forename'] . " " . $racer['surname'] . "</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='2'>No top 3 racers available.</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <h3>Race Results</h3>
                            <table class="ui celled striped padded table">
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
                                            echo "<td> <a class='underline-link' href='drivers.php?driverRef=" . $result['driverRef'] . "'>" . $result['forename'] . " " . $result['surname'] . "</td>";
                                            echo "<td> <a class='underline-link' href='constructors.php?constructorRef=" . $result['constructorRef'] . "'>" . $result['constructorName'] . "</td>";
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
                        </div>
                    </div>
            </div>
        <?php else: ?>
            <div class="ui segment">
                <p>Please select a circuit to view details and race results for the 2022 season.</p>
            </div>
        <?php endif; ?>
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