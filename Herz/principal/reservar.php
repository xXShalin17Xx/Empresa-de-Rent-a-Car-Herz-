<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reservar Vehículo - Herz</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="principal.css">
</head>
<body>

    <header class="main-header">
        <div class="left"><a href="home.php" class="logo">Logo</a></div>
        <div class="center"><h1>Reservar Vehículo</h1></div>
        <div class="right">
            <nav>
                <a href="../Sesion/login.php">Login</a>
                <a href="../Sesion/register.php">Register</a>
            </nav>
        </div>
    </header>

    <main class="reservas-container">
        <h2 class="reservas-title">Formulario de Reserva</h2>

        <?php
            
            $tipoSeleccionado = $_GET['tipo'] ?? '';
        ?>

        <form action="procesar_reserva.php" method="POST" class="reservas-form">
            <label for="nombre">Nombre completo:</label>
            <input type="text" name="nombre" id="nombre" required>

            <label for="email">Correo electrónico:</label>
            <input type="email" name="email" id="email" required>

            <label for="fecha_inicio">Fecha y hora de inicio:</label>
            <input type="datetime-local" name="fecha_inicio" id="fecha_inicio" required>

            <label for="fecha_fin">Fecha y hora de devolución:</label>
            <input type="datetime-local" name="fecha_fin" id="fecha_fin" required>


            <label for="tipo_auto">Tipo de vehículo:</label>
            <select name="tipo_auto" id="tipo_auto" required>
                <option value="economico" <?php if($tipoSeleccionado === 'economico') echo 'selected'; ?>>Económico</option>
                <option value="electrico" <?php if($tipoSeleccionado === 'electrico') echo 'selected'; ?>>Eléctrico</option>
                <option value="suv" <?php if($tipoSeleccionado === 'suv') echo 'selected'; ?>>SUV</option>
                <option value="lujo" <?php if($tipoSeleccionado === 'lujo') echo 'selected'; ?>>De Lujo</option>
            </select>

            <button type="submit">Confirmar Reserva</button>
        </form>
    </main>

</body>
</html>
