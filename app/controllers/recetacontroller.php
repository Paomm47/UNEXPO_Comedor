<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\recetamodel;

if (!isset($_SESSION['usuario'])) {
    header('Location: /unexpo_comedor_v5');
    exit;
}

$model = new recetamodel();
$action = $_GET['action'] ?? 'index';

header('Content-Type: application/json; charset=utf-8');

try {
    switch ($action) {
        case 'index':
            header('Content-Type: text/html; charset=utf-8');
            $recetas = $model->getAll();
            require 'app/views/layout/header.php';
            require 'app/views/layout/sidebar.php';
            require 'app/views/recetas/recetasview.php';
            require 'app/views/layout/footer.php';
            break;

        case 'create':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = [
                    'nombre' => $_POST['nombre'] ?? '',
                    'ingredientes' => $_POST['ingredientes'] ?? []
                ];
                $success = $model->create($data);
                echo json_encode([
                    'success' => $success,
                    'message' => $success ? 'Receta creada exitosamente' : 'Error al crear receta'
                ]);
            }
            break;

        case 'edit':
            $id = intval($_GET['id'] ?? 0);
            if (!$id) {
                echo json_encode(['success' => false, 'message' => 'ID inválido']);
                exit;
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = [
                    'id' => $id,
                    'nombre' => $_POST['nombre'] ?? '',
                    'ingredientes' => $_POST['ingredientes'] ?? []
                ];
                $success = $model->update($data);
                echo json_encode([
                    'success' => $success,
                    'message' => $success ? 'Receta actualizada' : 'Error al actualizar receta'
                ]);
            } else {
                header('Content-Type: text/html; charset=utf-8');
                $receta = $model->getById($id);
                if (!$receta) {
                    echo "Receta no encontrada";
                    exit;
                }
                $ingredientes = $model->getIngredientes($id);
                $productos = $model->getProductos();
                $unidades = $model->getUnidades();
                require 'app/views/layout/header.php';
                require 'app/views/layout/sidebar.php';
                require 'app/views/recetas/recetaedit.php';
                require 'app/views/layout/footer.php';
            }
            break;

        case 'delete':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id = intval($_POST['id'] ?? 0);
                if (!$id) {
                    echo json_encode(['success' => false, 'message' => 'ID inválido']);
                    exit;
                }
                $success = $model->delete($id);
                echo json_encode([
                    'success' => $success,
                    'message' => $success ? 'Receta eliminada' : 'Error al eliminar receta'
                ]);
            }
            break;

        default:
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Acción no válida']);
            break;
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
