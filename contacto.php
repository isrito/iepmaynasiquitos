<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = htmlspecialchars($_POST["nombre"]);
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $mensaje = htmlspecialchars($_POST["mensaje"]);

    $destinatario = "iepsmmaynasiquitos@gmail.com";  // Tu correo de recepción
    $asunto = "Nuevo mensaje de contacto";

    $contenido = "Nombre: $nombre\n";
    $contenido .= "Correo: $email\n\n";
    $contenido .= "Mensaje:\n$mensaje\n";

    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";

    if (mail($destinatario, $asunto, $contenido, $headers)) {
        echo "<script>alert('Mensaje enviado con éxito. Nos pondremos en contacto contigo pronto.'); window.location.href='contacto.html';</script>";
    } else {
        echo "<script>alert('Error al enviar el mensaje. Inténtalo de nuevo más tarde.'); window.location.href='contacto.html';</script>";
    }
}
?>
