document.getElementById('menuToggle').addEventListener('click', function() {
    document.getElementById('sidebar').classList.toggle('show');
    document.querySelector('main').classList.toggle('with-sidebar');
});
