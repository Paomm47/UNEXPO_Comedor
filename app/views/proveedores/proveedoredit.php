<?php if (!empty($proveedor)): ?>
    <form id="formEditarProveedor" style="color: black;">
        <div class="modal-header">
            <h5 class="modal-title">Editar Proveedor</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body row g-3">
            <div class="col-md-6">
                <label for="rif" class="form-label">RIF</label>
                <input type="text" name="rif" class="form-control" value="<?= htmlspecialchars($proveedor['Rif_Proveedor']) ?>" readonly>
            </div>
            <div class="col-md-6">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($proveedor['Nombre']) ?>" required>
            </div>
            <div class="col-md-6">
                <label for="correo" class="form-label">Correo</label>
                <input type="email" name="correo" class="form-control" value="<?= htmlspecialchars($proveedor['Correo']) ?>" required>
            </div>
            <div class="col-md-6">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" name="telefono" class="form-control" value="<?= htmlspecialchars($proveedor['Telefono']) ?>" required>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
    </form>
<?php else: ?>
    <div class="modal-body">
        <div class="alert alert-danger">No se encontró el proveedor a editar.</div>
    </div>
<?php endif; ?>