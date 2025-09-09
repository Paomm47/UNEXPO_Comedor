document.addEventListener('DOMContentLoaded', () => {
  const modalCrear = new bootstrap.Modal(document.getElementById('modalCrearProducto'));
  const modalEditar = new bootstrap.Modal(document.getElementById('modalEditarProducto'));

  const formCrear = document.getElementById('formCrearProducto');
  if (formCrear) {
    formCrear.addEventListener('submit', async (e) => {
      e.preventDefault();
      const formData = new FormData(formCrear);

      try {
        const res = await fetch('app/controllers/inventariocontroller.php?action=create', {
          method: 'POST',
          body: formData
        });
        const data = await res.json();

        Swal.fire(data.success ? 'Éxito' : 'Error', data.message, data.success ? 'success' : 'error');
        if (data.success) {
          modalCrear.hide();
          setTimeout(() => location.reload(), 1000);
        }
      } catch (error) {
        Swal.fire('Error', 'Error en la petición al servidor', 'error');
      }
    });
  }

  document.querySelectorAll('.btnEditarProducto').forEach(btn => {
    btn.addEventListener('click', async () => {
      const id = btn.dataset.id;
      try {
        const res = await fetch(`app/controllers/inventariocontroller.php?action=edit&id=${encodeURIComponent(id)}`);
        const html = await res.text();
        const contenedor = document.querySelector('#modalEditarProducto .modal-content');
        contenedor.innerHTML = html;
        modalEditar.show();

        const form = contenedor.querySelector('form');
        if (form) {
          form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(form);
            try {
              const res = await fetch(form.action, {
                method: 'POST',
                body: formData
              });
              const data = await res.json();
              Swal.fire(data.success ? 'Actualizado' : 'Error', data.message, data.success ? 'success' : 'error');
              if (data.success) {
                modalEditar.hide();
                setTimeout(() => location.reload(), 1000);
              }
            } catch (err) {
              Swal.fire('Error', 'Error al enviar los datos', 'error');
            }
          });
        }
      } catch (err) {
        Swal.fire('Error', 'No se pudo cargar el formulario de edición', 'error');
      }
    });
  });

  document.querySelectorAll('.btnEliminarProducto').forEach(btn => {
    btn.addEventListener('click', () => {
      const id = btn.dataset.id;
      Swal.fire({
        title: '¿Eliminar producto?',
        text: 'Esta acción desactivará el producto.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6'
      }).then(async result => {
        if (result.isConfirmed) {
          try {
            const res = await fetch(`app/controllers/inventariocontroller.php?action=delete&id=${encodeURIComponent(id)}`, {
              method: 'POST'
            });
            const data = await res.json();
            Swal.fire(data.success ? 'Eliminado' : 'Error', data.message, data.success ? 'success' : 'error');
            if (data.success) {
              setTimeout(() => location.reload(), 1000);
            }
          } catch (err) {
            Swal.fire('Error', 'Error en la petición de eliminación', 'error');
          }
        }
      });
    });
  });

  const tabla = document.querySelector('#tablaInventario');
  if (tabla) {
    new DataTable(tabla, {
      language: {
        url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
      }
    });
  }
});
$(document).ready(function () {
  $('#tablaInventario').DataTable({
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
