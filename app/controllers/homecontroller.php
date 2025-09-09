<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\HomeModel;

// Verificar sesión
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php?view=login');
    exit;
}

try {
    // Cargar modelo y obtener datos
    $model = new HomeModel();
    $totalUsuarios = $model->getTotalUsuarios();
    $ticketsHoy = $model->getTicketsTotales();

    // Cargar vistas
    require_once __DIR__ . '/../views/layout/header.php';
    require_once __DIR__ . '/../views/layout/sidebar.php';
    require_once __DIR__ . '/../views/home/homeview.php';
    require_once __DIR__ . '/../views/layout/footer.php';

} catch (Exception $e) {
    // Registrar error y mostrar vista genérica o mensaje controlado
    error_log("Error en HomeController: " . $e->getMessage());

    http_response_code(500);
    echo "<div style='padding: 2rem; font-family: sans-serif; color: red;'>
            <h2>Error interno del servidor</h2>
            <p>" . htmlspecialchars($e->getMessage()) . "</p>
          </div>";
}
