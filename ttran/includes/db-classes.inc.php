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

    // Fetch a specific driver by driverRef
    public function getDriverByDriverRef($driverRef)
    {
        $sql = "SELECT driverId, forename, surname, dob, nationality, url,
                (strftime('%Y', 'now') - strftime('%Y', dob)) AS 'age' 
                FROM drivers 
                WHERE driverRef = ?";

        $statement = $this->pdo->prepare($sql);
        $statement->execute([$driverRef]);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    // Fetch race results for a specific driver by driverRef and 2022
    public function getRaceResultsByDriverRef($driverRef)
    {
        $sql = "SELECT r.round, r.name AS circuit, res.position, res.points
                FROM drivers d
                INNER JOIN results res ON d.driverId = res.driverId
                INNER JOIN races r ON res.raceId = r.raceId
                WHERE d.driverRef = ? AND r.year = 2022
                ORDER BY r.round";

        $statement = $this->pdo->prepare($sql);
        $statement->execute([$driverRef]);

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

    // Fetch a specific constructor by constructorRef
    public function getConstructorByConstructorRef($constructorRef)
    {
        $sql = "SELECT name, url, nationality
                FROM constructors
                WHERE constructorRef = ?";

        $statement = $this->pdo->prepare($sql);
        $statement->execute([$constructorRef]);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    // Fetch race results for a specific constructor by constructorRef and 2022
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

        $statement = $this->pdo->prepare($sql);
        $statement->execute([$constructorRef]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
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

        $sql = "SELECT q.position, d.forename, d.surname, c.name AS constructorName, q.q1, q.q2, q.q3
                FROM qualifying q
                JOIN drivers d ON q.driverId = d.driverId
                JOIN constructors c ON q.constructorId = c.constructorId
                JOIN races r ON q.raceId = r.raceId
                WHERE r.raceId = ? AND r.year = 2022
                ORDER BY q.position";

        $statement = $this->pdo->prepare($sql);
        $statement->execute([$raceId]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
