<?php
namespace App\Models;

use Config\Connect;
use PDO;
use PDOException;
use Exception;

class recetamodel extends Connect
{
    // Obtener todas las recetas con sus ingredientes (en formato simplificado)
    public function getAll(): array {
        try {
            // Recetas con todos sus ingredientes (agrupados)
            $stmt = $this->db->query("
                SELECT r.Id_Receta, r.Nombre, 
                    GROUP_CONCAT(CONCAT(p.Nombre, ' (', i.PesoDetallado_Producto, ' ', u.UnidadMasa, ')') SEPARATOR ', ') AS ingredientes
                FROM recetas r
                LEFT JOIN ingredientes i ON i.Id_Receta = r.Id_Receta
                LEFT JOIN productos p ON p.Codigo_Producto = i.Codigo_Producto
                LEFT JOIN unidadmasa u ON u.Id_Unidad = i.UnidadMasa
                GROUP BY r.Id_Receta
                ORDER BY r.Id_Receta DESC
            ");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener recetas: " . $e->getMessage());
        }
    }

    // Obtener receta básica
    public function getById(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM recetas WHERE Id_Receta = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    // Obtener ingredientes de una receta
    public function getIngredientes(int $idReceta): array {
        $stmt = $this->db->prepare("
            SELECT i.Id_Ingredientes, i.Codigo_Producto, p.Nombre AS producto, i.PesoDetallado_Producto, i.UnidadMasa
            FROM ingredientes i
            INNER JOIN productos p ON p.Codigo_Producto = i.Codigo_Producto
            WHERE i.Id_Receta = :idReceta
        ");
        $stmt->execute(['idReceta' => $idReceta]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener productos activos para seleccionar
    public function getProductos(): array {
        $stmt = $this->db->query("SELECT Codigo_Producto AS id, Nombre FROM productos WHERE Estado = 1");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener unidades de masa activas
    public function getUnidades(): array {
        $stmt = $this->db->query("SELECT Id_Unidad AS id, UnidadMasa FROM unidadmasa WHERE Estado = 1");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Crear receta con múltiples ingredientes
    public function create(array $data): bool {
        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare("INSERT INTO recetas (Nombre) VALUES (:nombre)");
            $stmt->execute(['nombre' => $data['nombre']]);
            $idReceta = $this->db->lastInsertId();

            $stmtIng = $this->db->prepare("
                INSERT INTO ingredientes (Id_Receta, Codigo_Producto, PesoDetallado_Producto, UnidadMasa)
                VALUES (:idReceta, :codigoProducto, :peso, :unidad)
            ");

            foreach ($data['ingredientes'] as $ing) {
                $stmtIng->execute([
                    'idReceta' => $idReceta,
                    'codigoProducto' => $ing['producto'],
                    'peso' => $ing['peso'],
                    'unidad' => $ing['unidad']
                ]);
            }

            $this->db->commit();
            return true;

        } catch (PDOException $e) {
            $this->db->rollBack();
            throw new Exception("Error al crear receta: " . $e->getMessage());
        }
    }

    // Actualizar receta y sus ingredientes
    public function update(array $data): bool {
        try {
            $this->db->beginTransaction();

            // Actualizar nombre receta
            $stmt = $this->db->prepare("UPDATE recetas SET Nombre = :nombre WHERE Id_Receta = :id");
            $stmt->execute(['nombre' => $data['nombre'], 'id' => $data['id']]);

            // Borrar ingredientes viejos
            $stmtDel = $this->db->prepare("DELETE FROM ingredientes WHERE Id_Receta = :idReceta");
            $stmtDel->execute(['idReceta' => $data['id']]);

            // Insertar nuevos ingredientes
            $stmtIng = $this->db->prepare("
                INSERT INTO ingredientes (Id_Receta, Codigo_Producto, PesoDetallado_Producto, UnidadMasa)
                VALUES (:idReceta, :codigoProducto, :peso, :unidad)
            ");
            foreach ($data['ingredientes'] as $ing) {
                $stmtIng->execute([
                    'idReceta' => $data['id'],
                    'codigoProducto' => $ing['producto'],
                    'peso' => $ing['peso'],
                    'unidad' => $ing['unidad']
                ]);
            }

            $this->db->commit();
            return true;

        } catch (PDOException $e) {
            $this->db->rollBack();
            throw new Exception("Error al actualizar receta: " . $e->getMessage());
        }
    }

    // Eliminar receta (y sus ingredientes por ON DELETE CASCADE o manualmente)
    public function delete(int $id): bool {
        try {
            // Si no hay FK con cascade, eliminar ingredientes manualmente primero
            $stmtIng = $this->db->prepare("DELETE FROM ingredientes WHERE Id_Receta = :idReceta");
            $stmtIng->execute(['idReceta' => $id]);

            $stmt = $this->db->prepare("DELETE FROM recetas WHERE Id_Receta = :id");
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            throw new Exception("Error al eliminar receta: " . $e->getMessage());
        }
    }
}
