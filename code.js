// var form = FormApp.openById('1eUQXa6g_0X-qLlzBtvxeVXvyQSiJkfX04M4M8f1MIAg');
const departamentos = [
  { nombre: "Administracion", correo: "xbautista@providenciacfi.com" },
  { nombre: "Talento Humano", correo: "ccastillo@providenciacfi.com" },
  { nombre: "Calidad", correo: "ccanar@providenciacfi.com" },
  { nombre: "Desarrollo y Producto", correo: "acastro@providenciacfi.com" },
  { nombre: "Academicas", correo: "ysandoval@providenciacfi.com" },
  { nombre: "Big Bag", correo: "lcruz@providenciacfi.com" },
  { nombre: "Almacen y Logistica", correo: "dcarrillo@providenciacfi.com" },
  { nombre: "Tecnologia Informatica", correo: "ycuesta@providenciacfi.com" },
  { nombre: "Producción", correo: "ctorralba@providenciacfi.com" },
  { nombre: "Comercial", correo: "kquesada@providenciacfi.com" },
  { nombre: "Contabilidad", correo: "jmedina@providenciacfi.com" },
  { nombre: "forma", correo: "jsanchez@providenciacfi.com" },
  { nombre: "mantenimiento", correo: "ngarcia@providenciacfi.com" }
];

function onFormSubmit() {
  var ultimoRegistro = FormApp.openById('1qTfcYZ6hu7SJdux_O1IyPjdSkaCdDIfvt0Ws2IqW2mQ').getResponses().slice(-1)[0]; // Cambia 'abc123456' por tu ID real
  var itemResponses = ultimoRegistro.getItemResponses(); // Obtiene las respuestas del último registro

  var valores = [];
  var correosolicitante = ultimoRegistro.getRespondentEmail();
  for (var itemResponse of itemResponses) {
    console.log(itemResponse.getResponse()); // Imprime la respuesta en la consola
    valores.push(itemResponse.getResponse()); // Agrega la respuesta al array 'valores'
  }
  asignacion(valores, correosolicitante);
}

function asignacion(valores, correosolicitante) {
  if (correosolicitante) {
    var solicitanteEmail = correosolicitante;
    if (valores) {
      var respuestas = valores;

      // Asigna cada columna a una variable
      var documentosolicitante = respuestas[0];
      var nombresolicitante = respuestas[1];
      var fechasolicitud = respuestas[2];
      var fechaPermiso = respuestas[3];
      var horasalida = respuestas[4];
      var horallegada = respuestas[5];
      var departamento_solicitante = respuestas[6];
      var tipoPermiso = respuestas[7];
      var observaciones = respuestas[8];

      // Buscar el correo del aprobador correspondiente
      var supervisorEmail = obtenerCorreoAprobador(departamento_solicitante);
      if (!supervisorEmail) {
        Logger.log("No se encontró aprobador para el departamento: " + departamento_solicitante);
        return;
      }

      // Enviar correo de notificación al supervisor
      enviarCorreoAprobacion(
        solicitanteEmail, nombresolicitante, documentosolicitante, fechasolicitud,
        tipoPermiso, fechaPermiso, horasalida, horallegada, observaciones, supervisorEmail
      );
    } else {
      Logger.log("Error: El evento o los valores no están definidos.");
      return;
    }
  } else {
    Logger.log("Error: los valores no están definidos.");
    return;
  }
}

function obtenerCorreoAprobador(departamento_solicitante) {
  for (var departamento of departamentos) {
    if (departamento.nombre.toLowerCase() === departamento_solicitante.toLowerCase()) {
      return departamento.correo; // Retorna el correo si se encuentra el departamento
    }
  }
  Logger.log("Departamento no encontrado: " + departamento_solicitante);
  return null; // Retorna null si no se encuentra el departamento
}

/**
 * Envía un correo al supervisor con la opción de aprobar o rechazar
 */
