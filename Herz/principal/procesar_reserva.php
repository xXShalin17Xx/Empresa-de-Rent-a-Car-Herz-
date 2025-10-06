<?php
include("../principal/config.php");

$mensaje = "";
$tipoMensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];
    $tipo_auto = $_POST['tipo_auto'];

    $fecha_inicio = date('Y-m-d H:i:s', strtotime($fecha_inicio));
    $fecha_fin = date('Y-m-d H:i:s', strtotime($fecha_fin));

    $stmt = $conn->prepare("SELECT id FROM Clientes WHERE nombre = ? AND email = ?");
    $stmt->bind_param("ss", $nombre, $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 0) {
        $mensaje = "Cliente no encontrado. Asegúrese de estar registrado.";
        $tipoMensaje = "error";
    } else {
        $cliente = $resultado->fetch_assoc();
        $idCliente = $cliente['id'];

        // Insertar reserva
        $stmt = $conn->prepare("INSERT INTO Reservas (estado, idCliente, tipoVehiculo, fechaInicio, fechaFin) VALUES ('pendiente', ?, ?, ?, ?)");
        $stmt->bind_param("isss", $idCliente, $tipo_auto, $fecha_inicio, $fecha_fin);

        if ($stmt->execute()) {
            $mensaje = " Reserva registrada con éxito. Nos pondremos en contacto para confirmarla.";
            $tipoMensaje = "exito";
        } else {
            $mensaje = " Error al registrar la reserva.";
            $tipoMensaje = "error";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Procesar Reserva - Herz</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="principal.css">
</head>
<body>
    <header class="main-header">
        <div class="left"><a href="home.php" class="logo">Logo</a></div>
        <div class="center"><h1>Resultado de la Reserva</h1></div>
        <div class="right">
            
        </div>
    </header>

    <main class="reservas-container">
        <?php if (!empty($mensaje)): ?>
            <div class="mensaje <?= $tipoMensaje ?>">
                <p><?= $mensaje ?></p>
                <a href="home.php" class="btn">Volver al inicio</a>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>
