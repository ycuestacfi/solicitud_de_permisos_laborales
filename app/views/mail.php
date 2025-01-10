<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <link rel="stylesheet" href="/app/assets/css/prueba.css"> -->
    <style>
       
:root {
    --verde-corporativo: #72BE44;
    --azul-oscuro-contraste: #002A3F;
    --blanco: #FFFFFF;
    --blanco-segundario: #f9f9f9;
    --gris-fondo:#333531;
}
body, html {
    margin: 0;
    padding: 0;
}
body {
 height: 100%;
 width: 100%;
}
main{
    height: 100vh;
    width: 100%;
    position: relative;
    
}
    </style>
</head>
<body>
    <main><?php $mailprueba = "yeffer" ?>
         <!-- <section style="position: absolute; top:50%; left:50%; height: 400px; width:400px; background-color:var(--verde-corporativo);transform: translateX(-50%) translateY(-50%); ">
             <div style="position: absolute; top:50%; left:50%; height:50%; width:50%; background-color:var(--azul-oscuro-contraste); transform: translateX(-50%) translateY(-50%); display: flex;
  align-items: center;
  justify-content: center;
  color: var(--blanco);">
             <?php echo $mailprueba;  ?>
             </div>
    </section> -->
    <h2>Estimado lider de proceso <?php echo $nombre_lider?></h2>
    <table style="width: 80%; margin: 0 auto; border: solid 2px black;">
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
    </main>
   
</body>
</html>