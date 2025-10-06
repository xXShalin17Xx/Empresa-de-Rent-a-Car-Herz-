<?php
include("../principal/config.php");
session_start();

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $contraseña = md5($_POST['contrasena']); 

    
    $stmt = $conn->prepare("SELECT c.id, c.nombre, c.email, c.idRol
                            FROM clientes c
                            WHERE c.email = ? AND c.contrasena = ?");
    $stmt->bind_param("ss", $email, $contraseña);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();

        
        $_SESSION['cliente_id'] = $usuario['id'];
        $_SESSION['cliente_nombre'] = $usuario['nombre'];
        $_SESSION['cliente_email'] = $usuario['email'];
        $_SESSION['cliente_rol'] = $usuario['idRol']; 

        
        switch ($usuario['idRol']) {
            case 1: // Cliente
                header("Location: ../principal/home.php");
                break;
            case 2: // Empleado
                header("Location: ../usuarios/empleado_home.php");
                break;
            case 3: // Coordinador
                header("Location: ../usuarios/coordinador_flota.php");
                break;
            case 4: // Mantenimiento
                header("Location: ../usuarios/panel_mantenimiento.php");
                break;
            default:
                header("Location: ../acceso_denegado.php");
                break;
        }
        exit;
    } else {
        $mensaje = "Credenciales incorrectas. <a href='login.php'>Intentar de nuevo</a>";
        $tipo_mensaje = "error";
    }

    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login / Registro - RentaCar</title>
  <link rel="stylesheet" href="login.css">
</head>
<header></header>
<body>
    <a href="../principal/home.php" class="volver-btn">← Volver al inicio</a>

<div class="container" id="container">
  <div class="box">
    <div class="form-container login">
      <h2>Iniciar Sesión</h2>
      <form method="POST" action="login.php">
      <input type="email" name="email" placeholder="Correo electrónico" required><br>
        <input type="text" name="contrasena" placeholder="contraseña" required><br>
      <button>Ingresar</button>
      <?php if (!empty($mensaje)): ?>
            <div class="mensaje <?php echo $tipo_mensaje; ?>">
            <?php echo $mensaje; ?>
            </div>
            <?php endif; ?>
        
            
        
    </form>

    </div>

  <div class="form-container register">
      <h2>Registrarse</h2>
      <form method="POST" action="register.php" id="registroForm">
      <div id="paso1">
      <input type="text" name="nombre" placeholder="Nombre completo" required><br>
      <input type="text" name="dni" placeholder="DNI" required><br>
      <input type="text" name="licencia" placeholder="Licencia de conducir" required><br>
      <input type="email" name="email" placeholder="Correo electrónico" required><br>
      <input type="text" name="telefono" placeholder="Teléfono" required><br>
      <button type="button" id="siguienteBtn">Siguiente</button>
    </div>

    <div id="paso2" style="display: none;">
      <input type="password" name="contrasena" placeholder="Contraseña" required><br>
      <input type="password" name="confirmar_contrasena" placeholder="Confirmar contraseña" required><br>
      <button type="submit">Crear cuenta</button>
    </div>
      
      </form>
    </div>

    <div class="switch">
      <h2>¿Nuevo por aquí?</h2>
      <p>Crea una cuenta para comenzar a reservar tu próximo vehículo</p>
      <button id="toggleBtn">Registrarse</button>
    </div>

  </div>
</div>

  <script src="script.js"></script>
  <script>
    document.getElementById("siguienteBtn").addEventListener("click", function () {
    const paso1 = document.getElementById("paso1");
    const paso2 = document.getElementById("paso2");

    // Validación básica de campos vacíos
    const inputsPaso1 = paso1.querySelectorAll("input");
    let todosLlenos = true;

    inputsPaso1.forEach(input => {
      if (!input.value.trim()) {
        todosLlenos = false;
        input.style.border = "1px solid red";
      } else {
        input.style.border = "";
      }
    });

    if (todosLlenos) {
      paso1.style.display = "none";
      paso2.style.display = "block";
    } else {
      alert("Por favor, completá todos los campos antes de continuar.");
    }
  });

  // Validar contraseñas iguales antes de enviar
  document.getElementById("registroForm").addEventListener("submit", function (e) {
    const pass = document.querySelector("input[name='contrasena']").value;
    const confirm = document.querySelector("input[name='confirmar_contrasena']").value;

    if (pass !== confirm) {
      e.preventDefault();
      alert("Las contraseñas no coinciden.");
    }
  });
</script>

</body>

</html>

