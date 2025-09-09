<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\usuariomodel;

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header('Location: /unexpo_comedor_v5');
    exit;
}

// Crear instancia del modelo
$model = new usuariomodel();
$action = $_GET['action'] ?? 'index';

try {
    switch ($action) {
        // Página principal del módulo
        case 'index':
            $usuarios = $model->getAll();
            $tipos = $model->getTiposUsuarios();
            require 'app/views/layout/header.php';
            require 'app/views/layout/sidebar.php';
            require 'app/views/usuarios/usuariosview.php';
            require 'app/views/layout/footer.php';
            break;

        // Crear usuario (POST vía fetch)
        case 'create':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                header('Content-Type: application/json; charset=utf-8');
                $data = [
                    'codigo'     => trim($_POST['codigo'] ?? ''),
                    'nombre'     => trim($_POST['nombre'] ?? ''),
                    'contrasena' => $_POST['contrasena'] ?? '',
                    'tipo'       => $_POST['tipo'] ?? ''
                ];

                try {
                    $success = $model->create($data);
                    echo json_encode(['success' => $success, 'message' => 'Usuario creado exitosamente']);
                } catch (Exception $e) {
                    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
                }
                exit;
            }
            break;

        // Editar usuario (GET para mostrar vista, POST para guardar)
        case 'edit':
            $id = $_GET['id'] ?? null;

            if (!$id) {
                echo "ID inválido";
                exit;
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                header('Content-Type: application/json; charset=utf-8');
                $data = [
                    'codigo'     => trim($_POST['codigo'] ?? ''),
                    'nombre'     => trim($_POST['nombre'] ?? ''),
                    'contrasena' => $_POST['contrasena'] ?? '',
                    'tipo'       => $_POST['tipo'] ?? ''
                ];

                try {
                    $success = $model->update($data);
                    echo json_encode(['success' => $success, 'message' => 'Usuario actualizado correctamente']);
                } catch (Exception $e) {
                    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
                }
                exit;
            } else {
                $usuario = $model->getById($id);
                if (!$usuario) {
                    echo "Usuario no encontrado.";
                    exit;
                }
                $tipos = $model->getTiposUsuarios();
                require __DIR__ . '/../views/usuarios/usuarioedit.php';
            }
            break;

        // Eliminar usuario (soft delete)
        case 'delete':
            header('Content-Type: application/json; charset=utf-8');
            $id = $_GET['id'] ?? null;

            if (!$id) {
                echo json_encode(['success' => false, 'message' => 'ID inválido']);
                exit;
            }

            try {
                $success = $model->delete($id);
                echo json_encode(['success' => $success, 'message' => 'Usuario eliminado correctamente']);
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
            exit;

        default:
            echo "Acción no válida";
            exit;
    }
} catch (Exception $e) {
    http_response_code(500);
    echo "Error inesperado: " . $e->getMessage();
    exit;
}
