document.addEventListener('DOMContentLoaded', () => {
  const modalCrear = new bootstrap.Modal(document.getElementById('modalCrearMenu'));
  const modalEditar = new bootstrap.Modal(document.getElementById('modalEditarMenu'));

  // CREAR MENÚ
  document.getElementById('formCrearMenu').addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);

    try {
      const res = await fetch('app/controllers/menucontroller.php?action=create', {
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
      Swal.fire('Error', 'Error en la petición', 'error');
    }
  });

  // EDITAR MENÚ
  document.querySelectorAll('.btnEditarMenu').forEach(btn => {
    btn.addEventListener('click', async () => {
      const id = btn.dataset.id;

      try {
        const res = await fetch(`app/controllers/menucontroller.php?action=edit&id=${id}`);
        const html = await res.text();

        const contenedor = document.querySelector('#modalEditarMenu .modal-content');
        contenedor.innerHTML = html;
        modalEditar.show();

        const form = contenedor.querySelector('form');
        form.addEventListener('submit', async (e) => {
          e.preventDefault();
          const formData = new FormData(form);
          try {
            const res = await fetch(form.action, {
              method: 'POST',
              body: formData
            });
            const data = await res.json();
            Swal.fire(data.success ? 'Éxito' : 'Error', data.message, data.success ? 'success' : 'error');
            if (data.success) {
              modalEditar.hide();
              setTimeout(() => location.reload(), 1000);
            }
          } catch (err) {
            Swal.fire('Error', 'Error al enviar los datos', 'error');
          }
        });
      } catch (err) {
        Swal.fire('Error', 'No se pudo cargar el formulario de edición', 'error');
      }
    });
  });

  // ELIMINAR MENÚ
  document.querySelectorAll('.btnEliminarMenu').forEach(btn => {
    btn.addEventListener('click', () => {
      const id = btn.dataset.id;
      Swal.fire({
        title: '¿Eliminar menú?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí',
        cancelButtonText: 'Cancelar'
      }).then(async result => {
        if (result.isConfirmed) {
          try {
            const res = await fetch(`app/controllers/menucontroller.php?action=delete&id=${id}`, {
              method: 'POST'
            });
            const data = await res.json();
            Swal.fire(data.success ? 'Eliminado' : 'Error', data.message, data.success ? 'success' : 'error');
            if (data.success) setTimeout(() => location.reload(), 1000);
          } catch (err) {
            Swal.fire('Error', 'Error al eliminar el menú', 'error');
          }
        }
      });
    });
  });
});
$(document).ready(function () {
  $('#tablaMenus').DataTable({
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
