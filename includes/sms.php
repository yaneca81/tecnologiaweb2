<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="shortcut icon" href="./assets/images/favicon.ico" type="image/x-icon">
<title>CVNest.</title>
<style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap");
    .swal2-title {
        font-family: "Poppins", sans-serif !important;;
    }
    .swal2-confirm {
        font-family: "Poppins", sans-serif !important;
        border: none !important; 
        outline: none !important;
        background-color: #8CA49F !important;
        box-shadow: none !important;
        color: white !important;
        }

    .swal2-confirm:hover {
        background-color: black !important;;
    }
    .swal2-html-container {
        font-family: "Poppins", sans-serif !important;
    }
    .swal2-cancel {
        font-family: "Poppins", sans-serif !important;
        border: none !important; 
        outline: none !important;
        background-color: #8CA49F !important;
        box-shadow: none !important;
        color: white !important;
        }

    .swal2-cancel:hover {
        background-color: black !important;;
    }
</style>
<?php
    echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'CvNest.',
            text: 'Error: No se encotraron datos para el usuario',
            icon: 'error'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '../usuario/inicio.php';
            }
        });
    });
    </script>";
?>