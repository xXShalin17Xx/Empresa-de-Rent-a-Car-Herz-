<?php
session_start();
include("../principal/config.php");


$sql = "SELECT r.id, c.nombre AS cliente, r.tipoVehiculo, r.fechaInicio, r.fechaFin
        FROM Reservas r
        JOIN Clientes c ON r.idCliente = c.id";
$resultado = $conn->query($sql);

$sql2 = "SELECT v.id, v.patente, v.modelo, v.estado FROM Vehiculos v";
$vehiculos = $conn->query($sql2);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Empleado - Sucursal</title>
    <link rel="stylesheet" href="all.css">
</head>
<body>

<header>
    <div class="left"><a href="../principal/home.php" class="logo">logo</a></div>
    <h1>Panel del Empleado - Sucursal</h1>
    <a href="..-7Sesion/logout.php" class="logout-btn">Cerrar sesión</a>
    

</header>

<main>
    <section>
    <h2>Reservas pendientes / en curso</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Tipo Vehículo</th>
                <th>Inicio</th>
                <th>Fin</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($r = $resultado->fetch_assoc()): ?>
            <tr onclick="window.location.href='../principal/admin_reservas.php'" style="cursor: pointer;">
                <td><?= $r['id'] ?></td>
                <td><?= htmlspecialchars($r['cliente']) ?></td>
                <td><?= htmlspecialchars($r['tipoVehiculo']) ?></td>
                <td><?= $r['fechaInicio'] ?></td>
                <td><?= $r['fechaFin'] ?></td>
            </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </section>


    <section>
        <h2>Vehículos</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Patente</th>
                <th>Modelo</th>
                <th>Estado</th>
            </tr>
            <?php while ($v = $vehiculos->fetch_assoc()): ?>
            <tr>
                <td><?= $v['id'] ?></td>
                <td><?= htmlspecialchars($v['patente']) ?></td>
                <td><?= htmlspecialchars($v['modelo']) ?></td>
                <td><?= htmlspecialchars($v['estado']) ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </section>
</main>

<footer>
    © <?= date("Y") ?> Sistema de Gestión de Sucursal
</footer>

</body>
</html>
