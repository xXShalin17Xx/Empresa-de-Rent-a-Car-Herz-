<?php
include("../principal/config.php");


$sql = "SELECT R.id, C.nombre, C.email, R.tipoVehiculo, R.fechaInicio, R.fechaFin
        FROM Reservas R
        INNER JOIN Clientes C ON R.idCliente = C.id
        WHERE R.estado = 'pendiente'
        ORDER BY R.fechaInicio ASC";

$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reservas Pendientes - Herz</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="principal.css">
    <style>
        table {
            width: 90%;
            margin: 2rem auto;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: center;
        }
        th {
            background-color: #f0f0f0;
        }
        .btn {
            padding: 6px 12px;
            background-color: #007bff;
            color: white;
            border: none;
            text-decoration: none;
            border-radius: 4px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        h2 {
            text-align: center;
            margin-top: 2rem;
        }
    </style>
</head>
<body>

    <header class="main-header">
        <div class="left"><a href="../usuarios/empleado_home.php" class="logo">Logo</a></div>
        <div class="center"><h1>Reservas Pendientes</h1></div>
        <div class="right">
            <nav>
                
            </nav>
        </div>
    </header>

    <main>
        <h2>Reservas en espera de confirmación</h2>

        <?php if ($resultado->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID Reserva</th>
                        <th>Cliente</th>
                        <th>Email</th>
                        <th>Tipo Vehículo</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($reserva = $resultado->fetch_assoc()): ?>
                        <tr>
                            <td><?= $reserva['id'] ?></td>
                            <td><?= htmlspecialchars($reserva['nombre']) ?></td>
                            <td><?= htmlspecialchars($reserva['email']) ?></td>
                            <td><?= ucfirst($reserva['tipoVehiculo']) ?></td>
                            <td><?= $reserva['fechaInicio'] ?></td>
                            <td><?= $reserva['fechaFin'] ?></td>
                            <td>
                                <a class="btn" href="confirmar_retiro.php?idReserva=<?= $reserva['id'] ?>">
                                    Confirmar Retiro
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="text-align: center;">No hay reservas pendientes.</p>
        <?php endif; ?>
    </main>

</body>
</html>
