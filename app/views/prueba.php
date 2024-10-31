<?php

// $email = 'Prueba123*';
// $email_hashed = hash("sha512", $email);

//     echo "Los valores son iguales en tipo y valor. $email_hashed";
$nombre_solicitante = $_SESSION['nombre'];
$

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <p> Cordial saludo lider </p>
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
</table>
</body>
</html>