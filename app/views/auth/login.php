<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login Comedor UNEXPO</title>
    <link rel="icon" href="assets/img/lg.png" type="image/png" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <!-- Estilos del sistema -->
    <link rel="stylesheet" href="assets/css/stylelg.css" />
</head>
<body>

<div class="fondo-lg"></div>

<div class="d-flex justify-content-center align-items-center vh-100">
    <form id="formLogin" autocomplete="off" novalidate class="bg-white p-5 rounded shadow" style="min-width: 500px; max-width: 450px; width: 100%;">
        <div class="text-center mb-4">
            <img src="assets/img/logo.png" alt="Logo Comedor UNEXPO" style="width: 200px; height: 200px;">
            <h2 class="mt-3" style="color: #0d47a1; font-weight: 700;">Iniciar sesión</h2>
        </div>

        <div class="mb-3 input-icon position-relative">
            <i class="fa fa-user position-absolute" style="left: 10px; top: 50%; transform: translateY(-50%); color: #0d47a1;"></i>
            <input type="text" id="cedula" name="cedula" class="form-control ps-5" placeholder="Usuario" required autocomplete="username" aria-label="Usuario" />
        </div>

        <div class="mb-3 input-icon position-relative">
            <i class="fa fa-lock position-absolute" style="left: 10px; top: 50%; transform: translateY(-50%); color: #0d47a1;"></i>
            <input type="password" id="password" name="password" class="form-control ps-5" placeholder="Contraseña" required autocomplete="current-password" aria-label="Contraseña" />
        </div>

        <div class="form-check mb-3 text-start">
            <input class="form-check-input" type="checkbox" id="mostrarPassword" />
            <label class="form-check-label" for="mostrarPassword" style="font-weight: normal; user-select:none; cursor:pointer;">
                Mostrar contraseña
            </label>
        </div>

        <button type="submit" class="btn btn-primary w-100 fw-bold">Entrar</button>
    </form>
</div>

<!-- Scripts generales -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Script propio para login -->
<script src="assets/js/login.js"></script>

</body>
</html>
