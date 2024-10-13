<?php
class DatabaseHelper
{
    public static function createConnection($values = array())
    {
        $connString = $values[0];
        $user = $values[1];
        $password = $values[2];
        $pdo = new PDO($connString, $user, $password);
        $pdo->setAttribute(
            PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION
        );
        $pdo->setAttribute(
            PDO::ATTR_DEFAULT_FETCH_MODE,
            PDO::FETCH_ASSOC
        );
        return $pdo;
    }

    public static function runQuery($connection, $sql, $parameters)
    {
        $statement = null;

        if (isset($parameters)) {
            if (!is_array($parameters)) {
                $parameters = array($parameters);
            }
            $statement = $connection->prepare($sql);
            $executedOk = $statement->execute($parameters);
            if (!$executedOk) throw new PDOException;
        } else {
            $statement = $connection->query($sql);
            if (!$statement) throw new PDOException;
        }
        return $statement;
    }
}

class DriverDB
{
    private static $baseSQL = "SELECT DISTINCT d.driverId, d.forename, d.surname, 
                               d.dob, d.nationality, d.url, d.driverRef
                               FROM drivers d
                               INNER JOIN results res ON d.driverId = res.driverId
                               INNER JOIN races r ON res.raceId = r.raceId
                               WHERE r.year = 2022
                               ORDER BY d.surname";

    public function __construct($connection)
    {
        $this->pdo = $connection;
    }

