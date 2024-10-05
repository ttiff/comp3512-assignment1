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
    private static $baseSQL = "SELECT d.driverId, d.forename, d.surname, d.dob, d.nationality, d.url, d.driverRef, 
                               (strftime('%Y', 'now') - strftime('%Y', d.dob)) AS 'Age', 
                               r.round, r.name AS circuit, res.position, res.points
                               FROM drivers d
                               INNER JOIN results res ON d.driverId = res.driverId
                               INNER JOIN races r ON res.raceId = r.raceId
                               WHERE r.year = 2022
                               ORDER BY d.driverId";



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
}
