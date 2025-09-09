<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\ComprasModel;

if (!isset($_SESSION['usuario'])) {
    header('Location: /unexpo_comedor_v5');
    exit;
}

$model = new ComprasModel();
$action = $_GET['action'] ?? 'index';

try {
    switch ($action) {
        case 'index':
            $compras = $model->getAll();
            require 'app/views/layout/header.php';
            require 'app/views/layout/sidebar.php';
            require 'app/views/compras/comprasview.php';
            require 'app/views/layout/footer.php';
            break;

        case 'create':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                header('Content-Type: application/json; charset=utf-8');
                $data = [
                    'rif_proveedor' => $_POST['rif_proveedor'] ?? '',
                    'fecha' => $_POST['fecha'] ?? '',
                    'factura' => $_POST['factura'] ?? '',
                    'detalles' => $_POST['detalles'] ?? []
                ];
                try {
                    $success = $model->create($data);
                    echo json_encode(['success' => $success, 'message' => $success ? 'Compra creada' : 'Error al crear compra']);
                } catch (Exception $e) {
                    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
                }
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
                    'id' => (int)$_POST['id'],
                    'rif_proveedor' => $_POST['rif_proveedor'] ?? '',
                    'fecha' => $_POST['fecha'] ?? '',
                    'factura' => $_POST['factura'] ?? '',
                    'detalles' => $_POST['detalles'] ?? []
                ];

                try {
                    $success = $model->update($data);
                    echo json_encode(['success' => $success, 'message' => $success ? 'Compra actualizada' : 'Error al actualizar compra']);
                } catch (Exception $e) {
                    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
                }
                exit;
            } else {
                $compra = $model->getById((int)$id);
                $detalles = $model->getDetallesByCompraId((int)$id);
                $proveedores = $model->getProveedores();
                $productos = $model->getProductos();
                $empaques = $model->getEmpaques();
                $marcas = $model->getMarcas();
                require 'app/views/compras/comprasedit.php';
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
                $success = $model->delete((int)$id);
                echo json_encode(['success' => $success, 'message' => $success ? 'Compra eliminada' : 'Error al eliminar compra']);
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
            break;

        default:
            echo "Acción no válida";
            exit;
    }
} catch (Exception $e) {
    http_response_code(500);
    echo "Error inesperado: " . $e->getMessage();
    exit;
}
