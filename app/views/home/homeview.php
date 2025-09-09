<section class="contenido-home">

    <div class="container mt-4">
        <h1 class="mb-4 text-center">Panel Principal</h1>

        <div class="row">
            <!-- Total Usuarios -->
            <div class="col-md-6 mb-3">
                <div class="card text-white bg-primary shadow rounded-3">
                    <div class="card-body">
                        <h5 class="card-title">Total de Usuarios Activos</h5>
                        <p class="card-text text-white fs-2"><?= htmlspecialchars($totalUsuarios) ?></p>
                    </div>
                </div>
            </div>

            <!-- Tickets Totales -->
            <div class="col-md-6 mb-3">
                <div class="card text-white bg-success shadow rounded-3">
                    <div class="card-body">
                        <h5 class="card-title">Tickets Registrados</h5>
                        <p class="card-text text-white fs-2"><?= htmlspecialchars($ticketsHoy) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="assets/js/home.js"></script>
