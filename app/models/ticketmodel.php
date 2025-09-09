<?php
namespace App\Models;

use Config\Connect;
use PDO;
use PDOException;
use Exception;

class ticketmodel extends Connect
{
    public function getAll(): array {
        try {
            // Traemos tickets junto a info de tipo comensal y menú (si tienes tablas tipocomensal y menu)
            $stmt = $this->db->query("
                SELECT t.Id_Ticket, t.Codigo_Tipocomensal, tc.Nombre AS tipo_comensal, 
                       t.Id_Menu, m.Nombre AS menu
                FROM tickets t
                LEFT JOIN tipocomensal tc ON tc.id = t.Codigo_Tipocomensal
                LEFT JOIN menu m ON m.Id_Menu = t.Id_Menu
                ORDER BY t.Id_Ticket DESC
            ");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener tickets: " . $e->getMessage());
        }
    }

    public function getById(int $id): ?array {
        try {
            $stmt = $this->db->prepare("SELECT * FROM tickets WHERE Id_Ticket = :id");
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (PDOException $e) {
            throw new Exception("Error al obtener el ticket: " . $e->getMessage());
        }
    }

    public function getTiposComensal(): array {
        try {
            $stmt = $this->db->query("SELECT id, Nombre FROM tipocomensal WHERE Estado = 1 ORDER BY Nombre");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener tipos de comensal: " . $e->getMessage());
        }
    }

    public function getMenus(): array {
        try {
            $stmt = $this->db->query("SELECT Id_Menu, Nombre FROM menu WHERE Estado = 1 ORDER BY Nombre");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener menús: " . $e->getMessage());
        }
    }

    public function create(array $data): bool {
        try {
            // No hay id autoincrement en la tabla, por lo que obtenemos max+1
            $stmt = $this->db->query("SELECT MAX(Id_Ticket) FROM tickets");
            $maxId = $stmt->fetchColumn();
            $nextId = $maxId ? $maxId + 1 : 1;

            $stmt = $this->db->prepare("
                INSERT INTO tickets (Id_Ticket, Codigo_Tipocomensal, Id_Menu)
                VALUES (:id, :tipocomensal, :menu)
            ");

            return $stmt->execute([
                'id' => $nextId,
                'tipocomensal' => $data['tipocomensal'],
                'menu' => $data['menu']
            ]);
        } catch (PDOException $e) {
            throw new Exception("Error al crear ticket: " . $e->getMessage());
        }
    }

    public function update(array $data): bool {
        try {
            $stmt = $this->db->prepare("
                UPDATE tickets SET
                    Codigo_Tipocomensal = :tipocomensal,
                    Id_Menu = :menu
                WHERE Id_Ticket = :id
            ");

            return $stmt->execute([
                'tipocomensal' => $data['tipocomensal'],
                'menu' => $data['menu'],
                'id' => $data['id']
            ]);
        } catch (PDOException $e) {
            throw new Exception("Error al actualizar ticket: " . $e->getMessage());
        }
    }

    public function delete(int $id): bool {
        try {
            // Aquí borramos físicamente porque no hay campo Estado
            $stmt = $this->db->prepare("DELETE FROM tickets WHERE Id_Ticket = :id");
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            throw new Exception("Error al eliminar ticket: " . $e->getMessage());
        }
    }
}
