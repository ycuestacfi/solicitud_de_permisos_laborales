<?php
// encabezado
header("ACCESS-CONTROL-ALLOW-ORIGIN: *");
class ConectService {
    private $pdo;

    public function __construct() {
        $dbhost = "localhost";
        $dbport = "3306";
        $dbuser = "root";
        $dbpassword = "";
        // $dbname = "prueba_solicitud";
        $dbname = "sdp";

        $dsn = "mysql:host=$dbhost;dbname=$dbname;dbport=$dbport;; ";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $dbuser, $dbpassword, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function getConnection() {
        return $this->pdo;
    }
}
?>
