<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Herz - Autos Rentables</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="principal.css">
</head>
<body>
    <!-- HEADER -->
    <header class="main-header">
        <div class="left">
            <div class="logo">Logo</div>
        </div>
        <div class="center">
            <h1>Herz - Autos Rentables</h1>
        </div>
        <?php
session_start();
?>

<div class="right">
    <nav>
        <?php if (isset($_SESSION['cliente_id'])): ?>
            <div class="perfil-dropdown">
                <img src="ruta/al/icono.png" alt="Perfil" class="perfil-icono">
                <div class="menu-dropdown">
                    <span><?php echo $_SESSION['cliente_nombre']; ?></span>
                    <a href="../Sesion/perfil.php">Mi perfil</a>
                    <a href="mis_reservas.php">Mis reservas</a>
                    <a href="../Sesion/logout.php">Cerrar sesión</a>
                </div>
            </div>
        <?php else: ?>
            <a href="../Sesion/login.php">Login</a>
            <a href="../Sesion/register.php">Register</a>
        <?php endif; ?>
    </nav>
</div>

    </header>

    <main>
        <section class="hero">
            <div class="title-row">
                <h2>Autos Disponibles</h2>
            </div>

            <div class="filters">
                <button onclick="filtrar('all')">Todos</button>
                <button onclick="filtrar('economico')">Económicos</button>
                <button onclick="filtrar('electrico')">Eléctricos</button>
                <button onclick="filtrar('suv')">SUV</button>
                <button onclick="filtrar('lujo')">De Lujo</button>
            </div>

            
            <div class="carousel-wrapper">
                <button class="carousel-btn prev" id="btn-prev" aria-label="Anterior">&lsaquo;</button>

                <div class="carousel" id="carousel">
                    <?php
                    $dir = "../carrousel-img/";
                    $imagenes = glob($dir . "*.{jpg,jpeg,png,gif,webp}", GLOB_BRACE);

                    $descripciones = [
                        'economico' => [
                            'titulo' => 'Económicos',
                            'descripcion' => 'Opción práctica y accesible, ideal para moverse por la ciudad y ahorrar combustible.',
                            'tipo' => 'economico'
                        ],

                        'electrico' => [
                            'titulo' => 'Eléctricos',
                            'descripcion' => 'Transporte ecológico y silencioso, perfecto para quienes buscan eficiencia y sostenibilidad.',
                            'tipo' => 'electrico'
                        ],

                        'suv' => [
                            'titulo' => 'SUV',
                            'descripcion' => 'Vehículo espacioso y versátil, ideal para viajes largos, familias o terrenos exigentes.',
                            'tipo' => 'suv'
                        ],
                        
                        'xlujo' => [
                            'titulo' => 'Vehículo de Lujo',
                            'descripcion' => 'Máximo confort, diseño elegante y tecnología avanzada para una experiencia de conducción superior.',
                            'tipo' => 'lujo'
                        ]


                    ];

                    if ($imagenes) {
                        foreach ($imagenes as $img) {
                            $nombre = pathinfo($img, PATHINFO_FILENAME);
                            $titulo = $descripciones[$nombre]["titulo"] ?? ucwords(str_replace('_',' ',$nombre));
                            $texto = $descripciones[$nombre]["descripcion"] ?? "Vehículo disponible para alquiler.";
                            $tipo = $descripciones[$nombre]["tipo"] ?? "economico";
                            ?>
                            <a href="reservar.php?tipo=<?php echo urlencode($tipo); ?>" class="slide-link">
                                <article class="slide" data-type="<?php echo $tipo; ?>" data-descripcion="<?php echo htmlspecialchars($texto); ?>">
                                    <img src="<?php echo $img; ?>" alt="<?php echo htmlspecialchars($titulo); ?>">
                                    <div class="slide-caption">
                                        <h3><?php echo htmlspecialchars($titulo); ?></h3>
                                    </div>
                                </article>
                            </a>

                            <?php
                        }
                    } else {
                        echo "<p>No hay imágenes en la carpeta <strong>img/</strong>.</p>";
                    }
                    ?>
                </div>

                <button class="carousel-btn next" id="btn-next" aria-label="Siguiente">&rsaquo;</button>
            </div>

            
            <div id="carousel-dots" class="carousel-dots"></div>

            
            <section class="descripcion">
                <p id="descripcion-texto">(Descripción del tipo de vehículo)</p>
            </section>
        </section>
              
        
        <section class="sucursales" style="padding: 40px;">
            <h2>Nuestras Sucursales</h2>
            <ul style="line-height: 1.8;">
                <li><strong>Buenos Aires - Av. Corrientes 1234</strong></li>
                <li><strong>Córdoba - Bv. San Juan 432</strong></li>
                <li><strong>Rosario - Calle Mitre 789</strong></li>
            </ul>
        </section>
    </main>

    
    <footer style="background-color: #222; color: #fff; padding: 20px; text-align: center;">
        &copy; 2025 Herz Rent a Car - Todos los derechos reservados.
    </footer>

    <script src="funciones.js"></script>
    <script>
  const dropdown = document.querySelector(".perfil-dropdown");
  const menu = dropdown.querySelector(".menu-dropdown");
  let hideTimeout;

  dropdown.addEventListener("mouseenter", () => {
    clearTimeout(hideTimeout);
    menu.classList.add("show");
  });

  dropdown.addEventListener("mouseleave", () => {
    hideTimeout = setTimeout(() => {
      menu.classList.remove("show");
    }, 300); // ⏱ Espera 300ms antes de ocultar
  });

  // Opcional: cerrar si se hace clic fuera
  document.addEventListener("click", function (e) {
    if (!dropdown.contains(e.target)) {
      menu.classList.remove("show");
    }
  });
</script>


</body>
</html>
