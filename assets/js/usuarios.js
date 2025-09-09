document.addEventListener('DOMContentLoaded', () => {
  const modalCrear = new bootstrap.Modal(document.getElementById('modalCrearUsuario'));
  const modalEditar = new bootstrap.Modal(document.getElementById('modalEditarUsuario'));

  // Crear Usuario
  document.getElementById('formCrearUsuario').addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);

    try {
      const res = await fetch('app/controllers/usuariocontroller.php?action=create', {
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

  // Editar Usuario
  document.querySelectorAll('.btnEditarUsuario').forEach(btn => {
    btn.addEventListener('click', async () => {
      const id = btn.dataset.id;

      try {
        const res = await fetch(`app/controllers/usuariocontroller.php?action=edit&id=${id}`);
        const html = await res.text();

        const contenedor = document.querySelector('#modalEditarUsuario .modal-content');
        if (!contenedor) {
          return Swal.fire('Error', 'No se encontró el contenedor del modal', 'error');
        }

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
              Swal.fire(data.success ? 'Éxito' : 'Error', data.message, data.success ? 'success' : 'error');
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

  // Eliminar Usuario
  document.querySelectorAll('.btnEliminarUsuario').forEach(btn => {
    btn.addEventListener('click', () => {
      const id = btn.dataset.id;
      Swal.fire({
        title: '¿Eliminar usuario?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí',
        cancelButtonText: 'Cancelar'
      }).then(async result => {
        if (result.isConfirmed) {
          try {
            const res = await fetch(`app/controllers/usuariocontroller.php?action=delete&id=${id}`, {
              method: 'POST'
            });
            const data = await res.json();
            Swal.fire(data.success ? 'Eliminado' : 'Error', data.message, data.success ? 'success' : 'error');
            if (data.success) setTimeout(() => location.reload(), 1000);
          } catch (err) {
            Swal.fire('Error', 'Error en la petición de eliminación', 'error');
          }
        }
      });
    });
  });

  // DataTables - inicializar después de que el DOM está listo
  $('#tablaUsuarios').DataTable({
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
