<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
 <div class="fondo-difuminado"></div>
 <section>
<div id="caja-central" style="color: black;">
<div class="container-fluid px-3">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
        <h4 class="mb-0">Gestión de Proveedores</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearProveedor">
            <i class="bi bi-plus-circle"></i> Nuevo Proveedor
        </button>
    </div>
    <div class="container-table">
        <table id="tablaProveedores" class="table dataTable table-bordered table-hover align-middle">
            <thead>
                <tr>
                    <th>RIF</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th class="text-nowrap">Acciones</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php if (!empty($proveedores)): ?>
                    <?php foreach ($proveedores as $prov): ?>
                        <tr>
                            <td><?= htmlspecialchars($prov['Rif_Proveedor']) ?></td>
                            <td><?= htmlspecialchars($prov['Nombre']) ?></td>
                            <td><?= htmlspecialchars($prov['Correo']) ?></td>
                            <td><?= htmlspecialchars($prov['Telefono']) ?></td>
                            <td>
                                <button class="btn btn-sm btn-warning btnEditarProveedor" data-id="<?= $prov['Rif_Proveedor'] ?>">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button class="btn btn-sm btn-danger btnEliminarProveedor" data-id="<?= $prov['Rif_Proveedor'] ?>">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5">No hay proveedores registrados.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div></div>
</section>

 <div class="modal fade" id="modalCrearProveedor" tabindex="-1" style="color: black;">
     <div class="modal-dialog">
         <form id="formCrearProveedor" class="modal-content" >
             <div class="modal-header">
                 <h5 class="modal-title">Agregar Proveedor</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
             </div>
             <div class="modal-body row g-2" style="color: black;">
                 <div class="col-md-6"> 
                     <label for="crear_rif" class="form-label">RIF</label>
                     <input type="text" id="crear_rif" name="rif" class="form-control" required>
                 </div>
                 <div class="col-md-6">
                     <label for="crear_nombre" class="form-label">Nombre</label>
                     <input type="text" id="crear_nombre" name="nombre" class="form-control" required>
                 </div>
                 <div class="col-md-6">
                     <label for="crear_correo" class="form-label">Correo</label>
                     <input type="email" id="crear_correo" name="correo" class="form-control" required>
                 </div>
                 <div class="col-md-6">
                     <label for="crear_telefono" class="form-label">Teléfono</label>
                     <input type="text" id="crear_telefono" name="telefono" class="form-control" required>
                 </div>
             </div>
             <div class="modal-footer">
                 <button type="submit" class="btn btn-primary">Guardar</button>
                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
             </div>
         </form>
     </div>
 </div>

 <div class="modal fade" id="modalEditarProveedor" tabindex="-1">
     <div class="modal-dialog">
         <div id="modalContentEditar" class="modal-content">
             </div>
     </div>
 </div>

 <script src="assets/js/proveedores.js"></script>