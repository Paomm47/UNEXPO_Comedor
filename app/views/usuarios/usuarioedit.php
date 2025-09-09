<!-- usuarioedit.php -->
<div class="form-container">
    <form id="formEditarUsuario" autocomplete="off">
        <div class="modal-header">
            <h5 class="modal-title form-title">Editar Usuario</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
            <div class="row g-3">
                <input type="hidden" name="cedula_original" value="<?= htmlspecialchars($usuario['Cedula_Usuario']) ?>">

                <div class="col-md-6 input-group-icon">
                    <label class="form-label">Cédula</label>
                    <i class="fas fa-id-card"></i>
                    <input type="text" name="cedula" class="form-control" value="<?= htmlspecialchars($usuario['Cedula_Usuario']) ?>" required>
                </div>

                <div class="col-md-6 input-group-icon">
                    <label class="form-label">Nombre</label>
                    <i class="fas fa-user"></i>
                    <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($usuario['Nombre']) ?>" required>
                </div>

                <div class="col-md-6 input-group-icon">
                    <label class="form-label">Tipo de Usuario</label>
                    <i class="fas fa-user-tag"></i>
                    <select name="tipo" class="form-select" required>
                        <?php foreach ($tipos as $tipo): ?>
                            <option value="<?= htmlspecialchars($tipo['id']) ?>" <?= $tipo['id'] == $usuario['tipo'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($tipo['Nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
    </form>
</div>
