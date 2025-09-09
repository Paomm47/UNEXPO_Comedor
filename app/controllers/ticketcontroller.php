<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\ticketmodel;

if (!isset($_SESSION['usuario'])) {
    header('Location: /unexpo_comedor_v5');
    exit;
}

$model = new ticketmodel();

$action = $_GET['action'] ?? 'index';

try {
    switch ($action) {
        case 'index':
            $tickets = $model->getAll();
            $tipos = $model->getTiposComensal();
            $menus = $model->getMenus();

            require 'app/views/layout/header.php';
            require 'app/views/layout/sidebar.php';
            require 'app/views/tickets/ticketsview.php';
            require 'app/views/layout/footer.php';
            break;

        case 'create':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                header('Content-Type: application/json; charset=utf-8');
                $data = [
                    'tipocomensal' => $_POST['tipocomensal'] ?? '',
                    'menu' => $_POST['menu'] ?? ''
                ];

                try {
                    $success = $model->create($data);
                    echo json_encode(['success' => $success, 'message' => 'Ticket creado correctamente']);
                } catch (Exception $e) {
                    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
                }
                exit;
            }
            break;

        case 'edit':
            $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
            if (!$id) {
                echo "ID inválido";
                exit;
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                header('Content-Type: application/json; charset=utf-8');
                $data = [
                    'id' => $id,
                    'tipocomensal' => $_POST['tipocomensal'] ?? '',
                    'menu' => $_POST['menu'] ?? ''
                ];

                try {
                    $success = $model->update($data);
                    echo json_encode(['success' => $success, 'message' => 'Ticket actualizado correctamente']);
                } catch (Exception $e) {
                    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
                }
                exit;
            } else {
                $ticket = $model->getById($id);
                if (!$ticket) {
                    echo "Ticket no encontrado";
                    exit;
                }
                $tipos = $model->getTiposComensal();
                $menus = $model->getMenus();

                require __DIR__ . '/../views/tickets/ticketeditarview.php';
            }
            break;

        case 'delete':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                header('Content-Type: application/json; charset=utf-8');
                $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
                if (!$id) {
                    echo json_encode(['success' => false, 'message' => 'ID inválido']);
                    exit;
                }

                try {
                    $success = $model->delete($id);
                    echo json_encode(['success' => $success, 'message' => 'Ticket eliminado correctamente']);
                } catch (Exception $e) {
                    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
                }
                exit;
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
