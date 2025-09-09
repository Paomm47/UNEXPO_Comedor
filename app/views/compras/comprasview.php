
<div class="fondo-difuminado"></div>
<section>
<div id="caja-central" style="color: black;">

<div class="container-fluid px-3">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
        <h4 class="mb-0">Gestión de Compras</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearCompra">
            <i class="bi bi-plus-circle"></i> Nueva Compra
        </button>
    </div>
    <div class="container-table">
    <table id="tablaCompras" class="table table-bordered table-hover align-middle text-center">
        <thead>
            <tr>
                <th>ID Compra</th>
                <th>Proveedor</th>
                <th>Fecha</th>
                <th>Número Factura</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($compras)): ?>
                <?php foreach ($compras as $compra): ?>
                    <tr>
                        <td><?= htmlspecialchars($compra['Id_Compra']) ?></td>
                        <td><?= htmlspecialchars($compra['proveedor']) ?></td>
                        <td><?= htmlspecialchars($compra['Fecha']) ?></td>
                        <td><?= htmlspecialchars($compra['Numero_Factura']) ?></td>
                        <td>
                            <button class="btn btn-sm btn-warning btnEditarCompra" data-id="<?= $compra['Id_Compra'] ?>">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button class="btn btn-sm btn-danger btnEliminarCompra" data-id="<?= $compra['Id_Compra'] ?>">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="5">No hay compras registradas.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    </div></div></div></section>
<!-- MODAL Crear Compra -->
<div class="modal fade" id="modalCrearCompra" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="formCrearCompra" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title">Crear Nueva Compra</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="rif_proveedor" class="form-label">Proveedor</label>
                            <select name="rif_proveedor" id="rif_proveedor" class="form-select" required>
                                <option value="" selected disabled>Seleccione un proveedor</option>
                                <?php
                                // Para obtener proveedores, crea modelo aparte o usa AJAX para cargar
                                // Aquí solo un placeholder estático, reemplázalo con datos reales en controlador o AJAX
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="fecha" class="form-label">Fecha</label>
                            <input type="date" name="fecha" id="fecha" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label for="factura" class="form-label">Número de Factura</label>
                            <input type="number" name="factura" id="factura" class="form-control" required>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h6>Detalles de la Compra</h6>

                    <table class="table table-bordered align-middle text-center" id="tablaDetallesCompra">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Precio</th>
                                <th>Empaque</th>
                                <th>Peso Unitario</th>
                                <th>Cantidad</th>
                                <th>Marca</th>
                                <th><button type="button" id="btnAgregarDetalle" class="btn btn-sm btn-success">+</button></th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Filas se agregarán con JS -->
                        </tbody>
                    </table>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Guardar Compra</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL Editar Compra -->
<div class="modal fade" id="modalEditarCompra" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- Contenido cargado por JS -->
        </div>
    </div>
</div>

<script src="assets/js/compras.js"></script>
