document.addEventListener('DOMContentLoaded', () => {
  // 1. INICIALIZACIÓN DE ELEMENTOS
  const modalCrearEl = document.getElementById('modalCrearProveedor');
  const modalCrear = new bootstrap.Modal(modalCrearEl);
  const modalEditarEl = document.getElementById('modalEditarProveedor');
  const modalEditar = new bootstrap.Modal(modalEditarEl);

  // ***************************************************************
  // ESTA ES LA ÚNICA Y CORRECTA INICIALIZACIÓN DE DATATABLES CON AJAX
  // ***************************************************************
  const tablaProveedores = $('#tablaProveedores').DataTable({
      "destroy": true, // Permite que DataTables sea reinicializado si se carga dinámicamente (útil en SPA)
      "ajax": {
          "url": "index.php?view=proveedor&action=get_all", // Asegúrate que esta URL sea accesible desde el navegador
          "dataSrc": "data" // La clave dentro del JSON que contiene el array de tus datos (ej. { "data": [...] })
      },
      "columns": [
          { "data": "Rif_Proveedor" },
          { "data": "Nombre" },
          { "data": "Correo" },
          { "data": "Telefono" },
          { "data": "Acciones", "orderable": false, "searchable": false } // Columna para los botones de acción
      ],
      "language": {
          "url": "//cdn.datatables.net/plug-ins/2.0.8/i18n/es-ES.json" // URL del archivo de idioma para DataTables
      },
      "responsive": true,
      "autoWidth": false
  });

  // 2. CREAR NUEVO PROVEEDOR
  const formCrear = document.getElementById('formCrearProveedor');
  formCrear.addEventListener('submit', async (e) => {
      e.preventDefault();
      const formData = new FormData(formCrear);

      try {
          const res = await fetch('index.php?view=proveedor&action=create', {
              method: 'POST',
              body: formData
          });
          // Intenta parsear la respuesta como JSON
          const data = await res.json();

          if (data.success) {
              modalCrear.hide();
              Swal.fire({
                  icon: 'success',
                  title: 'Éxito',
                  text: data.message,
              });
              tablaProveedores.ajax.reload(); // Recargar la tabla para mostrar el nuevo proveedor
              formCrear.reset(); // Limpiar el formulario después de guardar
          } else {
              Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: data.message
              });
          }
      } catch (error) {
          Swal.fire('Error', 'No se pudo conectar con el servidor o la respuesta no fue JSON válida al crear el proveedor.', 'error');
          console.error("Error al crear proveedor:", error); // Muestra el error en la consola del navegador
      }
  });

  // 3. DELEGACIÓN DE EVENTOS PARA BOTONES DE ACCIÓN EN LA TABLA (Editar y Eliminar)
  const tbody = document.querySelector('#tablaProveedores tbody');

  tbody.addEventListener('click', async (e) => {
      // Botón EDITAR
      if (e.target.closest('.btnEditarProveedor')) {
          const btn = e.target.closest('.btnEditarProveedor');
          const rif = btn.dataset.id;
          const modalContent = document.getElementById('modalContentEditar');

          try {
              // Solicita el HTML del formulario de edición al servidor
              const res = await fetch(`index.php?view=proveedor&action=edit&id=${encodeURIComponent(rif)}`);
              if (!res.ok) {
                  throw new Error(`Error HTTP: ${res.status} - No se pudo cargar el formulario de edición.`);
              }

              modalContent.innerHTML = await res.text(); // Inserta el HTML en el modal
              modalEditar.show(); // Abre el modal

              // Adjunta el event listener para el formulario de edición, asegurándose de que sea uno solo
              const formEditar = document.getElementById('formEditarProveedor');
              // IMPORTANTE: Remover el listener previo para evitar que se adjunten múltiples
              formEditar.removeEventListener('submit', handleUpdateSubmit);
              formEditar.addEventListener('submit', handleUpdateSubmit);
          } catch (error) {
              Swal.fire('Error', error.message, 'error');
              console.error("Error al cargar formulario de edición:", error);
          }
      }

      // Botón ELIMINAR
      if (e.target.closest('.btnEliminarProveedor')) {
          const btn = e.target.closest('.btnEliminarProveedor');
          const rif = btn.dataset.id;

          Swal.fire({
              title: '¿Está seguro?',
              text: "Esta acción desactivará al proveedor. ¡No podrá revertirse fácilmente!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#d33',
              cancelButtonColor: '#3085d6',
              confirmButtonText: 'Sí, eliminar',
              cancelButtonText: 'Cancelar'
          }).then(async (result) => {
              if (result.isConfirmed) {
                  try {
                      const formData = new FormData();
                      formData.append('id', rif);

                      const res = await fetch('index.php?view=proveedor&action=delete', {
                          method: 'POST',
                          body: formData
                      });
                      const data = await res.json(); // Espera una respuesta JSON

                      Swal.fire({
                          icon: data.success ? 'success' : 'error',
                          title: data.success ? 'Eliminado' : 'Error',
                          text: data.message
                      });

                      if (data.success) {
                          tablaProveedores.ajax.reload(); // Recargar la tabla después de eliminar
                      }
                  } catch (error) {
                      Swal.fire('Error', 'No se pudo conectar con el servidor o la respuesta no fue JSON válida al eliminar.', 'error');
                      console.error("Error al eliminar proveedor:", error);
                  }
              }
          });
      }
  });

  // 4. FUNCIÓN PARA MANEJAR LA ACTUALIZACIÓN (llamada por el submit del formulario de edición)
  async function handleUpdateSubmit(e) {
      e.preventDefault();
      const formData = new FormData(e.target);

      try {
          const res = await fetch('index.php?view=proveedor&action=edit', {
              method: 'POST',
              body: formData
          });
          const data = await res.json(); // Espera una respuesta JSON

          if (data.success) {
              modalEditar.hide();
              Swal.fire({
                  icon: 'success',
                  title: 'Actualizado',
                  text: data.message
              });
              tablaProveedores.ajax.reload(); // Recargar la tabla
          } else {
              Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: data.message
              });
          }
      } catch (error) {
          Swal.fire('Error', 'No se pudo conectar con el servidor para actualizar el proveedor.', 'error');
          console.error("Error al actualizar proveedor:", error);
      }
  }
});
