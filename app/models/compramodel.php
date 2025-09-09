<?php
namespace App\Models;

use Config\Connect;
use PDO;
use PDOException;
use Exception;

class ComprasModel extends Connect
{
    // Obtener todas las compras activas con proveedor
    public function getAll(): array {
        try {
            $stmt = $this->db->query("
                SELECT c.*, p.Nombre AS proveedor
                FROM compras c
                LEFT JOIN proveedores p ON p.Rif_Proveedor = c.Rif_Proveedor
                WHERE c.Estado = 1
                ORDER BY c.Id_Compra DESC
            ");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener compras: " . $e->getMessage());
        }
    }

    // Obtener compra por ID
    public function getById(int $id): ?array {
        try {
            $stmt = $this->db->prepare("SELECT * FROM compras WHERE Id_Compra = :id AND Estado = 1");
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (PDOException $e) {
            throw new Exception("Error al obtener la compra: " . $e->getMessage());
        }
    }

    // Obtener detalles de compra por Id_Compra
    public function getDetallesByCompraId(int $idCompra): array {
        try {
            $stmt = $this->db->prepare("
                SELECT dc.*, pr.Nombre AS producto_nombre, em.Nombre AS empaque_nombre, ma.Nombre AS marca_nombre
                FROM detallecompras dc
                LEFT JOIN productos pr ON pr.Codigo_Producto = dc.Codigo_Producto
                LEFT JOIN empaquetados em ON em.Id_Empaquetado = dc.Id_Empaquetado
                LEFT JOIN marcas ma ON ma.Id_Marca = dc.Id_Marca
                WHERE dc.Id_Compra = :idCompra
            ");
            $stmt->execute(['idCompra' => $idCompra]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener detalles: " . $e->getMessage());
        }
    }

    // Crear compra con detalles (transacción)
    public function create(array $data): bool {
        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare("
                INSERT INTO compras (Rif_Proveedor, Fecha, Numero_Factura, Estado)
                VALUES (:rif_proveedor, :fecha, :factura, 1)
            ");

            $stmt->execute([
                'rif_proveedor' => $data['rif_proveedor'],
                'fecha' => $data['fecha'],
                'factura' => $data['factura']
            ]);

            $idCompra = $this->db->lastInsertId();

            $stmtDetalle = $this->db->prepare("
                INSERT INTO detallecompras (Id_Compra, Codigo_Producto, Precio_Producto, Id_Empaquetado, PesoUnitario, Cantidad_Producto, Id_Marca)
                VALUES (:id_compra, :codigo_producto, :precio, :id_empaque, :peso, :cantidad, :id_marca)
            ");

            foreach ($data['detalles'] as $detalle) {
                $stmtDetalle->execute([
                    'id_compra' => $idCompra,
                    'codigo_producto' => $detalle['producto'],
                    'precio' => $detalle['precio'],
                    'id_empaque' => $detalle['empaque'],
                    'peso' => $detalle['peso'],
                    'cantidad' => $detalle['cantidad'],
                    'id_marca' => $detalle['marca'],
                ]);
            }

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            throw new Exception("Error al crear compra: " . $e->getMessage());
        }
    }

    // Actualizar compra y detalles (transacción)
    public function update(array $data): bool {
        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare("
                UPDATE compras
                SET Rif_Proveedor = :rif_proveedor, Fecha = :fecha, Numero_Factura = :factura
                WHERE Id_Compra = :id AND Estado = 1
            ");
            $stmt->execute([
                'rif_proveedor' => $data['rif_proveedor'],
                'fecha' => $data['fecha'],
                'factura' => $data['factura'],
                'id' => $data['id']
            ]);

            // Eliminar detalles actuales para esa compra
            $stmtDelete = $this->db->prepare("DELETE FROM detallecompras WHERE Id_Compra = :id_compra");
            $stmtDelete->execute(['id_compra' => $data['id']]);

            // Insertar nuevos detalles
            $stmtDetalle = $this->db->prepare("
                INSERT INTO detallecompras (Id_Compra, Codigo_Producto, Precio_Producto, Id_Empaquetado, PesoUnitario, Cantidad_Producto, Id_Marca)
                VALUES (:id_compra, :codigo_producto, :precio, :id_empaque, :peso, :cantidad, :id_marca)
            ");

            foreach ($data['detalles'] as $detalle) {
                $stmtDetalle->execute([
                    'id_compra' => $data['id'],
                    'codigo_producto' => $detalle['producto'],
                    'precio' => $detalle['precio'],
                    'id_empaque' => $detalle['empaque'],
                    'peso' => $detalle['peso'],
                    'cantidad' => $detalle['cantidad'],
                    'id_marca' => $detalle['marca'],
                ]);
            }

            $this->db->commit();
            return true;

        } catch (PDOException $e) {
            $this->db->rollBack();
            throw new Exception("Error al actualizar compra: " . $e->getMessage());
        }
    }

    // Borrado lógico compra
    public function delete(int $id): bool {
        try {
            $stmt = $this->db->prepare("UPDATE compras SET Estado = 0 WHERE Id_Compra = :id");
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            throw new Exception("Error al eliminar compra: " . $e->getMessage());
        }
    }

    // Listar proveedores
    public function getProveedores(): array {
        $stmt = $this->db->query("SELECT Rif_Proveedor, Nombre FROM proveedores WHERE Estado = 1");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Listar productos
    public function getProductos(): array {
        $stmt = $this->db->query("SELECT Codigo_Producto, Nombre FROM productos WHERE Estado = 1");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Listar empaquetados
    public function getEmpaques(): array {
        $stmt = $this->db->query("SELECT Id_Empaquetado, Nombre FROM empaquetados WHERE Estado = 1");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Listar marcas
    public function getMarcas(): array {
        $stmt = $this->db->query("SELECT Id_Marca, Nombre FROM marcas WHERE Estado = 1");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
