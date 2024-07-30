<?php
include '../includes/header_admin.php';
include '../logic/dashboardLogic.php';

$estadisticasUsuarios = obtenerEstadisticasUsuarios();
$estadisticasPostulaciones = obtenerEstadisticasPostulaciones();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<main>
    <h2>Dashboard</h2>
    <p>Bienvenido al panel de administración. Aquí puedes ver estadísticas y administrar el sistema.</p>

    <div class="charts-container">
        <div class="chart-wrapper">
            <h3>Usuarios (Torta)</h3>
            <canvas id="usuariosPieChart"></canvas>
        </div>
        <div class="chart-wrapper">
            <h3>Postulaciones (Torta)</h3>
            <canvas id="postulacionesPieChart"></canvas>
        </div>
        <div class="chart-wrapper">
            <h3>Usuarios (Barras)</h3>
            <canvas id="usuariosBarChart"></canvas>
        </div>
        <div class="chart-wrapper">
            <h3>Postulaciones (Barras)</h3>
            <canvas id="postulacionesBarChart"></canvas>
        </div>
    </div>
</main>

<script>
const usuariosData = <?php echo json_encode($estadisticasUsuarios); ?>;
const postulacionesData = <?php echo json_encode($estadisticasPostulaciones); ?>;

const usuariosPieChartCtx = document.getElementById('usuariosPieChart').getContext('2d');
const postulacionesPieChartCtx = document.getElementById('postulacionesPieChart').getContext('2d');
const usuariosBarChartCtx = document.getElementById('usuariosBarChart').getContext('2d');
const postulacionesBarChartCtx = document.getElementById('postulacionesBarChart').getContext('2d');

new Chart(usuariosPieChartCtx, {
    type: 'pie',
    data: {
        labels: Object.keys(usuariosData),
        datasets: [{
            data: Object.values(usuariosData),
            backgroundColor: ['#007bff', '#28a745']
        }]
    }
});

new Chart(postulacionesPieChartCtx, {
    type: 'pie',
    data: {
        labels: Object.keys(postulacionesData),
        datasets: [{
            data: Object.values(postulacionesData),
            backgroundColor: ['#6c757d', '#28a745', '#dc3545']
        }]
    }
});

new Chart(usuariosBarChartCtx, {
    type: 'bar',
    data: {
        labels: Object.keys(usuariosData),
        datasets: [{
            label: 'Usuarios',
            data: Object.values(usuariosData),
            backgroundColor: ['#007bff', '#28a745']
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

new Chart(postulacionesBarChartCtx, {
    type: 'bar',
    data: {
        labels: Object.keys(postulacionesData),
        datasets: [{
            label: 'Postulaciones',
            data: Object.values(postulacionesData),
            backgroundColor: ['#6c757d', '#28a745', '#dc3545']
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
</body>
</html>

<?php include '../includes/footer.php'; ?>
