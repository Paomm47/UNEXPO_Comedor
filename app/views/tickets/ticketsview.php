<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<div class="fondo-difuminado"></div>
<section>
<div id="caja-central" style="color: black;">
<div class="container-fluid px-3">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
        <h4 class="mb-0">Gestión de Tickets</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearTicket">
            <i class="bi bi-plus-circle"></i> Nuevo Ticket
        </button>
    </div>

    <div class="container-table">
        <table id="tablaTickets" class="table dataTable table-bordered table-hover align-middle">
            <thead>
                <tr>
                    <th>ID Ticket</th>
                    <th>Tipo Comensal</th>
                    <th>Menú</th>
                    <th class="text-nowrap">Acciones</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php if (!empty($tickets)): ?>
                    <?php foreach ($tickets as $t): ?>
                        <tr>
                            <td><?= htmlspecialchars($t['Id_Ticket']) ?></td>
                            <td><?= htmlspecialchars($t['tipo_comensal']) ?></td>
                            <td><?= htmlspecialchars($t['menu']) ?></td>
                            <td>
                                <button class="btn btn-sm btn-warning btnEditarTicket" data-id="<?= $t['Id_Ticket'] ?>">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button class="btn btn-sm btn-danger btnEliminarTicket" data-id="<?= $t['Id_Ticket'] ?>">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4">No hay tickets registrados.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</div></section>

<!-- MODAL: Crear Ticket -->
<div class="modal fade" id="modalCrearTicket" tabindex="-1" aria-labelledby="crearTicketLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form id="formCrearTicket" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Ticket</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tipocomensal" class="form-label">Tipo de Comensal</label>
                        <select name="tipocomensal" id="tipocomensal" class="form-select" required>
                            <option value="" disabled selected>-- Seleccione un tipo --</option>
                            <?php foreach ($tipos as $tipo): ?>
                                <option value="<?= htmlspecialchars($tipo['id']) ?>"><?= htmlspecialchars($tipo['Nombre']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="menu" class="form-label">Menú</label>
                        <select name="menu" id="menu" class="form-select" required>
                            <option value="" disabled selected>-- Seleccione un menú --</option>
                            <?php foreach ($menus as $m): ?>
                                <option value="<?= htmlspecialchars($m['Id_Menu']) ?>"><?= htmlspecialchars($m['Nombre']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Crear Ticket</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL: Editar Ticket -->
<div class="modal fade" id="modalEditarTicket" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <!-- Contenido cargado dinámicamente por JS -->
        </div>
    </div>
</div>

<script src="assets/js/tickets.js"></script>
