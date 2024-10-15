<?php

require_once 'includes/config.inc.php';
require_once 'includes/db-classes.inc.php';
require_once 'includes/helper.php';

try {
    $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));

    $constructorGateway = new ConstructorDB($conn);

    $constructors = $constructorGateway->getAll();
} catch (Exception $e) {
    die($e->getMessage());
}

if (isset($_GET['constructorRef'])) {
    $constructorRef = $_GET['constructorRef'];

    $constructor = $constructorGateway->getConstructorByConstructorRef($constructorRef);
    $countryCode = Helper::getCountryCodeByNationality($constructor['nationality']);

    if ($constructor) {
        $raceResults = $constructorGateway->getRaceResultsByConstructorRef($constructorRef);
    } else {
        die("Constructor not found.");
    }
} else {
    $constructor = null;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>F1 Constructor Details and Race Results</title>
    <!-- Stylesheet sourced from Semantic UI CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css">
    <!-- Flag Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css">
    <link rel="stylesheet" href="css/style_constructors.css">

</head>

<body>
    <header>
        <div class="ui dark large secondary pointing menu">
            <a class="item" href="index.php">Home</a>
            <a class="item" href="browse.php">Browse</a>
            <a class="item" href="drivers.php">Drivers</a>
            <a class="active item" href="constructors.php">Constructors</a>
            <a class="item" href="api-tester.php">APIs</a>
            <a class="item" href="https://github.com/ttiff/comp3512-assignment1">GitHub</a>
        </div>
    </header>
    <main class="ui container">
        <div class="ui grid">
            <div class="four wide column">
                <form method="get" action="<?= $_SERVER['REQUEST_URI'] ?>">
                    <label for="constructorSelect" class="label">Select a Constructor</label>
                    <select class="ui fluid dropdown" name="constructorRef" id="constructorSelect">
                        <option value="0">Select Constructor</option>
                        <?php
                        foreach ($constructors as $row) {
                            echo "<option value='" . ($row['constructorRef']) . "'";
                            if (isset($constructorRef) && $constructorRef == $row['constructorRef']) {
                                echo " selected";
                            }
                            echo ">" . ($row['constructorName']) . "</option>";
                        }
                        ?>
                    </select>
                    <button class="medium ui button" type="submit"> <i class="eye icon"></i>View Results</button>
                </form>
            </div>
            <div class="twelve wide column">
                <div class="ui segment">
                    <?php if ($constructor): ?>
                        <h1>Constructor Details</h1>
                        <p><span class="label-bold">Name: </span><?= ($constructor['name']) ?> </p>
                        <p><span class="label-bold">Nationality: </span>
                            <?= ($constructor['nationality']) ?> <span class="flag-icon flag-icon-<?= $countryCode; ?>"></span>
                        </p>
                        <a href=" <?= ($constructor['url']); ?>" target="_blank">Constructor Biography</a>
                </div>
                <h2>Race Results - 2022 Season</h2>
                <table class="ui celled striped padded table">
                    <thead>
                        <tr>
                            <th>Round</th>
                            <th>Circuit</th>
                            <th>Driver</th>
                            <th>Position</th>
                            <th>Points</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($raceResults): ?>
                            <?php foreach ($raceResults as $result): ?>
                                <tr>
                                    <td><?= ($result['round']) ?></td>
                                    <td><?= ($result['circuit']) ?></td>
                                    <td><?= $result['forename'] . " " . $result['surname'] ?></td>
                                    <td> <?= ($result['position']) ?></td>
                                    <td><?= ($result['points']) ?> </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4">No results available for the 2022 season.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="message">Please select a constructor to view details and race results for the 2022 season.</p>
            <?php endif; ?>
            </div>
        </div>
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