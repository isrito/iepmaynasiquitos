<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noticias y Eventos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css">
    <link rel="icon" href="img/logo.png">
    <style>
        body {
            font-family: Arial, sans-serif;
            
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .noticia {
            width: 80%;
            margin: 20px auto;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            background: #fff;
        }
        .noticia h2, .noticia small {
            text-align: center;
        }
        .noticia p {
            text-align: justify; /* Solo el texto de la noticia estará justificado */
            white-space: pre-line; /* Permite saltos de línea en el texto */
        }
        .swiper {
            width: 100%;
            height: 300px;
            margin-top: 15px;
        }
        .swiper-slide {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .swiper-slide img, .swiper-slide video, .swiper-slide iframe {
            max-width: 100%;
            max-height: 100%;
            border-radius: 8px;
        }
    </style>
</head>
<body>

<?php
// Ruta del archivo de noticias
$archivo = "noticias.txt";

// Verifica si el archivo existe
if (file_exists($archivo)) {
    $lineas = file($archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $contador = 1; // Contador para generar ID único para cada carrusel

    // Invertir el orden de las noticias para que la más reciente aparezca primero
    $lineas = array_reverse($lineas);

    foreach ($lineas as $linea) {
        // Separar los datos
        list($titulo, $fecha, $descripcion, $multimedia) = explode("|", $linea);

        // Dividir múltiples archivos multimedia
        $archivos = explode(",", $multimedia);
        $multimedia_html = "";

        // Contenedor del carrusel
        $multimedia_html .= "<div class='swiper mySwiper$contador'><div class='swiper-wrapper'>";

        foreach ($archivos as $archivo) {
            $archivo = trim($archivo); // Eliminar espacios extra
            
            if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $archivo)) {
                // Si es una imagen
                $multimedia_html .= "<div class='swiper-slide'><img src='$archivo' alt='$titulo'></div>";
            } elseif (preg_match('/\.(mp4|webm|ogg)$/i', $archivo)) {
                // Si es un video local
                $multimedia_html .= "<div class='swiper-slide'><video controls autoplay loop muted><source src='$archivo' type='video/mp4'></video></div>";
            } elseif (strpos($archivo, "youtube.com/embed") !== false) {
                // Si es un video de YouTube (embed)
                $multimedia_html .= "<div class='swiper-slide'><iframe width='560' height='315' src='$archivo' frameborder='0' allowfullscreen></iframe></div>";
            }
        }

        // Cerrar carrusel
        $multimedia_html .= "</div>
                            <div class='swiper-button-next'></div>
                            <div class='swiper-button-prev'></div>
                            <div class='swiper-pagination'></div>
                            </div>";

        // Mostrar la noticia con el carrusel
        echo "<div class='noticia'>
                <h2>$titulo</h2>
                <small><strong>Fecha:</strong> $fecha</small>
                <p>$descripcion</p>
                $multimedia_html
              </div>";

        $contador++; // Incrementar contador para el próximo carrusel
    }
} else {
    echo "<p>No hay noticias disponibles en este momento.</p>";
}
?>

<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
<script>
    <?php for ($i = 1; $i <= count($lineas); $i++) : ?>
    new Swiper(".mySwiper<?= $i ?>", {
        slidesPerView: 1,
        spaceBetween: 20,
        loop: true,
        pagination: { el: ".mySwiper<?= $i ?> .swiper-pagination", clickable: true },
        navigation: { nextEl: ".mySwiper<?= $i ?> .swiper-button-next", prevEl: ".mySwiper<?= $i ?> .swiper-button-prev" },
        autoplay: { delay: 3000, disableOnInteraction: false },
    });
    <?php endfor; ?>
</script>

</body>
</html>
