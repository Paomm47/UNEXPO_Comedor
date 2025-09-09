<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\LoginModel;

header('Content-Type: application/json');

// Solo aceptar POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

// Obtener y limpiar datos
$cedula = trim($_POST['cedula'] ?? '');
$password = trim($_POST['password'] ?? '');

if ($cedula === '' || $password === '') {
    echo json_encode(['success' => false, 'message' => 'Campos vacíos']);
    exit;
}

try {
    $model = new LoginModel();
    $usuario = $model->verificarCredenciales($cedula, $password);

    if ($usuario) {
        session_regenerate_id(true);
        $_SESSION['usuario'] = $usuario;
        echo json_encode(['success' => true, 'message' => 'Inicio de sesión exitoso']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Credenciales inválidas']);
    }
} catch (Exception $e) {
    error_log('Error en logincontroller: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Error interno del servidor']);
}

exit;
