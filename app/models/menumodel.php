<?php
namespace App\Models;

use Config\Connect;
use PDO;
use PDOException;
use Exception;

class menumodel extends Connect
{
    public function getAll(): array {
        $sql = "SELECT m.*, r.Nombre AS receta FROM menus m
                LEFT JOIN recetas r ON r.Id_Receta = m.Id_Receta
                ORDER BY m.Fecha DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM menus WHERE Id_Menu = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function getRecetas(): array {
        return $this->db->query("SELECT Id_Receta, Nombre FROM recetas")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(array $data): bool {
        $stmt = $this->db->prepare("
            INSERT INTO menus (Nombre, Id_Receta, Fecha)
            VALUES (:nombre, :receta, :fecha)
        ");
        return $stmt->execute([
            'nombre' => $data['nombre'],
            'receta' => $data['receta'],
            'fecha' => $data['fecha']
        ]);
    }

    public function update(array $data): bool {
        $stmt = $this->db->prepare("
            UPDATE menus SET Nombre = :nombre, Id_Receta = :receta, Fecha = :fecha
            WHERE Id_Menu = :id
        ");
        return $stmt->execute([
            'nombre' => $data['nombre'],
            'receta' => $data['receta'],
            'fecha'  => $data['fecha'],
            'id'     => $data['id']
        ]);
    }

    public function delete(int $id): bool {
        return $this->db->prepare("DELETE FROM menus WHERE Id_Menu = :id")->execute(['id' => $id]);
    }
}
