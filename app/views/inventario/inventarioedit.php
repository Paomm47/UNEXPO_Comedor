<form id="formEditarProducto" action="app/controllers/inventariocontroller.php?action=edit&id=<?= urlencode($producto['Codigo_Producto']) ?>" method="post">
    <div class="modal-header">
        <h5 class="modal-title">Editar Producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
    </div>
    <div class="modal-body">
        <input type="hidden" name="codigo" value="<?= htmlspecialchars($producto['Codigo_Producto']) ?>">

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($producto['Nombre']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="unidad" class="form-label">Unidad de Medida:</label>
            <select name="unidad" class="form-select" required>
                <?php foreach ($unidades as $u): ?>
                    <option value="<?= $u['id'] ?>" <?= $producto['Id_Unidad'] == $u['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($u['UnidadMasa']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="categoria" class="form-label">Categoría:</label>
            <select name="categoria" class="form-select" required>
                <?php foreach ($categorias as $c): ?>
                    <option value="<?= $c['id'] ?>" <?= $producto['Id_Categoria'] == $c['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($c['Nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-success">Guardar Cambios</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
    </div>
</form>
