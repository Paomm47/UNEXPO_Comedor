<form id="formEditarMenu" action="app/controllers/menucontroller.php?action=edit&id=<?= $menu['Id_Menu'] ?>" method="post">
    <div class="modal-header">
        <h5 class="modal-title">Editar Menú</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
    </div>
    <div class="modal-body row g-3">
        <input type="hidden" name="id" value="<?= $menu['Id_Menu'] ?>">

        <div class="col-md-6">
            <label for="nombre" class="form-label">Nombre del Menú</label>
            <input type="text" name="nombre" id="nombre" class="form-control" 
                   value="<?= htmlspecialchars($menu['Nombre']) ?>" required>
        </div>

        <div class="col-md-6">
            <label for="receta" class="form-label">Receta</label>
            <select name="receta" id="receta" class="form-select" required>
                <option value="" disabled>-- Seleccione una receta --</option>
                <?php foreach ($recetas as $r): ?>
                    <option value="<?= $r['Id_Receta'] ?>" <?= $menu['Id_Receta'] == $r['Id_Receta'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($r['Nombre']) ?>
                    </option>
                <?php endforeach ?>
            </select>
        </div>

        <div class="col-md-6">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="date" name="fecha" id="fecha" class="form-control"
                   value="<?= $menu['Fecha'] ?>" required>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-success">Guardar cambios</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
    </div>
</form>
