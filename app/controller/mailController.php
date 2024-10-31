<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
// require '/../../envio_mail/Exception.php';
// require_once '/envio_mail/PHPMailer.php';
// require_once '/envio_mail/SMTP.php';
require_once __DIR__ . '/envio_mail/Exception.php';  // Asegúrate de que el archivo existe aquí
require_once __DIR__ . '/envio_mail/PHPMailer.php';  // Asegúrate de que el archivo existe aquí
require_once __DIR__ . '/envio_mail/SMTP.php'; 
//Create an instance; passing `true` enables exceptions
class sendMail{

}
$mail = new PHPMailer(true);

try {
    //Server settings
         
    $mail->SMTPDebug = 0;              
    $mail->isSMTP();                                            
    $mail->Host       = 'smtp.gmail.com';                 
    $mail->SMTPAuth   = true;                 
    $mail->Username   = 'solicitud.permisos.laborales@providenciacfi.com';                   
    $mail->Password   = 'Pr0v1d3nc14$#';                             
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
    $mail->Port       = 465;                              

    //Recipients
    $mail->setFrom('solicitud.permisos.laborales@providenciacfi.com');
    $mail->addAddress('yefercuesta123@gmail.com');    

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Solicitud De Permiso laboral 2';
    $mail->Body = '
<table style="width: 100%; border: solid 2px black;">
    <thead>
        <tr style="background-color: #72BE44; color: white;">
            <th style="border: 1px solid black; color:#002A3F; font-size:20px; font-weight:600; padding: 8px;">nombre del solicitante</th>
            <th style="border: 1px solid black; color:#002A3F; font-size:20px; font-weight:600; padding: 8px;">fecha de la solicitud</th>
            <th style="border: 1px solid black; color:#002A3F; font-size:20px; font-weight:600; padding: 8px;">cedula del solicitante</th>
            <th style="border: 1px solid black; color:#002A3F; font-size:20px; font-weight:600; padding: 8px;">correo del solicitante</th>
            <th style="border: 1px solid black; color:#002A3F; font-size:20px; font-weight:600; padding: 8px;">comentario</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="border: 1px solid black;  text-aling:center; padding: 8px;">pepito</td>
            <td style="border: 1px solid black;  text-aling:center; padding: 8px;">15/10/2024</td>
            <td style="border: 1px solid black;  text-aling:center; padding: 8px;">123456789</td>
            <td style="border: 1px solid black;  text-aling:center; padding: 8px;">pepito@providenciacfi.com</td>
            <td style="border: 1px solid black;  text-aling:center; padding: 8px;">N/A</td>
        </tr>
    </tbody>
</table>';
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    // $file_path = __DIR__ . '/../views/mail.php';
    // if (file_exists($file_path) && filesize($file_path) > 0) {
    //     $body = file_get_contents($file_path);
    //     $mail->isHTML(true);     // Configura el correo para enviar contenido HTML
    //     $mail->Body = $body;
    // } else {
    //     echo "Error: El archivo de plantilla no existe o está vacío.";
    //     exit;
    // }
    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}