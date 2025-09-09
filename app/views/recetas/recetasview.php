
<div class="fondo-difuminado"></div>
<section>
<div id="caja-central" style="color: black;">

<div class="container-fluid px-3">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
        <h4 class="mb-0">Gestión de Recetas</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearReceta">
            <i class="bi bi-plus-circle"></i> Nueva Receta
        </button>
    </div>
    <div class="container-table">
    <table class="table table-bordered table-hover align-middle text-center">
        <thead>
            <tr>
                <th>ID Receta</th>
                <th>Nombre</th>
                <th>Ingredientes</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($recetas)): ?>
                <?php foreach ($recetas as $receta): ?>
                    <tr>
                        <td><?= htmlspecialchars($receta['Id_Receta']) ?></td>
                        <td><?= htmlspecialchars($receta['Nombre']) ?></td>
                        <td><?= htmlspecialchars($receta['ingredientes']) ?></td>
                        <td>
                            <button class="btn btn-sm btn-warning btnEditarReceta" data-id="<?= $receta['Id_Receta'] ?>">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button class="btn btn-sm btn-danger btnEliminarReceta" data-id="<?= $receta['Id_Receta'] ?>">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="4">No hay recetas registradas.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</div>
</div>
</section>

<!-- MODAL Crear Receta -->
<div class="modal fade" id="modalCrearReceta" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="formCrearReceta" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title">Crear Nueva Receta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" required>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h6>Ingredientes</h6>
                    <table class="table table-bordered align-middle text-center" id="tablaIngredientesCrear">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Peso Detallado</th>
                                <th>Unidad</th>
                                <th><button type="button" id="btnAgregarIngredienteCrear" class="btn btn-sm btn-success">+</button></th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Filas agregadas con JS -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Guardar Receta</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL Editar Receta -->
<div class="modal fade" id="modalEditarReceta" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- Contenido cargado por JS -->
        </div>
    </div>
</div>

<script src="assets/js/recetas.js"></script>
