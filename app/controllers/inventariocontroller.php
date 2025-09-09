<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\inventariomodel;

if (!isset($_SESSION['usuario'])) {
    header('Location: /unexpo_comedor_v5');
    exit;
}

$model = new inventariomodel();
$action = $_GET['action'] ?? 'index';

try {
    switch ($action) {
        case 'index':
            $productos = $model->getAll();
            $unidades = $model->getUnidades();
            $categorias = $model->getCategorias();
            require 'app/views/layout/header.php';
            require 'app/views/layout/sidebar.php';
            require 'app/views/inventario/inventarioview.php';
            require 'app/views/layout/footer.php';
            break;

        case 'create':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                header('Content-Type: application/json; charset=utf-8');
                $data = [
                    'codigo'    => $_POST['codigo'] ?? '',
                    'nombre'    => $_POST['nombre'] ?? '',
                    'unidad'    => $_POST['unidad'] ?? '',
                    'categoria' => $_POST['categoria'] ?? ''
                ];

                try {
                    $success = $model->create($data);
                    echo json_encode(['success' => $success, 'message' => 'Producto agregado exitosamente']);
                } catch (Exception $e) {
                    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
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
                    'codigo'    => $_POST['codigo'] ?? '',
                    'nombre'    => $_POST['nombre'] ?? '',
                    'unidad'    => $_POST['unidad'] ?? '',
                    'categoria' => $_POST['categoria'] ?? ''
                ];

                try {
                    $success = $model->update($data);
                    echo json_encode(['success' => $success, 'message' => 'Producto actualizado correctamente']);
                } catch (Exception $e) {
                    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
                }
                exit;
            } else {
                $producto = $model->getById($id);
                $unidades = $model->getUnidades();
                $categorias = $model->getCategorias();
                require __DIR__ . '/../views/inventario/inventarioedit.php';
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
                echo json_encode(['success' => $success, 'message' => 'Producto eliminado correctamente']);
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
