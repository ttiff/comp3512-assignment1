<?php

require_once '../includes/config.inc.php';
require_once '../includes/db-classes.inc.php';

try {
    $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));
    $circuitsGateway = new CircuitsDB($conn);
} catch (Exception $e) {
    die($e->getMessage());
}

if (isset($_GET['circuitRef'])) {
    $data = $circuitsGateway->getCircuitByCircuitRef($_GET['circuitRef']);
} else {
    $data = $circuitsGateway->getAll();
}

if ($data) {
    header('Content-Type: application/json');
    echo json_encode($data, JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT);
} else {
    echo json_encode(['error' => 'Circuit not found']);
}
