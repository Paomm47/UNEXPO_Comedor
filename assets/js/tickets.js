document.addEventListener('DOMContentLoaded', () => {
  const modalCrear = new bootstrap.Modal(document.getElementById('modalCrearTicket'));
  const modalEditar = new bootstrap.Modal(document.getElementById('modalEditarTicket'));

  // Crear Ticket
  const formCrear = document.getElementById('formCrearTicket');
  if (formCrear) {
    formCrear.addEventListener('submit', async (e) => {
      e.preventDefault();
      const formData = new FormData(formCrear);

      try {
        const res = await fetch('app/controllers/ticketcontroller.php?action=create', {
          method: 'POST',
          body: formData
        });
        const data = await res.json();

        Swal.fire(
          data.success ? 'Éxito' : 'Error',
          data.message,
          data.success ? 'success' : 'error'
        );

        if (data.success) {
          modalCrear.hide();
          setTimeout(() => location.reload(), 1000);
        }
      } catch (error) {
        Swal.fire('Error', 'Error en la petición al servidor', 'error');
      }
    });
  }

  // Editar Ticket - Abrir modal y cargar formulario dinámico
  document.querySelectorAll('.btnEditarTicket').forEach(btn => {
    btn.addEventListener('click', async () => {
      const id = btn.dataset.id;

      try {
        const res = await fetch(`app/controllers/ticketcontroller.php?action=edit&id=${encodeURIComponent(id)}`);
        const html = await res.text();

        const contenedor = document.querySelector('#modalEditarTicket .modal-content');
        if (!contenedor) {
          return Swal.fire('Error', 'No se encontró el contenedor del modal', 'error');
        }

        contenedor.innerHTML = html;
        modalEditar.show();

        // Escuchar submit del form de edición dentro del modal
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

              Swal.fire(
                data.success ? 'Actualizado' : 'Error',
                data.message,
                data.success ? 'success' : 'error'
              );

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

  // Eliminar Ticket
  document.querySelectorAll('.btnEliminarTicket').forEach(btn => {
    btn.addEventListener('click', () => {
      const id = btn.dataset.id;

      Swal.fire({
        title: '¿Eliminar ticket?',
        text: 'Esta acción eliminará el ticket permanentemente.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6'
      }).then(async result => {
        if (result.isConfirmed) {
          try {
            const res = await fetch(`app/controllers/ticketcontroller.php?action=delete&id=${encodeURIComponent(id)}`, {
              method: 'POST'
            });
            const data = await res.json();

            Swal.fire(
              data.success ? 'Eliminado' : 'Error',
              data.message,
              data.success ? 'success' : 'error'
            );

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

  $(document).ready(function () {
    $('#tablaTickets').DataTable({
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


});

