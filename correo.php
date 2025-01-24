<?php
// video para configuracion de sendmail y funcion mail local https://www.youtube.com/watch?v=U129sKnLoDA
$to      = 'jhoyosAS@providenciacfi.com';
$subject = 'the subject';
$mensaje = '
     <html>
     <head>
     <title>Correo de prueba</title>
     </head>
        <body>
         <div style="max-width: 600px; margin: 20px auto; border: solid 1px #e9e9e9; background-color: #FFFFFF; border-radius: 8px; overflow: hidden; box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1); padding: 20px;">
      
      <h2 style="color: #002A3F;">Estimado Jefe,</h2>
      
      <p style="font-size:17px; border-bottom: solid 1px #e9e9e9;
    text-align: center;">El empleado <strong style="color:#002A3F;">  hello prueba</strong> ha solicitado un permiso.</p>
      
      <ul style="list-style-type: none; padding: 0;">
    <li style="font-size: 20px; border-bottom: solid 1px #e9e9e9;">
        <table style="width: 100%; border-spacing: 0;">
            <tr>
                <td style="text-align: left;"><strong>Numero De Documento:</strong></td>
                <td style="text-align: right;">hello prueba</td>
            </tr>
        </table>
    </li>
    <li style="font-size: 20px; border-bottom: solid 1px #e9e9e9;">
        <table style="width: 100%; border-spacing: 0;">
            <tr>
                <td style="text-align: left;"><strong>Correo Del Empleado:</strong></td>
                <td style="text-align: right;">hello prueba</td>
            </tr>
        </table>
    </li>
    <li style="font-size: 20px; border-bottom: solid 1px #e9e9e9;">
        <table style="width: 100%; border-spacing: 0;">
            <tr>
                <td style="text-align: left;"><strong>Fecha De la Solicitud:</strong></td>
                <td style="text-align: right;">hello prueba</td>
            </tr>
        </table>
    </li>
    <li style="font-size: 20px; border-bottom: solid 1px #e9e9e9;">
        <table style="width: 100%; border-spacing: 0;">
            <tr>
                <td style="text-align: left;"><strong>Tipo De Permiso:</strong></td>
                <td style="text-align: right;">hello prueba</td>
            </tr>
        </table>
    </li>
    <li style="font-size: 20px; border-bottom: solid 1px #e9e9e9;">
        <table style="width: 100%; border-spacing: 0;">
            <tr>
                <td style="text-align: left;"><strong>Fecha Del Permiso:</strong></td>
                <td style="text-align: right;">hello prueba</td>
            </tr>
        </table>
    </li>
    <li style="font-size: 20px; border-bottom: solid 1px #e9e9e9;">
        <table style="width: 100%; border-spacing: 0;">
            <tr>
                <td style="text-align: left;"><strong>Hora De Salida:</strong></td>
                <td style="text-align: right;">hello prueba</td>
            </tr>
        </table>
    </li>
    <li style="font-size: 20px; border-bottom: solid 1px #e9e9e9;">
        <table style="width: 100%; border-spacing: 0;">
            <tr>
                <td style="text-align: left;"><strong>Hora De llegada:</strong></td>
                <td style="text-align: right;">hello prueba</td>
            </tr>
        </table>
    </li>
    <li style="font-size: 20px; border-bottom: solid 1px #e9e9e9;">
        <table style="width: 100%; border-spacing: 0;">
            <tr>
                <td style="text-align: left;"><strong>Observaciones:</strong></td>
                <td style="text-align: right;">hello prueba</td>
            </tr>
        </table>
    </li>
</ul>

  
      <p><strong style="color:#002A3F;">¡Hola! Para gestionar esta solicitud, haz clic en el botón de abajo. Serás redirigido automáticamente para completar la acción.</strong></p>
  
    
    <a href="http://localhost/permisos/app/views/solicitud_de_permisos.php" style="display: block; width: 200px; margin: 20px auto; padding: 10px; background-color: #002A3F; color: #FFFFFF; text-align: center; text-decoration: none; border-radius: 8px;">Responder Solicitud</a>
  
      
  
    </div>
    </body>
     <html>
      
      Gracias.
    ';
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "From: ycuesta@providenciacfi.com \r\n";
    
    // 'X-Mailer: PHP/' . phpversion();
    // mail($to, $subject, $mensaje, $headers);
if (mail($to, $subject, $mensaje, $headers)) {
    echo "Correo enviado";
} else {
    echo "Error al enviar el correo";
}

?>