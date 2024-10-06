<?php

require_once 'includes/config.inc.php';
require_once 'includes/db-classes.inc.php';

try {
    $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));

    $racesGateway = new RacesDB($conn);

    $races = $racesGateway->getAllRacesFor2022();
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

</body>

</html>