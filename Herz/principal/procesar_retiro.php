<?php
include("../principal/config.php"); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reserva_id = $_POST['reserva_id'] ?? null;
    $vehiculo_id = $_POST['vehiculo_id'] ?? null;
    $cliente_id  = $_POST['cliente_id'] ?? null;

    if (!$reserva_id || !$vehiculo_id || !$cliente_id) {
        http_response_code(400);
        echo "Faltan datos para procesar el retiro.";
        exit;
    }

    try {
        $conexion->beginTransaction();

        // 1. Registrar el alquiler en la tabla alquileres
        $stmt = $conexion->prepare("INSERT INTO alquileres (reserva_id, vehiculo_id, cliente_id, fecha_inicio, estado) VALUES (?, ?, ?, NOW(), 'en curso')");
        $stmt->execute([$reserva_id, $vehiculo_id, $cliente_id]);

        // 2. Cambiar estado del vehículo a 'alquilado'
        $stmt = $conexion->prepare("UPDATE vehiculos SET estado = 'alquilado' WHERE id = ?");
        $stmt->execute([$vehiculo_id]);

        // 3. Cambiar estado de la reserva a 'en curso'
        $stmt = $conexion->prepare("UPDATE reservas SET estado = 'en curso' WHERE id = ?");
        $stmt->execute([$reserva_id]);

        $conexion->commit();

        echo "Retiro procesado correctamente.";
        header("Location: confirmar_retiro.php?reserva_id=" . urlencode($reserva_id));
        exit;
    } catch (Exception $e) {
        $conexion->rollBack();
        http_response_code(500);
        echo "Error al procesar el retiro: " . $e->getMessage();
    }
} else {
    http_response_code(405);
    echo "Método no permitido.";
}
?>
