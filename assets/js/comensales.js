
document.addEventListener('DOMContentLoaded', () => {
    const tabla = new DataTable('#tablaComensales');

    document.getElementById('formComensal').addEventListener('submit', async function (e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);

        try {
            const res = await fetch('index.php?view=comensal&action=create', {
                method: 'POST',
                body: formData
            });

            const data = await res.json();
            if (data.success) {
                Swal.fire('Éxito', data.message, 'success');
                form.reset();
                const modal = bootstrap.Modal.getInstance(document.getElementById('modalComensal'));
                modal.hide();
                setTimeout(() => location.reload(), 1000);
            } else {
                Swal.fire('Error', data.message, 'error');
            }
        } catch (error) {
            console.error('Error al guardar comensal:', error);
            Swal.fire('Error', 'No se pudo registrar el comensal.', 'error');
        }
    });

    document.querySelectorAll('.btnEliminar').forEach(btn => {
        btn.addEventListener('click', async () => {
            const id = btn.dataset.id;
            const confirm = await Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción no se puede deshacer",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            });

            if (confirm.isConfirmed) {
                const res = await fetch(`index.php?view=comensal&action=delete&id=${id}`);
                const data = await res.json();
                if (data.success) {
                    Swal.fire('Eliminado', data.message, 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            }
        });
    });

    document.querySelectorAll('.btnEditar').forEach(btn => {
        btn.addEventListener('click', async () => {
            const id = btn.dataset.id;
            window.location.href = `index.php?view=comensal&action=edit&id=${id}`;
        });
    });
});