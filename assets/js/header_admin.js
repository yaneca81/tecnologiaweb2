document.getElementById('menuToggle').addEventListener('click', function() {
    const sidebar = document.getElementById('sidebar');
    const isVisible = sidebar.classList.contains('show');

    if (isVisible) {
        sidebar.classList.remove('show'); // Oculta la barra lateral
    } else {
        sidebar.classList.add('show'); // Muestra la barra lateral
    }

    // También puedes agregar lógica para el contenido principal aquí si es necesario
    document.querySelector('main').classList.toggle('with-sidebar', !isVisible);
});
