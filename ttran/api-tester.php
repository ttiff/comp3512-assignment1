<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Tester</title>
    <!-- Stylesheet sourced from Semantic UI CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css">
    <link rel="stylesheet" href="css/api-tester-style.css">
</head>

<body>
    <header>
        <div class="ui dark large secondary pointing menu">
            <a class="item" href="index.php">Home</a>
            <a class="item" href="browse.php">Browse</a>
            <a class="item" href="drivers.php">Drivers</a>
            <a class="item" href="constructors.php">Constructors</a>
            <a class="active item" href="api-tester.php">APIs</a>
            <a class="item" href="https://github.com/ttiff/comp3512-assignment1">GitHub</a>
        </div>
    </header>

    <main class="background-section">
        <div class="ui container centered-header">
            <table class="ui celled striped table">
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
                        <td><a href="/comp3512-assignment1/ttran/api/circuits.php?ref=monaco" target="_blank">/api/circuits.php?ref=monaco</a></td>
                        <td>Returns just the specified circuit (Monaco)</td>
                    </tr>
                    <tr>
                        <td><a href="/comp3512-assignment1/ttran/api/drivers.php" target="_blank">/api/drivers.php</a></td>
                        <td>Returns all the drivers for the season</td>
                    </tr>
                    <tr>
                        <td><a href="/comp3512-assignment1/ttran/api/drivers.php?ref=hamilton" target="_blank">/api/drivers.php?ref=hamilton</a></td>
                        <td>Returns just the specified driver (Hamilton)</td>
                    </tr>
                    <tr>
                        <td><a href="/comp3512-assignment1/ttran/api/drivers.php?race=1106" target="_blank">/api/drivers.php?race=1106</a></td>
                        <td>Returns the drivers within a given race (1106)</td>
                    </tr>
                    <tr>
                        <td><a href="/comp3512-assignment1/ttran/api/races.php?ref=1106" target="_blank">/api/races.php?ref=1106</a></td>
                        <td>Returns the specified race details (1106)</td>
                    </tr>
                    <tr>
                        <td><a href="/comp3512-assignment1/ttran/api/races.php" target="_blank">/api/races.php</a></td>
                        <td>Returns the races within the 2022 season ordered by round</td>
                    </tr>
                    <tr>
                        <td><a href="/comp3512-assignment1/ttran/api/qualifying.php?ref=1106" target="_blank">/api/qualifying.php?ref=1106</a></td>
                        <td>Returns the qualifying results for the specified race (1106)</td>
                    </tr>
                    <tr>
                        <td><a href="/comp3512-assignment1/ttran/api/results.php?ref=1106" target="_blank">/api/results.php?ref=1106</a></td>
                        <td>Returns the qualifying results for the specified race (1106)</td>
                    </tr>
                    <tr>
                        <td><a href="/comp3512-assignment1/ttran/api/results.php?driver=max_verstappen" target="_blank">/api/results.php?driver=max_verstappen</a></td>
                        <td>Returns all the results for a given driver (max_verstappen)</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

</body>

</html>