<?php
namespace App\Models;

use Config\Connect;
use PDO;
use PDOException;
use Exception;

class HomeModel extends Connect
{
    public function getTotalUsuarios(): int {
        try {
            $stmt = $this->db->query("SELECT COUNT(*) FROM usuarios WHERE Estado = 1");
            return (int) $stmt->fetchColumn();
        } catch (PDOException $e) {
            throw new Exception("Error al obtener total de usuarios: " . $e->getMessage());
        }
    }

    public function getTicketsTotales(): int {
        try {
            $stmt = $this->db->query("SELECT COUNT(*) FROM tickets");
            return (int) $stmt->fetchColumn();
        } catch (PDOException $e) {
            throw new Exception("Error al obtener tickets: " . $e->getMessage());
        }
    }
}
