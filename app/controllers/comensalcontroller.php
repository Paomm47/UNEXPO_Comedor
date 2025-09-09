<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\comensalmodel;

if (!isset($_SESSION['usuario'])) {
    header('Location: index.php?view=login');
    exit;
}

$model = new comensalmodel();
$action = $_GET['action'] ?? 'index';

try {
    switch ($action) {

        case 'index':
            $comensales = $model->getAll();
            $tipos_comensales = $model->getTiposComensal();
            $nucleos = $model->getNucleos();
            $departamentos = $model->getDepartamentos();

            require __DIR__ . '/../views/layout/header.php';
            require __DIR__ . '/../views/layout/sidebar.php';
            require __DIR__ . '/../views/comensal/comensalview.php';
            require __DIR__ . '/../views/layout/footer.php';
            break;

        case 'create':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                header('Content-Type: application/json');
                try {
                    $data = [
                        'cedula'       => $_POST['cedula'],
                        'pnom'         => $_POST['pnom'],
                        'snom'         => $_POST['snom'],
                        'pape'         => $_POST['pape'],
                        'sape'         => $_POST['sape'],
                        'genero'       => $_POST['genero'],
                        'tipo'         => $_POST['Codigo_TipoComensal'],
                        'nucleo'       => $_POST['Codigo_Nucleo'],
                        'departamento' => $_POST['Codigo_Departamento'],
                        'estado'       => 1 // por defecto activo
                    ];
                    $success = $model->create($data);
                    echo json_encode(['success' => $success, 'message' => 'Comensal registrado.']);
                } catch (Exception $e) {
                    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
                }
                exit;
            }
            break;

        case 'edit':
            $cedula = $_GET['id'] ?? null;
            if (!$cedula) exit('ID inválido');

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                header('Content-Type: application/json');
                try {
                    $data = [
                        'cedula'       => $_POST['cedula'],
                        'pnom'         => $_POST['pnom'],
                        'snom'         => $_POST['snom'],
                        'pape'         => $_POST['pape'],
                        'sape'         => $_POST['sape'],
                        'genero'       => $_POST['genero'],
                        'tipo'         => $_POST['Codigo_TipoComensal'],
                        'nucleo'       => $_POST['Codigo_Nucleo'],
                        'departamento' => $_POST['Codigo_Departamento'],
                        'estado'       => 1 // mantener estado activo
                    ];
                    $success = $model->update($data);
                    echo json_encode(['success' => $success, 'message' => 'Comensal actualizado.']);
                } catch (Exception $e) {
                    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
                }
                exit;
            } else {
                $comensal = $model->getById($cedula);
                $tipos_comensales = $model->getTiposComensal();
                $nucleos = $model->getNucleos();
                $departamentos = $model->getDepartamentos();
                require __DIR__ . '/../views/comensal/comensaledit.php';
            }
            break;

        case 'delete':
            header('Content-Type: application/json');
            $id = $_GET['id'] ?? null;
            try {
                $success = $model->delete($id);
                echo json_encode(['success' => $success, 'message' => 'Comensal eliminado.']);
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