    public function getAll()
    {
        $sql = self::$baseSQL;
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, null);
        return $statement->fetchAll();
    }

    public function getDriverByDriverRef($driverRef)
    {
        $sql = "SELECT driverId, forename, surname, dob, nationality, url,
                (strftime('%Y', 'now') - strftime('%Y', dob)) AS 'age' 
                FROM drivers 
                WHERE driverRef = ?";

        $statement = DatabaseHelper::runQuery($this->pdo, $sql, $driverRef);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function getRaceResultsByDriverRef($driverRef)
    {
        $sql = "SELECT r.round, r.name AS circuit, res.position, res.points
                FROM drivers d
                INNER JOIN results res ON d.driverId = res.driverId
                INNER JOIN races r ON res.raceId = r.raceId
                WHERE d.driverRef = ? AND r.year = 2022
                ORDER BY r.round";

        $statement = DatabaseHelper::runQuery($this->pdo, $sql, $driverRef);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllDriverNames()
    {
        $sql = "SELECT DISTINCT d.forename, d.surname 
                FROM drivers d
                INNER JOIN results res ON d.driverId = res.driverId
                INNER JOIN races r ON res.raceId = r.raceId
                WHERE r.year = 2022";

        $statement = DatabaseHelper::runQuery($this->pdo, $sql, null);
        return $statement->fetchAll();
    }

    public function getDriverNamesByDriverRef($driverRef)
    {
        $sql = "SELECT forename, surname
                FROM drivers 
                WHERE driverRef = ?";

        $statement = DatabaseHelper::runQuery($this->pdo, $sql, $driverRef);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function getDriverNamesByGivenRaceId($raceId)
    {
        $sql = "SELECT d.forename, d.surname 
                FROM drivers d
                INNER JOIN results res ON d.driverId = res.driverId
                INNER JOIN races r ON res.raceId = r.raceId
                WHERE r.raceId = ?";

        $statement = DatabaseHelper::runQuery($this->pdo, $sql, $raceId);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}

class ConstructorDB
{
    private static $baseSQL = "SELECT DISTINCT c.constructorRef, c.name AS constructorName, 
                               c.nationality, c.url
                               FROM constructors c
                               INNER JOIN results res ON c.constructorId = res.constructorId
                               INNER JOIN races r ON res.raceId = r.raceId
                               WHERE r.year = 2022
                               ORDER BY c.name";

    public function __construct($connection)
    {
        $this->pdo = $connection;
    }

    public function getAll()
    {
        $sql = self::$baseSQL;
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, null);
        return $statement->fetchAll();
    }

    public function getConstructorByConstructorRef($constructorRef)
    {
        $sql = "SELECT name, url, nationality
                FROM constructors
                WHERE constructorRef = ?";

        $statement = DatabaseHelper::runQuery($this->pdo, $sql, $constructorRef);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function getRaceResultsByConstructorRef($constructorRef)
    {
        $sql = "SELECT c.constructorId, c.url, r.round, r.name AS circuit, 
                d.forename, d.surname, res.position, res.points, d.forename, d.surname
                FROM constructors c
                INNER JOIN results res ON c.constructorId = res.constructorId
                INNER JOIN drivers d ON res.driverId = d.driverId
                INNER JOIN races r ON res.raceId = r.raceId
                WHERE c.constructorRef = ? AND r.year = 2022
                ORDER BY r.round";

        $statement = DatabaseHelper::runQuery($this->pdo, $sql, $constructorRef);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getConstructorNamesByConstructorRef($constructorRef)
    {
        $sql = "SELECT name
        FROM constructors
        WHERE constructorRef = ?";

        $statement = DatabaseHelper::runQuery($this->pdo, $sql, $constructorRef);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllConstructorNames()
    {
        $sql = "SELECT DISTINCT c.name AS constructorName
                               FROM constructors c
                               INNER JOIN results res ON c.constructorId = res.constructorId
                               INNER JOIN races r ON res.raceId = r.raceId
                               WHERE r.year = 2022";


        $statement = DatabaseHelper::runQuery($this->pdo, $sql, null);
        return $statement->fetchAll();
    }
}

class RacesDB
{
    private static $baseSQL = "SELECT raceId, round, name AS circuit
                               FROM races
                               WHERE year = 2022
                               ORDER BY round";

    public function __construct($connection)
    {
        $this->pdo = $connection;
    }

    public function getAllRacesFor2022()
    {

        $sql = self::$baseSQL;
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, null);
        return $statement->fetchAll();
    }

    public function getQualifyingResultsFor2022($raceId)
    {

        $sql = "SELECT q.position, d.forename, d.driverRef, d.surname, c.name AS constructorName, c.constructorRef, q.q1, q.q2, q.q3
                FROM qualifying q
                INNER JOIN drivers d ON q.driverId = d.driverId
                INNER JOIN constructors c ON q.constructorId = c.constructorId
                INNER JOIN races r ON q.raceId = r.raceId
                WHERE r.raceId = ? AND r.year = 2022
                ORDER BY q.position";

        $statement = DatabaseHelper::runQuery($this->pdo, $sql, $raceId);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRaceResultsFor2022($raceId)
    {
        $sql = "SELECT res.position, d.forename, d.surname, d.driverRef, 
                c.name AS constructorName, c.constructorRef, res.laps, res.points
                FROM results res
                INNER JOIN drivers d ON res.driverId = d.driverId
                INNER JOIN constructors c ON res.constructorId = c.constructorId
                INNER JOIN races r ON res.raceId = r.raceId
                WHERE r.raceId = ? AND r.year = 2022
                ORDER BY res.position";

        $statement = DatabaseHelper::runQuery($this->pdo, $sql, $raceId);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTop3Racers($raceId)
    {
        $sql = "SELECT d.forename, d.surname, d.driverRef, c.name AS constructorName, 
                res.position, res.points
                FROM results res
                INNER JOIN drivers d ON res.driverId = d.driverId
                INNER JOIN constructors c ON res.constructorId = c.constructorId
                INNER JOIN races r ON res.raceId = r.raceId
                WHERE r.raceId = ? 
                ORDER BY res.position
                LIMIT 3";

        $statement = DatabaseHelper::runQuery($this->pdo, $sql, $raceId);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRaceDetailsByRaceId($raceId)
    {
        $sql = "SELECT r.name AS raceName, r.round, c.name AS circuitName,
                c.location, c.country, r.date, r.url
                FROM races r
                INNER JOIN circuits c ON r.circuitId = c.circuitId
                WHERE r.raceId = ? AND r.year = 2022";

        $statement = DatabaseHelper::runQuery($this->pdo, $sql, $raceId);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function getRaceCircuitDetailsByRaceId($raceId)
    {
        $sql = "SELECT c.name AS circuitName, c.location, c.country
                FROM races r
                INNER JOIN circuits c ON r.circuitId = c.circuitId
                WHERE r.raceId = ?";

        $statement = DatabaseHelper::runQuery($this->pdo, $sql, $raceId);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function getRaceNamesFor2022()
    {
        $sql = "SELECT name
                FROM races
                WHERE year = 2022
                ORDER BY round";

        $statement = DatabaseHelper::runQuery($this->pdo, $sql, null);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRaceResultsByRaceId($raceId)
    {

        $sql = "SELECT d.driverRef, d.code, d.forename, d.surname,
                r.name AS raceName, r.round, r.year, r.date,
                c.name AS constructorName, c.constructorRef, c.nationality,
                res.grid, res.position
                FROM results res
                INNER JOIN drivers d ON res.driverId = d.driverId
                INNER JOIN constructors c ON res.constructorId = c.constructorId
                INNER JOIN races r ON res.raceId = r.raceId
                WHERE res.raceId = ?
                ORDER BY res.grid ASC";

        $statement = DatabaseHelper::runQuery($this->pdo, $sql, $raceId);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRaceResultsByDriverRef($driverRef)
    {
        $sql = "SELECT d.driverRef, d.forename, d.surname,
                r.name AS raceName, r.round, r.year, r.date,
                c.name AS constructorName, c.constructorRef, c.nationality,
                res.grid, res.position
                FROM results res
                INNER JOIN drivers d ON res.driverId = d.driverId
                INNER JOIN constructors c ON res.constructorId = c.constructorId
                INNER JOIN races r ON res.raceId = r.raceId
                WHERE d.driverRef = ?
                ORDER BY r.year DESC, r.round ASC";

        $statement = DatabaseHelper::runQuery($this->pdo, $sql, $driverRef);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}

class CircuitsDB
{
    private static $baseSQL = "SELECT c.name 
                               FROM circuits c
                               INNER JOIN races r ON c.circuitId = r.circuitId
                               WHERE r.year = 2022";

    public function __construct($connection)
    {
        $this->pdo = $connection;
    }

    public function getAll()
    {
        $sql = self::$baseSQL;
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, null);
        return $statement->fetchAll();
    }

    public function getCircuitByCircuitRef($circuitRef)
    {
        $sql = "SELECT c.name 
                FROM circuits c
                INNER JOIN races r ON c.circuitId = r.circuitId
                WHERE c.circuitRef = ?";

        $statement = DatabaseHelper::runQuery($this->pdo, $sql, $circuitRef);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}
class QualifyingDB
{
    public function __construct($connection)
    {
        $this->pdo = $connection;
    }

    public function getQualifyingResultsByRaceId($raceId)
    {
        $sql = "SELECT d.driverRef, d.code, d.forename, d.surname, r.name AS raceName,
                r.round, r.year, r.date, c.name as constructorName, c.constructorRef, c.nationality,
                q.position, q.q1, q.q2, q.q3
                FROM qualifying q
                INNER JOIN drivers d ON q.driverId = d.driverId
                INNER JOIN constructors c ON q.constructorId = c.constructorId
                INNER JOIN races r ON q.raceId = r.raceId
                WHERE q.raceId = ?
                ORDER BY q.position ASC";

        $statement = DatabaseHelper::runQuery($this->pdo, $sql, $raceId);
        return $statement->fetchAll();
    }
}
