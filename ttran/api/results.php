<?php

require_once '../includes/config.inc.php';
require_once '../includes/db-classes.inc.php';

try {
    $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));
    $racesGateway = new RacesDB($conn);
} catch (Exception $e) {
    die($e->getMessage());
}

if (isset($_GET['ref'])) {
    $data = $racesGateway->getRaceResultsByRaceId($_GET['ref']);
} else if (isset($_GET['driver'])) {
    $data = $racesGateway->getRaceResultsByDriverRef($_GET['driver']);
}

if ($data) {
    header('Content-Type: application/json');
    echo json_encode($data, JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT);
} else {
    echo json_encode(['error' => 'Race results not found']);
}
