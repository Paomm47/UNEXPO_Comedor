<div class="fondo-difuminado"></div>
<section>
<div id="caja-central" style="color: black;">

<div class="container mt-4">
    <h2 class="mb-4">Gestión de Comensales</h2>

    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalComensal">
        <i class="fas fa-plus"></i> Registrar Comensal
    </button>

    <table class="table table-bordered table-striped" id="tablaComensales">
        <thead class="table-dark">
            <tr>
                <th>Cédula</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Género</th>
                <th>Tipo</th>
                <th>Núcleo</th>
                <th>Departamento</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($comensales)): ?>
                <?php foreach ($comensales as $c): ?>
                    <tr>
                        <td><?= htmlspecialchars($c['Cedula_Comensal']) ?></td>
                        <td><?= htmlspecialchars($c['PrimerNombre'] . ' ' . $c['SegundoNombre']) ?></td>
                        <td><?= htmlspecialchars($c['PrimerApellido'] . ' ' . $c['SegundoApellido']) ?></td>
                        <td><?= htmlspecialchars($c['Genero']) ?></td>
                        <td><?= htmlspecialchars($c['TipoComensal']) ?></td>
                        <td><?= htmlspecialchars($c['Nucleo']) ?></td>
                        <td><?= htmlspecialchars($c['Departamento']) ?></td>
                        <td>
                            <button class="btn btn-sm btn-primary btnEditar" data-id="<?= $c['Cedula_Comensal'] ?>"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm btn-danger btnEliminar" data-id="<?= $c['Cedula_Comensal'] ?>"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</div></section>
<!-- Modal Registro -->
<div class="modal fade" id="modalComensal" tabindex="-1" aria-labelledby="modalComensalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="formComensal">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Registrar Comensal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Cédula</label>
                        <input type="text" name="cedula" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Primer Nombre</label>
                        <input type="text" name="pnom" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Segundo Nombre</label>
                        <input type="text" name="snom" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Primer Apellido</label>
                        <input type="text" name="pape" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Segundo Apellido</label>
                        <input type="text" name="sape" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Género</label>
                        <select name="genero" class="form-select" required>
                            <option value="" selected disabled>-- Seleccione --</option>
                            <option value="M">Masculino</option>
                            <option value="F">Femenino</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tipo de Comensal</label>
                        <select name="Codigo_TipoComensal" class="form-select" required>
                            <option value="" selected disabled>-- Seleccione --</option>
                            <?php foreach ($tipos_comensales as $tipo): ?>
                                <option value="<?= htmlspecialchars($tipo['id']) ?>"><?= htmlspecialchars($tipo['Nombre']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Núcleo</label>
                        <select name="Codigo_Nucleo" class="form-select" required>
                            <option value="" selected disabled>-- Seleccione --</option>
                            <?php foreach ($nucleos as $n): ?>
                                <option value="<?= htmlspecialchars($n['id']) ?>"><?= htmlspecialchars($n['Nombre']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Departamento</label>
                        <select name="Codigo_Departamento" class="form-select" required>
                            <option value="" selected disabled>-- Seleccione --</option>
                            <?php foreach ($departamentos as $d): ?>
                                <option value="<?= htmlspecialchars($d['id']) ?>"><?= htmlspecialchars($d['Nombre']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="assets/js/comensales.js"></script>