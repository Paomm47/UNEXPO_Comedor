<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\menumodel;

// Verificar sesión
if (!isset($_SESSION['usuario'])) {
    header('Location: /unexpo_comedor_v5');
    exit;
}

$model = new menumodel();
$action = $_GET['action'] ?? 'index';

try {
    switch ($action) {
        case 'index':
            $menus = $model->getAll();
            $recetas = $model->getRecetas();
            require 'app/views/layout/header.php';
            require 'app/views/layout/sidebar.php';
            require 'app/views/menus/menuview.php';
            require 'app/views/layout/footer.php';
            break;

        case 'create':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                header('Content-Type: application/json; charset=utf-8');

                $data = [
                    'nombre' => $_POST['nombre'] ?? '',
                    'receta' => $_POST['receta'] ?? '',
                    'fecha'  => $_POST['fecha'] ?? ''
                ];

                try {
                    $success = $model->create($data);
                    echo json_encode([
                        'success' => $success,
                        'message' => 'Menú creado correctamente'
                    ]);
                } catch (Exception $e) {
                    echo json_encode([
                        'success' => false,
                        'message' => $e->getMessage()
                    ]);
                }
                exit;
            }
            break;

        case 'edit':
            $id = $_GET['id'] ?? null;

            if (!$id) {
                echo "ID inválido";
                exit;
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                header('Content-Type: application/json; charset=utf-8');

                $data = [
                    'id'     => $_POST['id'] ?? '',
                    'nombre' => $_POST['nombre'] ?? '',
                    'receta' => $_POST['receta'] ?? '',
                    'fecha'  => $_POST['fecha'] ?? ''
                ];

                try {
                    $success = $model->update($data);
                    echo json_encode([
                        'success' => $success,
                        'message' => 'Menú actualizado correctamente'
                    ]);
                } catch (Exception $e) {
                    echo json_encode([
                        'success' => false,
                        'message' => $e->getMessage()
                    ]);
                }
                exit;
            } else {
                $menu = $model->getById($id);
                $recetas = $model->getRecetas();
                require 'app/views/menus/menuedit.php';
            }
            break;

        case 'delete':
            header('Content-Type: application/json; charset=utf-8');
            $id = $_GET['id'] ?? null;

            if (!$id) {
                echo json_encode(['success' => false, 'message' => 'ID inválido']);
                exit;
            }

            try {
                $success = $model->delete($id);
                echo json_encode([
                    'success' => $success,
                    'message' => 'Menú eliminado correctamente'
                ]);
            } catch (Exception $e) {
                echo json_encode([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
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
