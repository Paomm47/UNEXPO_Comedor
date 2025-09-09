<!-- usuariocrear.php -->
<div class="modal fade" id="modalCrearUsuario" tabindex="-1" aria-labelledby="crearUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content form-container">
            <form id="formCrearUsuario" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title form-title" id="crearUsuarioLabel">Agregar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6 input-group-icon">
                            <label for="codigo" class="form-label">Cédula</label>
                            <i class="fas fa-id-card"></i>
                            <input type="text" name="codigo" id="codigo" class="form-control" required pattern="\d{6,}" maxlength="10" placeholder="Ej: 12345678">
                        </div>
                        <div class="col-md-6 input-group-icon">
                            <label for="nombre" class="form-label">Nombre</label>
                            <i class="fas fa-user"></i>
                            <input type="text" name="nombre" id="nombre" class="form-control" required placeholder="Ej: María González">
                        </div>
                        <div class="col-md-6 input-group-icon">
                            <label for="contrasena" class="form-label">Contraseña</label>
                            <i class="fas fa-lock"></i>
                            <input type="password" name="contrasena" id="contrasena" class="form-control" required minlength="4" placeholder="Mínimo 4 caracteres">
                        </div>
                        <div class="col-md-6 input-group-icon">
                            <label for="tipo" class="form-label">Tipo de Usuario</label>
                            <i class="fas fa-user-tag"></i>
                            <select name="tipo" id="tipo" class="form-select" required>
                                <option value="" selected disabled>-- Seleccione un tipo --</option>
                                <?php foreach ($tipos as $tipo): ?>
                                    <option value="<?= htmlspecialchars($tipo['id']) ?>"><?= htmlspecialchars($tipo['Nombre']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Crear Usuario</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
