<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\proveedormodel;

if (!isset($_SESSION['usuario'])) {
    header('Location: /unexpo_comedor_v5');
    exit;
}

$model = new proveedormodel();
$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'index':
        // Carga la vista principal (el contenedor de la tabla)
        require 'app/views/layout/header.php';
        require 'app/views/layout/sidebar.php';
        require 'app/views/proveedores/proveedoresview.php';
        require 'app/views/layout/footer.php';
        break;

    case 'get_all':
        // NUEVO: Proporciona los datos en formato JSON para AJAX
        header('Content-Type: application/json');
        try {
            $proveedores = $model->getAll();
            $data = [];
            foreach ($proveedores as $prov) {
                // Construye las acciones como una cadena HTML
                $acciones = '<button class="btn btn-warning btn-sm btnEditarProveedor" data-id="' . htmlspecialchars($prov['Rif_Proveedor']) . '" title="Editar"><i class="bi bi-pencil-square"></i></button> ' .
                            '<button class="btn btn-danger btn-sm btnEliminarProveedor" data-id="' . htmlspecialchars($prov['Rif_Proveedor']) . '" title="Eliminar"><i class="bi bi-trash"></i></button>';
                
                $data[] = [
                    "Rif_Proveedor" => htmlspecialchars($prov['Rif_Proveedor']),
                    "Nombre" => htmlspecialchars($prov['Nombre']),
                    "Correo" => htmlspecialchars($prov['Correo']),
                    "Telefono" => htmlspecialchars($prov['Telefono']),
                    "Acciones" => $acciones
                ];
            }
            echo json_encode(['data' => $data]);
        } catch (Exception $e) {
            echo json_encode(['data' => [], 'error' => $e->getMessage()]);
        }
        break;

    case 'create':
        header('Content-Type: application/json');
        try {
            $data = [
                'rif' => $_POST['rif'] ?? '',
                'nombre' => $_POST['nombre'] ?? '',
                'correo' => $_POST['correo'] ?? '',
                'telefono' => $_POST['telefono'] ?? ''
            ];
            $success = $model->create($data);
            echo json_encode(['success' => $success, 'message' => 'Proveedor creado correctamente.']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Error al crear: ' . $e->getMessage()]);
        }
        break;

    case 'edit':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Procesa la actualización de datos
            header('Content-Type: application/json');
            try {
                $data = [
                    'rif' => $_POST['rif'] ?? '',
                    'nombre' => $_POST['nombre'] ?? '',
                    'correo' => $_POST['correo'] ?? '',
                    'telefono' => $_POST['telefono'] ?? ''
                ];
                $success = $model->update($data);
                echo json_encode(['success' => $success, 'message' => 'Proveedor actualizado correctamente.']);
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Error al actualizar: ' . $e->getMessage()]);
            }
        } else {
            // Muestra el formulario de edición
            $rif = $_GET['id'] ?? '';
            $proveedor = $model->getById($rif);
            // Carga solo la vista parcial del formulario para inyectarla en el modal
            require 'app/views/proveedores/proveedoredit.php';
        }
        break;

    case 'delete':
        header('Content-Type: application/json');
        try {
            $rif = $_POST['id'] ?? '';
            $success = $model->delete($rif);
            echo json_encode(['success' => $success, 'message' => 'Proveedor eliminado correctamente.']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Error al eliminar: ' . $e->getMessage()]);
        }
        break;

    default:
        http_response_code(404);
        echo "Acción no válida.";
}