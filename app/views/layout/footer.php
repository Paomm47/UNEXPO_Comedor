        </div> <!-- .row -->
    </div> <!-- .container-fluid -->

    </main>

    <!-- SCRIPTS GENERALES -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- TOGGLE SIDEBAR -->
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const sidebar = document.getElementById("sidebar");
        const toggleBtn = document.getElementById("btnToggleSidebar");

        if (sessionStorage.getItem("sidebarCollapsed") === "true") {
            sidebar.classList.add("collapsed");
        }

        toggleBtn?.addEventListener("click", function () {
            sidebar.classList.toggle("collapsed");
            sessionStorage.setItem("sidebarCollapsed", sidebar.classList.contains("collapsed"));
        });
    });
    </script>

    <!-- LOGOUT -->
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const logoutBtn = document.getElementById('logoutBtn');
        if (logoutBtn) {
            logoutBtn.addEventListener('click', function (e) {
                e.preventDefault();

                Swal.fire({
                    title: '¿Deseas cerrar sesión?',
                    text: 'Tu sesión se cerrará y volverás al inicio de sesión.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, cerrar sesión',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'index.php?view=logout';
                    }
                });
            });
        }
    });
    </script>

</body>
</html>
