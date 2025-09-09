<?php
namespace App\Models;

use Config\Connect;
use PDO;
use PDOException;
use Exception;

class inventariomodel extends Connect
{
    public function getAll(): array {
        try {
            $stmt = $this->db->query("
                SELECT p.*, u.UnidadMasa AS unidad, c.Nombre AS categoria
                FROM productos p
                LEFT JOIN unidadmasa u ON u.Id_Unidad = p.Id_Unidad AND u.Estado = 1
                LEFT JOIN categorias_productos c ON c.Id_Categoria = p.Id_Categoria AND c.Estado = 1
                WHERE p.Estado = 1
            ");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener productos: " . $e->getMessage());
        }
    }

    public function getById(string $codigo): ?array {
        $stmt = $this->db->prepare("SELECT * FROM productos WHERE Codigo_Producto = :codigo AND Estado = 1");
        $stmt->execute(['codigo' => $codigo]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function getUnidades(): array {
        $stmt = $this->db->query("SELECT Id_Unidad AS id, UnidadMasa FROM unidadmasa WHERE Estado = 1");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategorias(): array {
        $stmt = $this->db->query("SELECT Id_Categoria AS id, Nombre FROM categorias_productos WHERE Estado = 1");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(array $data): bool {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM productos WHERE Codigo_Producto = :codigo");
        $stmt->execute(['codigo' => $data['codigo']]);
        if ($stmt->fetchColumn() > 0) {
            throw new Exception("El producto ya existe.");
        }

        $stmt = $this->db->prepare("INSERT INTO productos (Codigo_Producto, Nombre, Id_Unidad, Id_Categoria, Estado)
                                    VALUES (:codigo, :nombre, :unidad, :categoria, 1)");
        return $stmt->execute($data);
    }

    public function update(array $data): bool {
        $stmt = $this->db->prepare("UPDATE productos SET Nombre = :nombre, Id_Unidad = :unidad, Id_Categoria = :categoria
                                    WHERE Codigo_Producto = :codigo AND Estado = 1");
        return $stmt->execute($data);
    }

    public function delete(string $codigo): bool {
        $stmt = $this->db->prepare("UPDATE productos SET Estado = 0 WHERE Codigo_Producto = :codigo");
        return $stmt->execute(['codigo' => $codigo]);
    }
}
