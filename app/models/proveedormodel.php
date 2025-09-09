<?php
// Asegúrate de que NO HAYA NADA (ni siquiera un espacio en blanco) antes de esta etiqueta PHP.
namespace App\Models;

use Config\Connect; // Asegúrate de que la ruta a tu clase Connect sea correcta
use PDO;
use Exception;

class proveedormodel extends Connect
{
    public function getAll(): array {
        $stmt = $this->db->query("SELECT * FROM proveedores WHERE Estado = 1");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById(string $rif): ?array {
        $stmt = $this->db->prepare("SELECT * FROM proveedores WHERE Rif_Proveedor = :rif AND Estado = 1");
        $stmt->execute(['rif' => $rif]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ?: null;
    }

    public function create(array $data): bool {
        $stmt = $this->db->prepare("INSERT INTO proveedores (Rif_Proveedor, Nombre, Correo, Telefono, Estado)
        VALUES (:rif, :nombre, :correo, :telefono, 1)");

        return $stmt->execute([
            'rif' => $data['rif'],
            'nombre' => $data['nombre'],
            'correo' => $data['correo'],
            'telefono' => $data['telefono']
        ]);
    }

    public function update(array $data): bool {
        $stmt = $this->db->prepare("UPDATE proveedores SET Nombre = :nombre, Correo = :correo, Telefono = :telefono
        WHERE Rif_Proveedor = :rif AND Estado = 1");
        return $stmt->execute([
            'rif' => $data['rif'],
            'nombre' => $data['nombre'],
            'correo' => $data['correo'],
            'telefono' => $data['telefono']
        ]);
    }

    public function delete(string $rif): bool {
        $stmt = $this->db->prepare("UPDATE proveedores SET Estado = 0 WHERE Rif_Proveedor = :rif");
        return $stmt->execute(['rif' => $rif]);
    }
}