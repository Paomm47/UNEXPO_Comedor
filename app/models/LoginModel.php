<?php
namespace App\Models;

use Config\Connect;
use PDO;
use PDOException;

class LoginModel extends Connect
{
    public function verificarCredenciales(string $cedula, string $password): ?array
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE Cedula_Usuario = :cedula AND Estado = 1 LIMIT 1");
            $stmt->bindParam(':cedula', $cedula, PDO::PARAM_STR);
            $stmt->execute();

            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$usuario) {
                return null;
            }

            // Comparar contraseña en texto plano
            if ($password === $usuario['Contrasena']) {
                unset($usuario['Contrasena']);
                return $usuario;
            }

            return null;
        } catch (PDOException $e) {
            error_log("Login error: " . $e->getMessage());
            return null;
        }
    }
}
