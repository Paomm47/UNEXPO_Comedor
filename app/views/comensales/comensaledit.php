<form id="formComensal" action="app/controllers/comensalcontroller.php?action=edit&id=<?= urlencode($comensal['Cedula_Comensal']) ?>" method="post">
    <div class="modal-header">
        <h5 class="modal-title">Editar Comensal</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
    </div>

    <div class="modal-body">
        <input type="hidden" name="cedula" value="<?= htmlspecialchars($comensal['Cedula_Comensal']) ?>">

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Primer Nombre</label>
                <input type="text" name="pnom" class="form-control" required value="<?= htmlspecialchars($comensal['PrimerNombre']) ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Segundo Nombre</label>
                <input type="text" name="snom" class="form-control" value="<?= htmlspecialchars($comensal['SegundoNombre']) ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Primer Apellido</label>
                <input type="text" name="pape" class="form-control" required value="<?= htmlspecialchars($comensal['PrimerApellido']) ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Segundo Apellido</label>
                <input type="text" name="sape" class="form-control" value="<?= htmlspecialchars($comensal['SegundoApellido']) ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">Género</label>
                <select name="genero" class="form-select" required>
                    <option value="" disabled>-- Seleccione --</option>
                    <option value="M" <?= $comensal['Genero'] === 'M' ? 'selected' : '' ?>>Masculino</option>
                    <option value="F" <?= $comensal['Genero'] === 'F' ? 'selected' : '' ?>>Femenino</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Tipo Comensal</label>
                <select name="tipoc" class="form-select" required>
                    <option value="" disabled>-- Seleccione --</option>
                    <?php foreach ($tipos as $t): ?>
                        <option value="<?= htmlspecialchars($t['id']) ?>" <?= $comensal['Codigo_TipoComensal'] == $t['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars(strip_tags($t['Nombre'])) ?>

                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Núcleo</label>
                <select name="nucleo" class="form-select" required>
                    <option value="" disabled>-- Seleccione --</option>
                    <?php foreach ($nucleos as $n): ?>
                        <option value="<?= htmlspecialchars($n['id']) ?>" <?= $comensal['Codigo_Nucleo'] == $n['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars(strip_tags($t['Nombre'])) ?>

                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-12">
                <label class="form-label">Departamento</label>
                <select name="departamento" class="form-select" required>
                    <option value="" disabled>-- Seleccione --</option>
                    <?php foreach ($departamentos as $d): ?>
                        <option value="<?= htmlspecialchars($d['id']) ?>" <?= $comensal['Codigo_Departamento'] == $d['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars(strip_tags($t['Nombre'])) ?>>

                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-success">Guardar cambios</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
    </div>
</form>
