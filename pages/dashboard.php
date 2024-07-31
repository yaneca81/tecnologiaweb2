<?php
include '../includes/header_admin.php';
include '../logic/dashboardLogic.php';

$estadisticasUsuarios = obtenerEstadisticasUsuarios();
$estadisticasPostulaciones = obtenerEstadisticasPostulaciones();
$estadisticasCategorias = obtenerEstadisticasCategorias();
$estadisticasTipos = obtenerEstadisticasTipos();
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
        <div class="chart-wrapper">
            <h3>Categorías Más Postuladas (Torta)</h3>
            <canvas id="categoriasPieChart"></canvas>
        </div>
        <div class="chart-wrapper">
            <h3>Categorías Más Postuladas (Barras)</h3>
            <canvas id="categoriasBarChart"></canvas>
        </div>
        <div class="chart-wrapper">
            <h3>Tipos de Trabajo Más Postulados (Torta)</h3>
            <canvas id="tiposPieChart"></canvas>
        </div>
        <div class="chart-wrapper">
            <h3>Tipos de Trabajo Más Postulados (Barras)</h3>
            <canvas id="tiposBarChart"></canvas>
        </div>
    </div>
</main>

<script>
const usuariosData = <?php echo json_encode($estadisticasUsuarios); ?>;
const postulacionesData = <?php echo json_encode($estadisticasPostulaciones); ?>;
const categoriasData = <?php echo json_encode($estadisticasCategorias); ?>;
const tiposData = <?php echo json_encode($estadisticasTipos); ?>;

const usuariosPieChartCtx = document.getElementById('usuariosPieChart').getContext('2d');
const postulacionesPieChartCtx = document.getElementById('postulacionesPieChart').getContext('2d');
const usuariosBarChartCtx = document.getElementById('usuariosBarChart').getContext('2d');
const postulacionesBarChartCtx = document.getElementById('postulacionesBarChart').getContext('2d');
const categoriasPieChartCtx = document.getElementById('categoriasPieChart').getContext('2d');
const categoriasBarChartCtx = document.getElementById('categoriasBarChart').getContext('2d');
const tiposPieChartCtx = document.getElementById('tiposPieChart').getContext('2d');
const tiposBarChartCtx = document.getElementById('tiposBarChart').getContext('2d');

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

new Chart(categoriasPieChartCtx, {
    type: 'pie',
    data: {
        labels: Object.keys(categoriasData),
        datasets: [{
            data: Object.values(categoriasData),
            backgroundColor: ['#ff6384', '#36a2eb', '#cc65fe', '#ffce56', '#4bc0c0', '#9966ff']
        }]
    }
});

new Chart(categoriasBarChartCtx, {
    type: 'bar',
    data: {
        labels: Object.keys(categoriasData),
        datasets: [{
            label: 'Categorías',
            data: Object.values(categoriasData),
            backgroundColor: ['#ff6384', '#36a2eb', '#cc65fe', '#ffce56', '#4bc0c0', '#9966ff']
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

new Chart(tiposPieChartCtx, {
    type: 'pie',
    data: {
        labels: Object.keys(tiposData),
        datasets: [{
            data: Object.values(tiposData),
            backgroundColor: ['#ff9f40', '#ffcd56', '#ff6384']
        }]
    }
});

new Chart(tiposBarChartCtx, {
    type: 'bar',
    data: {
        labels: Object.keys(tiposData),
        datasets: [{
            label: 'Tipos de Trabajo',
            data: Object.values(tiposData),
            backgroundColor: ['#ff9f40', '#ffcd56', '#ff6384']
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
