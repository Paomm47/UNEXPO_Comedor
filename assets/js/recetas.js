// assets/js/recetas.js

const recetasJS = (() => {
  let productos = [];
  let unidades = [];
  let tabla;
  let btnAgregar;
  let form;
  let onSubmitUrl;
  let modal;

  function crearFila(index, ing = {}) {
    const tr = document.createElement('tr');

    tr.innerHTML = `
      <td>
        <select name="ingredientes[${index}][producto]" class="form-select" required>
          <option value="">Seleccione producto</option>
          ${productos.map(p => `<option value="${p.id}" ${p.id == (ing.producto || '') ? 'selected' : ''}>${p.Nombre}</option>`).join('')}
        </select>
      </td>
      <td><input type="number" min="0" step="0.01" name="ingredientes[${index}][peso]" class="form-control" value="${ing.peso || ''}" required></td>
      <td>
        <select name="ingredientes[${index}][unidad]" class="form-select" required>
          <option value="">Seleccione unidad</option>
          ${unidades.map(u => `<option value="${u.id}" ${u.id == (ing.unidad || '') ? 'selected' : ''}>${u.UnidadMasa}</option>`).join('')}
        </select>
      </td>
      <td><button type="button" class="btn btn-danger btnEliminarIngrediente">X</button></td>
    `;

    tr.querySelector('.btnEliminarIngrediente').addEventListener('click', () => {
      tr.remove();
      reindexar();
    });

    return tr;
  }

  function reindexar() {
    Array.from(tabla.children).forEach((row, i) => {
      row.querySelectorAll('select, input').forEach(input => {
        input.name = input.name.replace(/\[\d+\]/, `[${i}]`);
      });
    });
  }

  function agregarFila(ing = {}) {
    const index = tabla.children.length;
    const fila = crearFila(index, ing);
    tabla.appendChild(fila);
  }

  function enviarFormulario(e) {
    e.preventDefault();

    const formData = new FormData(form);

    fetch(onSubmitUrl, {
      method: 'POST',
      body: formData
    })
      .then(res => res.json())
      .then(data => {
        alert(data.message);
        if (data.success) {
          if (modal) {
            bootstrap.Modal.getInstance(document.querySelector(modal)).hide();
          }
          window.location.reload();
        }
      })
      .catch(() => alert('Error en la petición.'));
  }

  function cargarEdicion(id) {
    fetch(`?action=edit&id=${id}`)
      .then(res => res.text())
      .then(html => {
        const modal = document.querySelector('#modalEditarReceta .modal-content');
        modal.innerHTML = html;
        const modalInstance = new bootstrap.Modal(document.getElementById('modalEditarReceta'));
        modalInstance.show();
      });
  }

  function eliminarReceta(id) {
    if (!confirm('¿Estás seguro de eliminar esta receta?')) return;
    fetch(`?action=delete&id=${id}`)
      .then(res => res.json())
      .then(data => {
        alert(data.message);
        if (data.success) window.location.reload();
      })
      .catch(() => alert('Error al eliminar la receta.'));
  }

  function init({ productos: prods, unidades: unis, ingredientes = [], tablaSelector, btnAgregarSelector, formSelector, onSubmitUrl: url, modalSelector }) {
    productos = prods;
    unidades = unis;
    tabla = document.querySelector(tablaSelector);
    btnAgregar = document.querySelector(btnAgregarSelector);
    form = document.querySelector(formSelector);
    onSubmitUrl = url;
    modal = modalSelector;

    tabla.innerHTML = '';
    if (ingredientes.length > 0) {
      ingredientes.forEach(ing => agregarFila({
        producto: ing.Codigo_Producto || ing.producto,
        peso: ing.PesoDetallado_Producto || ing.peso,
        unidad: ing.UnidadMasa || ing.unidad
      }));
    } else {
      agregarFila();
    }

    btnAgregar?.addEventListener('click', () => agregarFila());
    form?.addEventListener('submit', enviarFormulario);

    // botones de editar y eliminar
    document.querySelectorAll('.btnEditarReceta').forEach(btn => {
      btn.addEventListener('click', () => cargarEdicion(btn.dataset.id));
    });

    document.querySelectorAll('.btnEliminarReceta').forEach(btn => {
      btn.addEventListener('click', () => eliminarReceta(btn.dataset.id));
    });
  }

  return {
    init
  };
})

();
$(document).ready(function () {
  $('#tablaRecetas').DataTable({
      lengthMenu: [5, 10, 15, 20],
      language: {
          lengthMenu: "Mostrar _MENU_ registros",
          zeroRecords: "No se encontraron resultados",
          info: "Mostrando página _PAGE_ de _PAGES_",
          infoEmpty: "No hay registros disponibles",
          infoFiltered: "(filtrado de _MAX_ registros totales)",
          search: "Buscar:",
          paginate: {
              first: "Primero",
              last: "Último",
              next: "Siguiente",
              previous: "Anterior"
          }
      },
      responsive: true,
      ordering: true,
      autoWidth: false
  });
});
