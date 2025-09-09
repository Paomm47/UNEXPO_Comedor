<?php
namespace App\Models;

use Config\Connect;
use PDO;
use PDOException;
use Exception;

class usuariomodel extends Connect
{
    // Validar que los datos mínimos existen antes de insertar o actualizar
    private function validarDatos(array $data): void {
        if (empty($data['codigo']) || empty($data['nombre']) || empty($data['tipo'])) {
            throw new Exception("Faltan datos obligatorios para procesar el usuario.");
        }
    }

    public function getAll(): array {
        try {
            $stmt = $this->db->query("
                SELECT u.*, 
                       t.Nombre AS tipo
                FROM usuarios u
                LEFT JOIN tiposusuarios t ON t.Codigo_TipoUsuario = u.Codigo_TipoUsuario
                WHERE u.Estado = 1
                ORDER BY u.Nombre ASC
            ");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener usuarios: " . $e->getMessage());
        }
    }

    public function getById(string $id): ?array {
        try {
            $id = htmlspecialchars($id); // Sanitizar cédula
            $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE Cedula_Usuario = :id AND Estado = 1");
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (PDOException $e) {
            throw new Exception("Error al obtener el usuario: " . $e->getMessage());
        }
    }

    public function getTiposUsuarios(): array {
        try {
            $stmt = $this->db->query("SELECT Codigo_TipoUsuario AS id, Nombre FROM tiposusuarios WHERE Estado = 1");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener tipos de usuarios: " . $e->getMessage());
        }
    }

    public function create(array $data): bool {
        try {
            $this->validarDatos($data);

            $stmt = $this->db->prepare("SELECT COUNT(*) FROM usuarios WHERE Cedula_Usuario = :codigo");
            $stmt->execute(['codigo' => $data['codigo']]);

            if ($stmt->fetchColumn() > 0) {
                throw new Exception("La cédula ya está registrada.");
            }

            $stmt = $this->db->prepare("
                INSERT INTO usuarios (Cedula_Usuario, Nombre, Contrasena, Codigo_TipoUsuario, Estado)
                VALUES (:codigo, :nombre, :clave, :tipo, 1)
            ");

            return $stmt->execute([
                'codigo' => $data['codigo'],
                'nombre' => $data['nombre'],
                'clave'  => $data['contrasena'], // sin hash
                'tipo'   => $data['tipo']
            ]);
        } catch (PDOException $e) {
            throw new Exception("Error al crear el usuario: " . $e->getMessage());
        }
    }

    public function update(array $data): bool {
        try {
            $this->validarDatos($data);

            $sql = "
                UPDATE usuarios
                SET Nombre = :nombre, Codigo_TipoUsuario = :tipo
            ";
            $params = [
                'nombre' => $data['nombre'],
                'tipo'   => $data['tipo'],
                'codigo' => $data['codigo']
            ];

            if (!empty($data['contrasena'])) {
                $sql .= ", Contrasena = :clave";
                $params['clave'] = $data['contrasena']; // sin hash
            }

            $sql .= " WHERE Cedula_Usuario = :codigo AND Estado = 1";

            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);

            if ($stmt->rowCount() === 0) {
                throw new Exception("No se encontró el usuario o no se modificó ningún dato.");
            }

            return true;
        } catch (PDOException $e) {
            throw new Exception("Error al actualizar el usuario: " . $e->getMessage());
        }
    }

    public function delete(string $id): bool {
        try {
            $id = htmlspecialchars($id); // Sanitizar por seguridad
            $stmt = $this->db->prepare("UPDATE usuarios SET Estado = 0 WHERE Cedula_Usuario = :id");
            $stmt->execute(['id' => $id]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            throw new Exception("Error al eliminar el usuario: " . $e->getMessage());
        }
    }
}