function enviarCorreoAprobacion(
  solicitanteEmail, nombresolicitante, documentosolicitante, fechasolicitud,
  tipoPermiso, fechaPermiso, horasalida, horallegada, observaciones, supervisorEmail
) {
  var identificador = identificador_solicitud();

  // URL del Web App
  const webAppUrl = "https://script.google.com/macros/s/AKfycbxe9zp0VPaHd_DILaviX7mMbJrxOa7IMmUlfpkSL4ZfqJyXML5h1UoRcIfgBOCg9iqJ/exec"; // Reemplaza con tu URL de Web App
  var solicitudId = identificador; // Usa el identificador de la solicitud como ID único

  // Enlaces de aprobación y rechazo con parámetros de acción
 var aceptarUrl = `${webAppUrl}?id=${solicitudId}&accion=aceptar`;
  var rechazarUrl = `${webAppUrl}?id=${solicitudId}&accion=rechazar`;

  var asunto = `${identificador} de Permiso Pendiente de Aprobación`;
  var mensaje = `
    <div style="max-width: 600px; margin: 20px auto; background-color: #FFFFFF; border-radius: 8px; overflow: hidden; box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1); padding: 20px;">
    
    <h2 style="color: #002A3F;">Estimado Supervisor,</h2>
    
    <p style="font-size:17px;">El empleado <strong style="color:#002A3F;"> ${nombresolicitante}</strong> ha solicitado un permiso.</p>
    
    <ul style="list-style-type: none; padding: 0;">
          <li style="font-size:20px;" >
            <strong >Documento:</strong>
              <span > ${documentosolicitante}</span>
          </li>

          <li style="font-size:20px;" >
            <strong> Correo del empleado:</strong>
              <span style="color:black;"> ${solicitanteEmail}<span>
          </li>

          <li style="font-size: 20px;" >
            <strong >Fecha de la solicitud:</strong>
            <span > ${fechasolicitud}</span>
          </li>

          <li style="font-size:20px;" >
            <strong >Tipo de permiso:</strong>
            <span > ${tipoPermiso}</span>
          </li>

          <li style="font-size:20px;" >
            <strong >Fecha del permiso:</strong>
            <span > ${fechaPermiso}</span>
          </li>

          <li style="font-size:20px;" >
            <strong >Hora de salida:</strong>
            <span > ${horasalida}</span>
           </li>

          <li style="font-size:20px;" >
            <strong >Hora de llegada:</strong>
            <span > ${horallegada}</span>
          </li>

          <li style="font-size:20px;" >
            <strong>Observaciones:</strong >
            <span> ${observaciones}</span>
          </li>
      </ul>

    <p><strong style="color:#002A3F;">Por favor, haga clic en el boton segun la accion que desee realizar para aprobar o rechazar la solicitud: 
puedes dejar tu comentario en el siguiente campo:</strong></p>

   <form style="display:flex;  margin-bottom: 20px;" action="${aceptarUrl}" method="POST">

    <input type="hidden" name="id" id="id" value="${solicitudId}">
    <input type="hidden" name="accion" value="aceptar">
    <input type="hidden" name="solicitanteEmail" value="${solicitanteEmail}">
    <input type="text" style="width:60%; color:#002A3F; border:solid 1px #002A3F; padding-left:8px;" placeholder="Desea agregar un comntario? (opcional)" name="comentario" >
    <button style="background-color: #72be44; color: #ffffff; padding: 10px 15px; border: none; border-radius: 4px;" type="submit" >Aceptar Solicitud</button>
  </form>
  <form style="display:flex; " action="${rechazarUrl}" method="POST">
    <input type="hidden" name="id" value="${solicitudId}">
    <input type="hidden" name="accion" value="rechazar">
    <input type="hidden" name="solicitanteEmail" value="${solicitanteEmail}">
    <input type="text" style="width:60%; color:#002A3F; border:solid 1px #002A3F; padding-left:8px;" placeholder="Desea agregar un comntario? (opcional)" name="comentario" >
    <button style="    background-color: #e74c3c;
    color: #ffffff;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;" type="submit">Rechazar Solicitud</button>
  </form>

    

  </div>
    
    Gracias.
  `;

  // Enviar el correo al supervisor con formato HTML
  MailApp.sendEmail({
    to: supervisorEmail,
    subject: asunto,
    htmlBody: mensaje
  });
}

