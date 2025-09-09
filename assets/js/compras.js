document.addEventListener('DOMContentLoaded', () => {
    // Cargar proveedores, productos, empaques, marcas para el modal crear y editar
    let proveedores = [];
    let productos = [];
    let empaques = [];
    let marcas = [];

    
    function cargarListas() {
    }

    // Ejemplo de función para crear opciones HTML para un select
    function crearOpciones(array) {
        return array.map(item => `<option value="${item.id || item.Codigo_Producto || item.Rif_Proveedor}">${item.Nombre}</option>`).join('');
    }

    // Agregar fila detalle en modal crear
    const tablaDetalles = document.querySelector('#tablaDetallesCompra tbody');
    const btnAgregarDetalle = document.querySelector('#btnAgregarDetalle');

    btnAgregarDetalle?.addEventListener('click', () => {
        const index = tablaDetalles.children.length;
        const fila = document.createElement('tr');

        fila.innerHTML = `
            <td><select name="detalles[${index}][producto]" class="form-select" required>${crearOpciones(productos)}</select></td>
            <td><input type="number" step="0.01" name="detalles[${index}][precio]" class="form-control" required></td>
            <td><select name="detalles[${index}][empaque]" class="form-select" required>${crearOpciones(empaques)}</select></td>
            <td><input type="number" step="0.01" name="detalles[${index}][peso]" class="form-control" required></td>
            <td><input type="number" name="detalles[${index}][cantidad]" class="form-control" required></td>
            <td><select name="detalles[${index}][marca]" class="form-select" required>${crearOpciones(marcas)}</select></td>
            <td><button type="button" class="btn btn-danger btnEliminarFilaDetalle">-</button></td>
        `;
        tablaDetalles.appendChild(fila);
    });

    // Manejar eliminación fila detalle
    document.body.addEventListener('click', e => {
        if (e.target.classList.contains('btnEliminarFilaDetalle')) {
            e.target.closest('tr').remove();
        }
    });

    // Editar compra (abrir modal y cargar contenido)
    const tablaCompras = document.querySelector('#tablaCompras');
    const modalEditarCompra = new bootstrap.Modal(document.getElementById('modalEditarCompra'));

    tablaCompras?.addEventListener('click', e => {
        if (e.target.closest('.btnEditarCompra')) {
            const id = e.target.closest('.btnEditarCompra').dataset.id;

            fetch(`app/controllers/comprascontroller.php?action=edit&id=${id}`)
                .then(res => res.text())
                .then(html => {
                    document.querySelector('#modalEditarCompra .modal-content').innerHTML = html;
                    modalEditarCompra.show();
                    agregarEventosFormEditar();
                });
        }
    });

    // Guardar compra (crear)
    document.querySelector('#formCrearCompra')?.addEventListener('submit', e => {
        e.preventDefault();
        const formData = new FormData(e.target);

        fetch('app/controllers/comprascontroller.php?action=create', {
            method: 'POST',
            body: formData
        })
        .then(r => r.json())
        .then(res => {
            alert(res.message);
            if (res.success) {
                location.reload();
            }
        })
        .catch(() => alert('Error al crear compra'));
    });

    // Guardar compra (editar)
    function agregarEventosFormEditar() {
        const formEditar = document.querySelector('#formEditarCompra');
        if (!formEditar) return;

        formEditar.addEventListener('submit', e => {
            e.preventDefault();
            const formData = new FormData(formEditar);

            fetch(formEditar.action, {
                method: 'POST',
                body: formData
            })
            .then(r => r.json())
            .then(res => {
                alert(res.message);
                if (res.success) {
                    location.reload();
                }
            })
            .catch(() => alert('Error al actualizar compra'));
        });

        // Agregar botón para añadir detalles en edición
        document.querySelector('#btnAgregarDetalleEditar')?.addEventListener('click', () => {
            const tbody = document.querySelector('#tablaDetallesEditar tbody');
            const index = tbody.children.length;
            const fila = document.createElement('tr');

            fila.innerHTML = `
                <td><select name="detalles[${index}][producto]" class="form-select" required>${crearOpciones(productos)}</select></td>
                <td><input type="number" step="0.01" name="detalles[${index}][precio]" class="form-control" required></td>
                <td><select name="detalles[${index}][empaque]" class="form-select" required>${crearOpciones(empaques)}</select></td>
                <td><input type="number" step="0.01" name="detalles[${index}][peso]" class="form-control" required></td>
                <td><input type="number" name="detalles[${index}][cantidad]" class="form-control" required></td>
                <td><select name="detalles[${index}][marca]" class="form-select" required>${crearOpciones(marcas)}</select></td>
                <td><button type="button" class="btn btn-danger btnEliminarFilaDetalle">-</button></td>
            `;
            tbody.appendChild(fila);
        });
    }

    // Cargar listas iniciales (proveedores, productos, empaques, marcas)
    cargarListas();

    // Eliminar compra
    tablaCompras?.addEventListener('click', e => {
        if (e.target.closest('.btnEliminarCompra')) {
            const id = e.target.closest('.btnEliminarCompra').dataset.id;
            if (confirm('¿Seguro que deseas eliminar esta compra?')) {
                fetch(`app/controllers/comprascontroller.php?action=delete&id=${id}`)
                    .then(r => r.json())
                    .then(res => {
                        alert(res.message);
                        if (res.success) location.reload();
                    });
            }
        }
    });
});
$(document).ready(function () {
    $('#tablaCompras').DataTable({
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
