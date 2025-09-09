<form id="formEditarReceta" autocomplete="off">
  <div class="modal-header">
    <h5 class="modal-title">Editar Receta</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
  </div>
  <div class="modal-body">
    <input type="hidden" name="id" value="<?= htmlspecialchars($receta['Id_Receta']) ?>">
    <div class="mb-3">
      <label for="nombreEditar" class="form-label">Nombre</label>
      <input type="text" name="nombre" id="nombreEditar" class="form-control" value="<?= htmlspecialchars($receta['Nombre']) ?>" required>
    </div>

    <label>Ingredientes</label>
    <table class="table" id="tablaIngredientesEditar">
      <thead>
        <tr>
          <th>Producto</th>
          <th>Peso Detallado</th>
          <th>Unidad</th>
          <th></th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
    <button type="button" class="btn btn-success btn-sm" id="btnAgregarIngredienteEditar">Agregar Ingrediente</button>
  </div>
  <div class="modal-footer">
    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
  </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', () => {
  recetasJS.init({
    productos: <?= json_encode($productos) ?>,
    unidades: <?= json_encode($unidades) ?>,
    ingredientes: <?= json_encode($receta['ingredientes'] ?? []) ?>,
    tablaSelector: '#tablaIngredientesEditar tbody',
    btnAgregarSelector: '#btnAgregarIngredienteEditar',
    formSelector: '#formEditarReceta',
    onSubmitUrl: '?action=edit&id=<?= $receta['Id_Receta'] ?>',
    modalSelector: '#modalEditarReceta'
  });
});
</script>
