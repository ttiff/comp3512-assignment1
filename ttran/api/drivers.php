<?php

require_once '../includes/config.inc.php';
require_once '../includes/db-classes.inc.php';

try {
    $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));
    $driversGateway = new DriverDB($conn);
} catch (Exception $e) {
    die($e->getMessage());
}

if (isset($_GET['driverRef'])) {
    $data = $driversGateway->getDriverNamesByDriverRef($_GET['driverRef']);
} else if (isset($_GET['raceId'])) {
    $data = $driversGateway->getDriverNamesByGivenRaceId($_GET['raceId']);
} else {
    $data = $driversGateway->getAllDriverNames();
}

if ($data) {
    header('Content-Type: application/json');
    echo json_encode($data, JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT);
} else {
    echo json_encode(['error' => 'Driver not found']);
}
