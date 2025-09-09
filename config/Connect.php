<?php

namespace Config;

use PDO;
use PDOException;

class Connect
{
    private string $host = 'localhost';
    private string $dbname = 'comedor_db';
    private string $username = 'root';
    private string $password = '';
    private string $charset = 'utf8mb4';

    protected PDO $db;

    public function __construct()
    {
        $this->db = $this->connect();
    }

    private function connect(): PDO
    {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            return new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $e) {
            // Lanzar excepción para manejarla fuera de la clase
            throw new PDOException("Error de conexión a la base de datos: " . $e->getMessage());
        }
    }

    public function getConnection(): PDO
    {
        return $this->db;
    }
}
