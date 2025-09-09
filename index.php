<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';

$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
          strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

$modulo = isset($_GET['view']) ? basename($_GET['view']) : 'login';

// Logout
if ($modulo === 'logout') {
    session_unset();
    session_destroy();
    setcookie(session_name(), '', time() - 3600, '/');
    header('Location: index.php?view=login');
    exit;
}

// Si es login por AJAX
if ($modulo === 'login' && $isAjax && $_SERVER['REQUEST_METHOD'] === 'POST') {
    require __DIR__ . "/app/controllers/logincontroller.php";
    exit;
}

// Mostrar login si no hay sesión y está accediendo al login
if (!isset($_SESSION['usuario']) && $modulo === 'login') {
    require __DIR__ . '/app/views/auth/login.php';
    exit;
}

// Redirigir a home si ya hay sesión y accede a login
if (isset($_SESSION['usuario']) && $modulo === 'login') {
    header("Location: index.php?view=home");
    exit;
}

// Controlador
$controller = __DIR__ . "/app/controllers/{$modulo}controller.php";
if (file_exists($controller)) {
    require $controller;
    exit;
}

// Vista
$view = __DIR__ . "/app/views/{$modulo}/{$modulo}view.php";
if (file_exists($view)) {
    require __DIR__ . '/app/views/layout/header.php';
    require __DIR__ . '/app/views/layout/sidebar.php';
    require $view;
    require __DIR__ . '/app/views/layout/footer.php';
    exit;
}

// Vista no encontrada
http_response_code(404);
echo "Vista no encontrada.";
exit;