function identificador_solicitud() {
  // Abre la hoja de cálculo utilizando su ID
  const hojaCalculo = SpreadsheetApp.openById('1Z4MATb0Ct2VRpfHsV7fB00herKXMeIB3prjfk-jDqZI'); // Reemplaza con tu ID real
  var hojaRespuestas = hojaCalculo.getSheetByName('prueba1');

  // Obtiene el último renglón con datos en la hoja de respuestas
  var renglon = hojaRespuestas.getLastRow();

  // Calcula el registro, que es el número de renglón - 1 (considerando cabeceras)
  var registro = renglon - 1;

  // Crea el identificador de solicitudes con formato
  var identificador_solicitudes = `SOLICITUD-${Utilities.formatString("%05d", registro)}`;

  // Escribe el identificador en la columna L (columna 12) del último renglón
  hojaRespuestas.getRange(renglon, 12).setValue(identificador_solicitudes);

  // Retorna el identificador de solicitudes
  return identificador_solicitudes;
}

function hojaverificadora(){
  const hojaCalculo = SpreadsheetApp.openById('1Z4MATb0Ct2VRpfHsV7fB00herKXMeIB3prjfk-jDqZI');
  const hojaRespuestas = hojaCalculo.getSheetByName('prueba1');

  // Obtiene el último renglón con datos en la hoja
  var renglon = hojaRespuestas.getLastRow();
  var idEnHoja = hojaRespuestas.getRange(renglon, 12).getValue().toString().trim();
  var hoita = "SOLICITUD-00008";
  if( idEnHoja = hoita){
    Logger.log(`ID en hoja: ${idEnHoja}, ID solicitado: ${hoita}`);
  }
  else{
    Logger.log(`el id es diferente`)
  }

  Logger.log(`ID en hoja: ${idEnHoja}, ID solicitado: ${hoita}`);
}

function doPost(respuesta_solicitud) {
  // Verificamos los nombres de los parámetros en la solicitud
  var solicitudId = respuesta_solicitud.parameter.id; // Cambiamos a "id" según el valor en la URL del formulario
  var accion = respuesta_solicitud.parameter.accion; // "aceptar" o "rechazar"
  var comentario = respuesta_solicitud.parameter.comentario || ''; // Capturamos el comentario correctamente

  // Accedemos a la hoja de respuestas directamente por ID
  var hojaCalculo = SpreadsheetApp.openById('1Z4MATb0Ct2VRpfHsV7fB00herKXMeIB3prjfk-jDqZI');
  var hojaRespuestas = hojaCalculo.getSheetByName("prueba1"); // Cambia "Respuestas" al nombre exacto de tu hoja
  var datos = hojaRespuestas.getDataRange().getValues();

  // Encontramos la fila correspondiente a la solicitud
  var filaEncontrada = -1;
  for (var i = 1; i < datos.length; i++) {
    if (datos[i][0] == solicitudId) { // Suponiendo que el ID de solicitud está en la columna A
      filaEncontrada = i + 1; // Sumar 1 para la posición real de la fila en la hoja
      break;
    }
  }

  if (filaEncontrada !== -1) {
    // Celda donde registraremos la respuesta de aprobación/rechazo
    var celdaRespuesta = hojaRespuestas.getRange(filaEncontrada, 13); // Columna M
    var respuestaExistente = celdaRespuesta.getValue();

    if (respuestaExistente) {
      Logger.log(`La solicitud ${solicitudId} ya ha sido respondida con: ${respuestaExistente}`);
      return HtmlService.createHtmlOutput(`<p>La solicitud ya ha sido respondida como: ${respuestaExistente}.</p>`);
    } else {
      // Guardamos la respuesta y el comentario en las columnas M y N
      celdaRespuesta.setValue(accion === 'aceptar' ? 'Aprobada' : 'Rechazada');
      hojaRespuestas.getRange(filaEncontrada, 14).setValue(comentario); // Comentario en la columna N

      Logger.log(`La solicitud ${solicitudId}  con el comentario ${comentario} ha sido ${accion === 'aceptar' ? 'Aprobada' : 'Rechazada'} correctamente en la fila ${filaEncontrada} .`);

      // Obtenemos el correo del solicitante desde la hoja de cálculo
      var solicitanteEmail = hojaRespuestas.getRange(filaEncontrada, 2).getValue(); // Suponiendo que el correo está en la columna B

      // Enviamos el correo de respuesta
      enviarCorreoRespuesta(solicitanteEmail, solicitudId, accion, comentario);
      
      return HtmlService.createHtmlOutput(`<p>La solicitud ha sido ${accion} correctamente.</p>`);
    }
  } else {
    Logger.log(`Error: No se encontró una solicitud con el ID ${solicitudId}.`);
    return HtmlService.createHtmlOutput("<p>Error: No se encontró la solicitud especificada.</p>");
  }
}



