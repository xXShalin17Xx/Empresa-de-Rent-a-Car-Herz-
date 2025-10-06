<?php
session_start();
if (!isset($_SESSION['cliente_id'])) {
    header('Location: login.php');
    exit;
}
if (isset($_SESSION['cliente_registro'])) {
    $fecha = DateTime::createFromFormat('d/m/Y', $_SESSION['cliente_registro']);
    $fechaFormateada = $fecha ? $fecha->format('d \d\e F \d\e Y') : 'Fecha desconocida';
} else {
    $fechaFormateada = 'Fecha desconocida';
}   
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Perfil - Herz</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="perfil.css">
</head>
<body>

    <header class="main-header">
        <div class="left"><a href="home.php" class="logo">Logo</a></div>
        <div class="center"><h1>Mi Perfil</h1></div>
        <div class="right">
            <nav>
                <div class="perfil-dropdown">
                    <img src="ruta/al/icono.png" alt="Perfil" class="perfil-icono">
                    <div class="menu-dropdown">
                        <span><?php echo $_SESSION['cliente_nombre']; ?></span>
                        <a href="mis_reservas.php">Mis reservas</a>
                        <a href="logout.php">Cerrar sesión</a>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <main class="perfil-container">
        <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['cliente_nombre']); ?> 👋</h2>

        <div class="perfil-box">
            <p><strong>ID de Cliente:</strong> <?php echo $_SESSION['cliente_id']; ?></p>
            <p><strong>Nombre:</strong> <?php echo $_SESSION['cliente_nombre'] ?? 'No disponible'; ?></p>
            <p><strong>Correo electrónico:</strong> <?php echo $_SESSION['cliente_email'] ?? 'No disponible'; ?></p>
            <p><strong>Miembro desde:</strong> <?php echo $fechaFormateada; ?></p>

            <a href="mis_reservas.php" class="btn-reservas">Ver mis reservas</a>
            <a href="../Sesion/logout.php" class="btn-cerrar">Cerrar sesión</a>
        </div>
    </main>

</body>
</html>
