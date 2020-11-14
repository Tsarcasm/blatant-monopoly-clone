<?php
class Database
{
    private static $db;
    private $pdo;

    private function __construct()
    {
        $host = 'localhost';
        $db = 'moonitoring';
        $user = 'root';
        $pass = 'successreal';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        try {
            $pdo = new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }
        $this->pdo = $pdo;

    }

    public function __destruct()
    {
        // $this->pdo->close();
    }

    public static function getConnection()
    {
        if (self::$db == null) {
            self::$db = new Database();
        }
        return self::$db->pdo;
    }
}
