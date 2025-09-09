<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>


<div class="fondo-difuminado"></div>
<section>
<div id="caja-central" style="color: black;">
<div class="container-fluid px-3">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
        <h4 class="mb-0">Gestión de Inventario</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearProducto">
            <i class="bi bi-plus-circle"></i> Nuevo Producto
        </button>
    </div>

    <div class="container-table">
        <table id="tablaInventario" class="table dataTable table-bordered table-hover align-middle">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Unidad</th>
                    <th>Categoría</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php if (!empty($productos)): ?>
                    <?php foreach ($productos as $p): ?>
                        <tr>
                            <td><?= htmlspecialchars($p['Codigo_Producto']) ?></td>
                            <td><?= htmlspecialchars($p['Nombre']) ?></td>
                            <td><?= htmlspecialchars($p['unidad']) ?></td>
                            <td><?= htmlspecialchars($p['categoria']) ?></td>
                            <td>
                                <button class="btn btn-sm btn-warning btnEditarProducto" data-id="<?= $p['Codigo_Producto'] ?>">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button class="btn btn-sm btn-danger btnEliminarProducto" data-id="<?= $p['Codigo_Producto'] ?>">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5">No hay productos registrados.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</div>
</section>

<!-- MODAL: Crear Producto -->
<div class="modal fade" id="modalCrearProducto" tabindex="-1" aria-labelledby="crearProductoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formCrearProducto" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="codigo" class="form-label">Código</label>
                            <input type="text" name="codigo" id="codigo" class="form-control" required placeholder="Ej: PRD001">
                        </div>
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" required placeholder="Ej: Arroz">
                        </div>
                        <div class="col-md-6">
                            <label for="unidad" class="form-label">Unidad de Medida</label>
                            <select name="unidad" id="unidad" class="form-select" required>
                                <option value="" disabled selected>-- Seleccione --</option>
                                <?php foreach ($unidades as $u): ?>
                                    <option value="<?= $u['id'] ?>"><?= htmlspecialchars($u['UnidadMasa']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="categoria" class="form-label">Categoría</label>
                            <select name="categoria" id="categoria" class="form-select" required>
                                <option value="" disabled selected>-- Seleccione --</option>
                                <?php foreach ($categorias as $c): ?>
                                    <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['Nombre']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Crear producto</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL: Editar Producto -->
<div class="modal fade" id="modalEditarProducto" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Contenido dinámico con JS -->
        </div>
    </div>
</div>

<script src="assets/js/inventario.js"></script>
