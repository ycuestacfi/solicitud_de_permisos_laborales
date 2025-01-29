<?php
// video para configuracion de sendmail y funcion mail local https://www.youtube.com/watch?v=U129sKnLoDA
$to      = 'jhoyos@colegioprovidencia.edu.co';
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

<?php
var mensaje = `
<table   cellpadding="0" cellspacing="0" style="width:100%; margin:0 auto; border-radius:5px;border:1px solid #e9e9e9">
    <thead >
        
        <tr >
            <td style=" margin: 0px 0px 40px 40% ;   justify-content: center; display: flex;">
                Solicitud ${solicitudId}
            </td>
            
        </tr>
        <br>
        <tr style="justify-content: center;
        display: flex;
        font-size: 38px; margin-bottom: 60px;">
            <td style="margin-left:20px;">
                <strong>Solicitud de licencia o permiso laboral  </strong> 
            </td>
           
        </tr>
        
        <tr >
            <td style="padding-left: 40px">
                Estimado solicitante ${celdaNombre} su solicitud fue ${accion === 'aceptar' ? 'aprobada' : 'rechazada'} por tu supervisor
            </td>
        </tr>
    </thead>
    <tbody style="align-items: center; justify-content: center; width: 80%;">
        <tr>
            <td style="margin-top: 50px;">
                
            </td>
        </tr>
        <tr>
           
            <td  style=" margin: 60px 0px 50px 10% ;   justify-content: center; display: flex;">
                 <table style="width: 90%;  border:1px solid #e9e9e9;">
                    <thead>
                        
                    </thead>

                    <tbody><tr>
                        <tr>
                            <td style="border: solid 1px #e9e9e9; align-items: center; text-align: start;    height: 45px;
                    border-left: none;
                    border-right: none;
                    width: 40%; padding-left: 20px; border-top: none;  ">Nombre:</td>
                            <td style="border: solid 1px #e9e9e9; align-items: center; text-align: start;    height: 45px;
                    border-left: none;
                    border-right: none;
                    width: 40%; padding-left: 20px; border-top: none;  ">${celdaNombre}</td>
                        </tr>
                        <td style="border: solid 1px #e9e9e9; align-items: center; text-align: start;    height: 45px;
                border-left: none;
                border-right: none;
                width: 40%; padding-left: 20px; border-top: none;  ">Documento: </td>
                        <td style="border: solid 1px #e9e9e9; align-items: center; text-align: start;    height: 45px;
                border-left: none;
                border-right: none;
                width: 40%; padding-left: 20px; border-top: none;  ">${celdaCc}</td>
                    </tr>
                        <tr>
                            <td style="border: solid 1px #e9e9e9; align-items: center; text-align: start;    height: 45px;
                    border-left: none;
                    border-right: none;
                    width: 40%; padding-left: 20px; border-top: none;  ">Su solicitud con ID ${solicitudId} ha sido: </td>
                            <td style="border: solid 1px #e9e9e9; align-items: center; text-align: start;    height: 45px;
                    border-left: none;
                    border-right: none;
                    width: 40%; padding-left: 20px; border-top: none;  ">${accion === 'aceptar' ? 'aprobada' : 'rechazada'}</td>
                        </tr>
                        <tr>
                            <td style="border: solid 1px #e9e9e9; align-items: center; text-align: start;    height: 45px;
                    border-left: none;
                    border-right: none;
                    width: 40%; padding-left: 20px; border-top: none;  ">Tu supervisor dejo un comentario para ti:  </td>
                            <td style="border: solid 1px #e9e9e9; align-items: center; text-align: start;    height: 45px;
                    border-left: none;
                    border-right: none;
                    width: 40%; padding-left: 20px; border-top: none; margin-bottom: 50px; ">${comentario}</td>
                        </tr>
                       
                    </tbody>
                </table>
            </td>
        </tr>
        
    </tbody>
</table>



`;

?>