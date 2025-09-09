
<div class="fondo-difuminado"></div>
<section>
<div id="caja-central" style="color: black;">

<div class="container-fluid px-3">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
        <h4 class="mb-0">Gestión de Menús</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearMenu">
            <i class="bi bi-plus-circle"></i> Nuevo Menú
        </button>
    </div>

    <div class="container-table">
        <table id="tablaMenus" class="table table-bordered table-hover align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Receta</th>
                    <th>Fecha</th>
                    <th class="text-nowrap">Acciones</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php if (!empty($menus)): ?>
                    <?php foreach ($menus as $menu): ?>
                        <tr>
                            <td><?= htmlspecialchars($menu['Id_Menu']) ?></td>
                            <td><?= htmlspecialchars($menu['Nombre']) ?></td>
                            <td><?= htmlspecialchars($menu['receta']) ?></td>
                            <td><?= htmlspecialchars($menu['Fecha']) ?></td>
                            <td>
                                <button class="btn btn-sm btn-warning btnEditarMenu" data-id="<?= $menu['Id_Menu'] ?>">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button class="btn btn-sm btn-danger btnEliminarMenu" data-id="<?= $menu['Id_Menu'] ?>">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No hay menús registrados.</td>
                    </tr>
                <?php endif; ?>

            </tbody>
        </table>
    </div>
</div>
</div></section>
<!-- MODAL: Crear Menú -->
<div class="modal fade" id="modalCrearMenu" tabindex="-1" aria-labelledby="crearMenuLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formCrearMenu" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Menú</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body row g-3">
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre del Menú</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" required placeholder="Ej: Desayuno Martes">
                    </div>
                    <div class="col-md-6">
                        <label for="receta" class="form-label">Receta</label>
                        <select name="receta" id="receta" class="form-select" required>
                            <option value="" disabled selected>-- Seleccione una receta --</option>
                            <?php foreach ($recetas as $r): ?>
                                <option value="<?= $r['Id_Receta'] ?>"><?= htmlspecialchars($r['Nombre']) ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="fecha" class="form-label">Fecha</label>
                        <input type="date" name="fecha" id="fecha" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Crear menú</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL: Editar Menú -->
<div class="modal fade" id="modalEditarMenu" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Se carga con JS -->
        </div>
    </div>
</div>

<script src="assets/js/menus.js"></script>
