document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('formLogin');
    const inputCedula = document.getElementById('cedula');
    const inputPass = document.getElementById('password');
    const mostrarPass = document.getElementById('mostrarPassword');

    mostrarPass.addEventListener('change', () => {
        inputPass.type = mostrarPass.checked ? 'text' : 'password';
    });

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const cedula = inputCedula.value.trim();
        const password = inputPass.value.trim();

        if (!cedula || !password) {
            Swal.fire({ icon: 'warning', title: 'Campos vacíos', text: 'Por favor, complete todos los campos.' });
            return;
        }

        try {
            const response = await fetch('index.php?view=login', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: new FormData(form)
            });

            const text = await response.text();
            let data;

            try {
                data = JSON.parse(text);
            } catch (e) {
                console.error('Respuesta inválida:', text);
                Swal.fire({ icon: 'error', title: 'Error', text: 'El servidor respondió con datos no válidos.' });
                return;
            }

            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Bienvenido',
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = 'index.php?view=home';
                });
            } else {
                Swal.fire({ icon: 'error', title: 'Error', text: data.message });
            }
        } catch (error) {
            console.error('Error en login:', error);
            Swal.fire({ icon: 'error', title: 'Error de conexión', text: 'No se pudo conectar con el servidor.' });
        }
    });
});
