document.addEventListener("DOMContentLoaded", function() {
    const modal = document.getElementById("confirmModal");
    const span = document.getElementsByClassName("close")[0];
    const confirmYes = document.getElementById("confirmYes");
    const confirmNo = document.getElementById("confirmNo");

    let deleteUrl = "";

    function confirmarEliminacion(id) {
        deleteUrl = `../pages/usuarioAdmin.php?eliminar=${id}`;
        modal.style.display = "block";
    }

    confirmYes.onclick = function() {
        window.location.href = deleteUrl;
    }

    confirmNo.onclick = function() {
        modal.style.display = "none";
    }

    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    window.confirmarEliminacion = confirmarEliminacion;
});
