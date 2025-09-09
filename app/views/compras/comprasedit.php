<form id="formEditarCompra" action="app/controllers/comprascontroller.php?action=edit&id=<?= urlencode($compra['Id_Compra']) ?>" method="post">
    <input type="hidden" name="id" value="<?= htmlspecialchars($compra['Id_Compra']) ?>">

    <div class="modal-header">
        <h5 class="modal-title">Editar Compra</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
    </div>

    <div class="modal-body">
        <div class="mb-3">
            <label for="rif_proveedor" class="form-label">Proveedor</label>
            <select name="rif_proveedor" id="rif_proveedor" class="form-select" required>
                <option value="" disabled>Seleccione un proveedor</option>
                <?php foreach ($proveedores as $p): ?>
                    <option value="<?= $p['Rif_Proveedor'] ?>" <?= $compra['Rif_Proveedor'] == $p['Rif_Proveedor'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($p['Nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="date" name="fecha" id="fecha" class="form-control" required
                value="<?= htmlspecialchars($compra['Fecha']) ?>">
        </div>

        <div class="mb-3">
            <label for="factura" class="form-label">Número de Factura</label>
            <input type="number" name="factura" id="factura" class="form-control" required
                value="<?= htmlspecialchars($compra['Numero_Factura']) ?>">
        </div>

        <hr class="my-4">

        <h6>Detalles de la Compra</h6>

        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center" id="tablaDetallesEditar">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Empaque</th>
                        <th>Peso Unitario</th>
                        <th>Cantidad</th>
                        <th>Marca</th>
                        <th><button type="button" id="btnAgregarDetalleEditar" class="btn btn-sm btn-success">+</button></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($detalles as $index => $detalle): ?>
                        <tr>
                            <td>
                                <select name="detalles[<?= $index ?>][producto]" class="form-select" required>
                                    <?php foreach ($productos as $prod): ?>
                                        <option value="<?= $prod['Codigo_Producto'] ?>" <?= $detalle['Codigo_Producto'] == $prod['Codigo_Producto'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($prod['Nombre']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td><input type="number" step="0.01" name="detalles[<?= $index ?>][precio]" class="form-control" value="<?= $detalle['Precio_Producto'] ?>" required></td>
                            <td>
                                <select name="detalles[<?= $index ?>][empaque]" class="form-select" required>
                                    <?php foreach ($empaques as $e): ?>
                                        <option value="<?= $e['Id_Empaquetado'] ?>" <?= $detalle['Id_Empaquetado'] == $e['Id_Empaquetado'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($e['Nombre']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td><input type="number" step="0.01" name="detalles[<?= $index ?>][peso]" class="form-control" value="<?= $detalle['PesoUnitario'] ?>" required></td>
                            <td><input type="number" name="detalles[<?= $index ?>][cantidad]" class="form-control" value="<?= $detalle['Cantidad_Producto'] ?>" required></td>
                            <td>
                                <select name="detalles[<?= $index ?>][marca]" class="form-select" required>
                                    <?php foreach ($marcas as $m): ?>
                                        <option value="<?= $m['Id_Marca'] ?>" <?= $detalle['Id_Marca'] == $m['Id_Marca'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($m['Nombre']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td><button type="button" class="btn btn-danger btnEliminarFilaDetalle">-</button></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-success">Guardar cambios</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
    </div>
</form>
