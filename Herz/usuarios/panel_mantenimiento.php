<?php
session_start();
include("../principal/config.php");

$sql = "SELECT m.id, v.patente, m.tipo, m.estado, m.fecha
        FROM Mantenimiento m
        JOIN Vehiculos v ON m.idVehiculo = v.id
        WHERE m.estado = 'pendiente'";
$pendientes = $conn->query($sql);


$totalPendientes = $conn->query("SELECT COUNT(*) AS total FROM Mantenimiento WHERE estado='pendiente'")->fetch_assoc()['total'];
$totalCompletados = $conn->query("SELECT COUNT(*) AS total FROM Mantenimiento WHERE estado='completado'")->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel - Personal de Mantenimiento</title>
    <link rel="stylesheet" href="all.css">
</head>
<body>

<header class="main-header">
        <div class="left">
            <div class="logo">Logo</div>
        </div>
        <div class="center">
            <h1>Herz - Autos Rentables</h1>
        </div>
</header>

<main>

    
    <section class="resumen">
        <div class="card">
            <h3>Pendientes</h3>
            <p><?= $totalPendientes ?></p>
        </div>
        <div class="card completado">
            <h3>Completados</h3>
            <p><?= $totalCompletados ?></p>
        </div>
    </section>

    
    <section>
        <h2>Órdenes de Mantenimiento Pendientes</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Patente</th>
                <th>Tipo</th>
                <th>Fecha</th>
                <th>Acción</th>
            </tr>
            <?php while ($m = $pendientes->fetch_assoc()): ?>
            <tr>
                <td><?= $m['id'] ?></td>
                <td><?= htmlspecialchars($m['patente']) ?></td>
                <td><?= htmlspecialchars($m['tipo']) ?></td>
                <td><?= $m['fecha'] ?></td>
                <td>
                    <form action="completar_mantenimiento.php" method="POST">
                        <input type="hidden" name="mantenimiento_id" value="<?= $m['id'] ?>">
                        <button type="submit" class="accion">Marcar como completado</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </section>

</main>

<footer>
    © <?= date("Y") ?> Sistema de Mantenimiento de Flota
</footer>

</body>
</html>
