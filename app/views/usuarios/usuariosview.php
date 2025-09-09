<!-- usuariosview.php -->
<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<div class="fondo-difuminado"></div>
<section>
<div id="caja-central" style="color: black;">
<div class="container-fluid px-3">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
        <h4 class="mb-0">Gestión de Usuarios</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearUsuario">
            <i class="bi bi-plus-circle"></i> Nuevo Usuario
        </button>
    </div>

    <div class="container-table">
        <table id="tablaUsuarios" class="table dataTable table-bordered table-hover align-middle">
            <thead>
                <tr>
                    <th>Cédula</th>
                    <th>Nombre</th>
                    <th>Tipo de Usuario</th>
                    <th class="text-nowrap">Acciones</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php if (!empty($usuarios)): ?>
                    <?php foreach ($usuarios as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['Cedula_Usuario']) ?></td>
                            <td><?= htmlspecialchars($user['Nombre']) ?></td>
                            <td><?= htmlspecialchars($user['tipo']) ?></td>
                            <td>
                                <button class="btn btn-sm btn-warning btnEditarUsuario" data-id="<?= $user['Cedula_Usuario'] ?>">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button class="btn btn-sm btn-danger btnEliminarUsuario" data-id="<?= $user['Cedula_Usuario'] ?>">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4">No hay usuarios registrados.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</div>
</section>

<!-- MODAL EDITAR -->
<div class="modal fade" id="modalEditarUsuario" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Se carga usuarioedit.php por AJAX -->
        </div>
    </div>
</div>

<!-- MODAL CREAR -->
<?php include_once 'usuariocrear.php'; ?>

<script src="assets/js/usuarios.js"></script>
