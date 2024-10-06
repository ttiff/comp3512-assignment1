<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Tester</title>
</head>

<body>

    <h1>F1 Dashboard Project - API Tester</h1>

    <table>
        <thead>
            <tr>
                <th>URL</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><a href="/comp3512-assignment1/ttran/api/circuits.php" target="_blank">/api/circuits.php</a></td>
                <td>Returns all the circuits for the season</td>
            </tr>
            <tr>
                <td><a href="/comp3512-assignment1/ttran/api/circuits.php?circuitRef=monaco" target="_blank">/api/circuits.php?circuitRef=monaco</a></td>
                <td>Returns just the specified circuit (Monaco)</td>
            </tr>

            <tr>
                <td><a href="/comp3512-assignment1/ttran/api/drivers.php" target="_blank">/api/drivers.php</a></td>
                <td>Returns all the drivers for the season</td>
            </tr>
            <tr>
                <td><a href="/comp3512-assignment1/ttran/api/drivers.php?driverRef=hamilton" target="_blank">/api/drivers.php?driverRef=hamilton</a></td>
                <td>Returns just the specified driver (Hamilton)</td>
            </tr>

            <tr>
                <td><a href="/comp3512-assignment1/ttran/api/drivers.php?raceId=1106" target="_blank">/api/drivers.php?raceId=1106</a></td>
                <td>Returns the drivers within a given race (1106)</td>
            </tr>
        </tbody>
    </table>

</body>

</html>