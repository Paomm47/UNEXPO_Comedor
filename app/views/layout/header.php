<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <!-- META -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>UNEXPO Comedor</title>
    <link rel="icon" href="assets/img/lg.png" type="image/png" />

    <!-- BOOTSTRAP CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- FONTAWESOME CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet" />

    <!-- BOOTSTRAP ICONS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

    <!-- DATATABLES CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet" />

    <!-- ESTILOS PERSONALIZADOS -->
    <link rel="stylesheet" href="assets/css/layout.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/stylelg.css">
    <link rel="stylesheet" href="assets/css/forms.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


    <!-- JQUERY (antes de DataTables JS) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DATATABLES JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <!-- BOOTSTRAP JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

    <div class="fondo-difuminado"></div>


<?php if (isset($_SESSION['usuario']) && !empty($_SESSION['usuario'])): ?>
    <!-- NAVBAR SUPERIOR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top shadow">
        <div class="container-fluid">
            <button class="btn btn-outline-light me-3" id="btnToggleSidebar" type="button" aria-label="Toggle sidebar">
                <i class="fas fa-bars"></i>
            </button>
            <a class="navbar-brand d-flex align-items-center" href="index.php?view=home">
                <img src="assets/img/hg.png" alt="Logo" width="35" class="me-2" />
                UNEXPO Comedor
            </a>
            <div class="ms-auto text-white d-flex align-items-center">
                <i class="fas fa-user-circle me-1" aria-hidden="true"></i>
                <span><?= htmlspecialchars($_SESSION['usuario']['Nombre'] ?? 'Usuario') ?></span>
            </div>
        </div>
    </nav>

    <!-- ESTRUCTURA PRINCIPAL -->
    <div class="container-fluid pt-5">
        <div class="row">
            <!-- Aquí va el sidebar y contenido principal -->
<?php else: ?>
    <!-- Si no hay sesión, no mostramos navbar ni estructura principal -->
<?php endif; ?>