function enviarCorreoRespuesta(solicitanteEmail, solicitudId, accion, comentario) {
  var asunto = `Respuesta a tu solicitud ${solicitudId}`;
  var mensaje = `
    Estimado solicitante,

    Su solicitud con ID ${solicitudId} ha sido ${accion === 'aceptar' ? 'Aprobada' : 'Rechazada'}.

    Comentario del supervisor: ${comentario}

    Gracias.
  `;

  // Enviar el correo al solicitante
  MailApp.sendEmail({
    to: solicitanteEmail,
    subject: asunto,
    body: mensaje
  });
}



// oodigo do post aparte para prueba

function doPost(respuesta_solicitud) { if (!respuesta_solicitud) { return HtmlService.createHtmlOutput("<p>Error: No se recibió ninguna solicitud.</p>"); } var accion = respuesta_solicitud.parameter.accion; "aceptar" o "rechazar" var solicitudId = respuesta_solicitud.parameter.id; // ID de la solicitud var comentario = respuesta_solicitud.parameter.comentario || ''; // Comentario opcional var solicitanteEmail = respuesta_solicitud.parameter.corresolicitante; // Correo del solicitante if (!accion) { Logger.log("Error: Acción indefinida"); return HtmlService.createHtmlOutput("<p>Error: Acción indefinida.</p>"); } if (!solicitudId) { Logger.log("Error: ID de solicitud indefinido"); return HtmlService.createHtmlOutput("<p>Error: ID de solicitud indefinido.</p>"); } if (!solicitanteEmail) { Logger.log("Error: Correo del solicitante indefinido"); return HtmlService.createHtmlOutput("<p>Error: Correo del solicitante indefinido.</p>"); } const hojaCalculo = SpreadsheetApp.openById('1Z4MATb0Ct2VRpfHsV7fB00herKXMeIB3prjfk-jDqZI'); const hojaRespuestas = hojaCalculo.getSheetByName('prueba1'); var valoresColumnaL = hojaRespuestas.getRange(2, 12, hojaRespuestas.getLastRow() - 1).getValues(); let filaEncontrada = -1; for (let i = 0; i < valoresColumnaL.length; i++) { if (valoresColumnaL[i][0] === solicitudId.trim()) { filaEncontrada = i + 2; // +2 porque comenzamos en la fila 2 break; } } if (filaEncontrada !== -1) { var celdaRespuesta = hojaRespuestas.getRange(filaEncontrada, 13); // Columna M var respuestaExistente = celdaRespuesta.getValue(); var celdaComentario = hojaRespuestas.getRange(filaEncontrada, 14); // Columna N if (respuestaExistente) { Logger.log(`La solicitud ${solicitudId} ya ha sido respondida con: ${respuestaExistente}`); return HtmlService.createHtmlOutput(`<p>La solicitud ya ha sido respondida como: ${respuestaExistente}.</p>`); } else { celdaRespuesta.setValue(accion === 'aceptar' ? 'Aprobada' : 'Rechazada'); celdaComentario.setValue(comentario); Logger.log(`La solicitud ${solicitudId} ha sido ${accion === 'aceptar' ? 'Aprobada' : 'Rechazada'} correctamente en la fila ${filaEncontrada}.`); 

enviarCorreoRespuesta(solicitudId, accion, comentario, solicitanteEmail); 
return HtmlService.createHtmlOutput(`<p>La solicitud ha sido ${accion} correctamente.</p>`); }
 else { Logger.log(`Error: No se encontró una solicitud con el ID ${solicitudId}.`); return HtmlService.createHtmlOutput("<p>Error: No se encontró la solicitud especificada.</p>"); } }