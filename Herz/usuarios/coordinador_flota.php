<?php
session_start();



include("../principal/config.php");


$sql = "SELECT v.id, v.patente, v.modelo, v.estado FROM Vehiculos v";
$vehiculos = $conn->query($sql);


$sql2 = "SELECT r.id, c.nombre AS cliente, r.tipoVehiculo, r.fechaInicio, r.fechaFin 
          FROM Reservas r 
          JOIN Clientes c ON r.idCliente = c.id";
$reservas = $conn->query($sql2);


$sql3 = "SELECT m.id, v.patente, m.tipo, m.estado, m.fecha
          FROM Mantenimiento m
          JOIN Vehiculos v ON m.idVehiculo = v.id
          WHERE m.estado = 'pendiente'";
$mantenimientos = $conn->query($sql3);


$totalVehiculos = $conn->query("SELECT COUNT(*) AS total FROM Vehiculos")->fetch_assoc()['total'];
$totalMantenimientos = $conn->query("SELECT COUNT(*) AS total FROM Mantenimiento WHERE estado='pendiente'")->fetch_assoc()['total'];
$totalReservas = $conn->query("SELECT COUNT(*) AS total FROM Reservas")->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Coordinador de Flotas</title>
    <link rel="stylesheet" href="all.css">
</head>
<body>

<header>
    <h1>Panel del Coordinador de Flotas</h1>
    <a href="../Sesion/logout.php" class="logout-btn">Cerrar sesión</a>
</header>

<main>

    
    <section class="resumen">
        <div class="card">
            <h3>Vehículos</h3>
            <p><?= $totalVehiculos ?></p>
        </div>
        <div class="card">
            <h3>Reservas</h3>
            <p><?= $totalReservas ?></p>
        </div>
        <div class="card alerta">
            <h3>Mantenimientos Pendientes</h3>
            <p><?= $totalMantenimientos ?></p>
        </div>
    </section>

    
    <section>
        <h2>Flota de Vehículos</h2>
        <table>
            <tr><th>ID</th><th>Patente</th><th>Modelo</th><th>Estado</th><th>Acciones</th></tr>
            <?php while ($v = $vehiculos->fetch_assoc()): ?>
            <tr>
                <td><?= $v['id'] ?></td>
                <td><?= htmlspecialchars($v['patente']) ?></td>
                <td><?= htmlspecialchars($v['modelo']) ?></td>
                <td><?= htmlspecialchars($v['estado']) ?></td>
                <td><button class="accion">Ver detalles</button></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </section>

    <!-- RESERVAS -->
    <section>
        <h2>Reservas Activas</h2>
        <table>
            <tr><th>ID</th><th>Cliente</th><th>Tipo Vehículo</th><th>Inicio</th><th>Fin</th></tr>
            <?php while ($r = $reservas->fetch_assoc()): ?>
            <tr>
                <td><?= $r['id'] ?></td>
                <td><?= htmlspecialchars($r['cliente']) ?></td>
                <td><?= htmlspecialchars($r['tipoVehiculo']) ?></td>
                <td><?= $r['fechaInicio'] ?></td>
                <td><?= $r['fechaFin'] ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </section>

    
    <section>
        <h2>Mantenimientos Pendientes</h2>
        <table>
            <tr><th>ID</th><th>Patente</th><th>Tipo</th><th>Fecha</th><th>Acción</th></tr>
            <?php while ($m = $mantenimientos->fetch_assoc()): ?>
            <tr>
                <td><?= $m['id'] ?></td>
                <td><?= htmlspecialchars($m['patente']) ?></td>
                <td><?= htmlspecialchars($m['tipo']) ?></td>
                <td><?= $m['fecha'] ?></td>
                <td><button class="accion">Marcar completado</button></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </section>

</main>

<footer>
    © <?= date("Y") ?> Sistema de Coordinación de Flota
</footer>

</body>
</html>
