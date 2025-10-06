<?php
include("../principal/config.php");

$idReserva = $_GET['idReserva'] ?? null;

if (!$idReserva) {
    die("ID de reserva no proporcionado.");
}

// Traer datos de la reserva
$sqlReserva = "SELECT R.*, C.nombre AS nombreCliente
               FROM Reservas R
               INNER JOIN Clientes C ON R.idCliente = C.id
               WHERE R.id = ?";
$stmt = $conn->prepare($sqlReserva);
$stmt->bind_param("i", $idReserva);
$stmt->execute();
$reserva = $stmt->get_result()->fetch_assoc();

if (!$reserva) {
    die("Reserva no encontrada.");
}


$sqlVehiculos = "SELECT * FROM Vehiculos 
                 WHERE tipo = ? AND estado = 'disponible'";
$stmt = $conn->prepare($sqlVehiculos);
$stmt->bind_param("s", $reserva['tipoVehiculo']);
$stmt->execute();
$vehiculosDisponibles = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Confirmar Retiro - Herz</title>
    <link rel="stylesheet" href="principal.css">
    <style>
        .container {
            max-width: 700px;
            margin: 2rem auto;
            padding: 1.5rem;
            background: #f9f9f9;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        label, select, input {
            display: block;
            width: 100%;
            margin-top: 1rem;
        }

        button {
            margin-top: 1.5rem;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
        }

        button:hover {
            background-color: #0056b3;
        }

        h2 {
            text-align: center;
        }
    </style>
</head>
<body>

<header class="main-header">
    <div class="left"><a href="home.php" class="logo">Logo</a></div>
    <div class="center"><h1>Confirmar Retiro</h1></div>
    <div class="right">
        <nav><a href="../Sesion/logout.php">Cerrar sesión</a></nav>
    </div>
</header>

<main class="container">
    <h2>Reserva #<?= $reserva['id'] ?> - <?= htmlspecialchars($reserva['nombreCliente']) ?></h2>
    <p><strong>Tipo solicitado:</strong> <?= ucfirst($reserva['tipoVehiculo']) ?></p>
    <p><strong>Desde:</strong> <?= $reserva['fechaInicio'] ?> &nbsp; <strong>Hasta:</strong> <?= $reserva['fechaFin'] ?></p>

    <?php if ($vehiculosDisponibles->num_rows > 0): ?>
        <form action="procesar_retiro.php" method="POST">
            <input type="hidden" name="idReserva" value="<?= $reserva['id'] ?>">

            <label for="idVehiculo">Seleccione un vehículo disponible:</label>
            <select name="idVehiculo" id="idVehiculo" required>
                <option value="">-- Elegir vehículo --</option>
                <?php while ($vehiculo = $vehiculosDisponibles->fetch_assoc()): ?>
                    <option value="<?= $vehiculo['id'] ?>">
                        <?= $vehiculo['patente'] ?> - <?= $vehiculo['modelo'] ?> (<?= $vehiculo['kilometraje'] ?> km)
                    </option>
                <?php endwhile; ?>
            </select>

            <button type="submit">Confirmar Retiro</button>
        </form>
    <?php else: ?>
        <p style="color: red;">⚠ No hay vehículos disponibles de este tipo en este momento.</p>
    <?php endif; ?>
</main>

</body>
</html>
