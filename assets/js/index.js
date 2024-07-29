function postular(empleoid){//empleoId, titulo, foto) {
    if (document.cookie.includes('user_id')) {
        // Redirigir a postulacion.php con los parámetros en la URL
        //window.location.href = `postulacion.php?id=${empleoId}&titulo=${encodeURIComponent(titulo)}&foto=${encodeURIComponent(foto)}`;
        window.location.href = `postulacion.php?empleoid=${empleoid}`;
    } else {
        // Mostrar el modal de iniciar sesión
        document.getElementById('loginModal').style.display = 'block';
    }
}
/*function postular(empleoId, titulo, foto) {
    // Verificar si el usuario ha iniciado sesión
    if (document.cookie.includes('user_id')) {
        // Mostrar el modal de postulación
        // document.getElementById('postularTitulo').innerText = titulo;
        // document.getElementById('postularFoto').src = `../uploads/empleos/${foto}`;
        // document.getElementById('empleoId').value = empleoId;
        // document.getElementById('postularModal').style.display = 'block';
        
        //correccion new ventana
        window.location.href = `postulacion.php?datos=${empleoId, titulo, foto}`;
    } else {
        // Mostrar el modal de iniciar sesión
        document.getElementById('loginModal').style.display = 'block';
    }
}
*/

// Cerrar el modal
document.querySelectorAll('.modal .close').forEach(closeBtn => {
    closeBtn.onclick = function() {
        this.parentElement.parentElement.style.display = 'none';
    }
});

/*
// Validar y enviar el formulario de postulación
document.getElementById('postulacionForm').onsubmit = function(event) {
    event.preventDefault();

    const mensaje = document.getElementById('mensaje').value;
    const archivo = document.getElementById('archivo').files[0];

    let hasError = false;

    // Validar mensaje
    if (mensaje.length === 0 || mensaje.length > 220) {
        document.getElementById('mensajeError').innerText = 'El mensaje es obligatorio y no debe exceder los 220 caracteres.';
        hasError = true;
    } else {
        document.getElementById('mensajeError').innerText = '';
    }

    // Validar archivo
    if (!archivo || archivo.type !== 'application/pdf') {
        document.getElementById('archivoError').innerText = 'El archivo es obligatorio y debe ser un PDF.';
        hasError = true;
    } else {
        document.getElementById('archivoError').innerText = '';
    }

    if (!hasError) {
        this.submit();
    }
}
*/