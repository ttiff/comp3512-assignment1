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

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>F1 Driver Details and Race Results</title>

</head>

<body>



</body>

</html>