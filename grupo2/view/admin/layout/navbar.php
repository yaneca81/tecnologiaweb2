<div class="navcontainer">
    <nav class="nav">
        <div class="nav-upper-options">

            <a href="<?php echo BASE_URL ?>/admin" class="nav-option">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="nav-icon" viewBox="0 0 16 16">
                    <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z" />
                </svg>
                <h3>Inicio</h3>
            </a>

            <a href="<?php echo BASE_URL ?>/admin/propiedades.php" class="nav-option option2">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 3v9.27c-1.71-.44-3.51-.24-5 .65V5c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2v8.92c-.86-.42-1.82-.72-2.8-.88V3c0-1.1-.9-2-2-2H6c-1.1 0-2 .9-2 2v7c0 1.57.64 3.14 1.76 4.25L12 21.1l6.25-6.25C19.36 11.14 20 9.57 20 8V3c0-1.1-.9-2-2-2H6c-1.1 0-2 .9-2 2v8c0 1.57.64 3.14 1.76 4.25L12 21.1z" fill="currentColor" />
                </svg>
                <h3>Propiedades</h3>
            </a>

            <a href="<?php echo BASE_URL ?>/admin/consultas.php" class="nav-option <?php echo $active == 'consultas' ? 'active' : '' ?>">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14 2H6c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H6V4h8V2zm4 4h-2v2h2v-2zm0 4h-2v2h2v-2zm0 4h-2v2h2v-2zM14 4v2h2V4h-2zM14 8v2h2V8h-2zM14 12v2h2v-2h-2z" fill="currentColor" />
                </svg>
                <h3>Consultas</h3>
            </a>

            <a href="<?php echo BASE_URL ?>/admin/tipos.php" class="nav-option option3">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6 22c-1.1 0-2-.9-2-2V10c0-1.1.9-2 2-2h4V4h4v4h4c1.1 0 2 .9 2 2v10c0 1.1-.9 2-2 2H6z" fill="currentColor" />
                </svg>
                <h3>Tipos</h3>
            </a>

            <a href="<?php echo BASE_URL ?>/admin/ubicaciones.php" class="nav-option option4">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 17l-4-4h3V7h2v8h3l-4 4z" fill="currentColor" />
                </svg>
                <h3>Ubicaciones</h3>
            </a>

            <a href="<?php echo BASE_URL ?>/admin/usuarios.php" class="nav-option option5">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.33-8 4v2h16v-2c0-2.67-5.33-4-8-4z" fill="currentColor" />
                </svg>
                <h3>Usuarios</h3>
            </a>

            <a href="<?php echo BASE_URL ?>/admin/caracteristicas.php" class="nav-option option6">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6 2C4.9 2 4 2.9 4 4v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2H6zm2 16v-2h8v2H8zm0-4v-2h8v2H8zm0-4V6h8v2H8z" fill="currentColor" />
                </svg>
                <h3>Características</h3>
            </a>

            <a href="<?php echo BASE_URL ?>" class="nav-option logout">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10 17l-5-5 5-5v3h5v4h-5v3zm9-11v14H5V6h14zm2-2H3c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h18c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2z" fill="currentColor" />
                </svg>
                <h3>Salir</h3>
            </a>

        </div>

    </nav>
</div>