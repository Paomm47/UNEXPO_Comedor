<form id="formTicket" action="app/controllers/ticketcontroller.php?action=edit&id=<?= $ticket['Id_Ticket'] ?>" method="post">
    <div class="modal-header">
        <h5 class="modal-title">Editar Ticket</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
    </div>

    <div class="modal-body">
        <input type="hidden" name="id" value="<?= $ticket['Id_Ticket'] ?>">

        <div class="mb-3">
            <label for="tipocomensal" class="form-label">Tipo de Comensal</label>
            <select name="tipocomensal" id="tipocomensal" class="form-select" required>
                <option value="" disabled>-- Seleccione un tipo --</option>
                <?php foreach ($tipos as $tipo): ?>
                    <option value="<?= htmlspecialchars($tipo['id']) ?>" <?= $ticket['Codigo_Tipocomensal'] == $tipo['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($tipo['Nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="menu" class="form-label">Menú</label>
            <select name="menu" id="menu" class="form-select" required>
                <option value="" disabled>-- Seleccione un menú --</option>
                <?php foreach ($menus as $m): ?>
                    <option value="<?= htmlspecialchars($m['Id_Menu']) ?>" <?= $ticket['Id_Menu'] == $m['Id_Menu'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($m['Nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-success">Guardar cambios</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
    </div>
</form>
