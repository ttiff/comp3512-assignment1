<?php

require_once '../includes/config.inc.php';
require_once '../includes/db-classes.inc.php';

try {
    $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));
    $driversGateway = new DriverDB($conn);
} catch (Exception $e) {
    die($e->getMessage());
}

if (isset($_GET['ref'])) {
    $data = $driversGateway->getDriverNamesByDriverRef($_GET['ref']);
} else if (isset($_GET['race'])) {
    $data = $driversGateway->getDriverNamesByGivenRaceId($_GET['race']);
} else {
    $data = $driversGateway->getAllDriverNames();
}

if ($data) {
    header('Content-Type: application/json');
    echo json_encode($data, JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT);
} else {
    echo json_encode(['error' => 'Driver not found']);
}
