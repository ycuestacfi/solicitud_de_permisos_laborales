// variable con el id del formulario
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
    var ultimoRegistro = FormApp.openById('1eUQXa6g_0X-qLlzBtvxeVXvyQSiJkfX04M4M8f1MIAg').getResponses().slice(-1)[0]; // Cambia 'abc123456' por tu ID real
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
    const webAppUrl = "https://script.google.com/macros/s/AKfycbxOzMyu8wo7UUugHdwuFQaQRRzzGYuqsquDPcxLHbxw/dev"; // Reemplaza con tu URL de Web App
    var solicitudId = identificador; // Usa el identificador de la solicitud como ID único
  
    // Enlaces de aprobación y rechazo con parámetros de acción
   var aceptarUrl = `${webAppUrl}?id=${solicitudId}&accion=aceptar`;
    var rechazarUrl = `${webAppUrl}?id=${solicitudId}&accion=rechazar`;
  
    var asunto = `${identificador} de Permiso Pendiente de Aprobación`;
    var mensaje = `
      <div style="max-width: 600px; margin: 20px auto; background-color: #FFFFFF; border-radius: 8px; overflow: hidden; box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1); padding: 20px;">
      
      <h2 style="color: #002A3F;">Estimado Supervisor,</h2>
      
      <p>El empleado <strong>${nombresolicitante}</strong> ha solicitado un permiso.</p>
      
      <ul style="list-style-type: none; padding: 0;">
        <li style="font-size:20px;" ><strong style="font-size:20px;" >Documento:</strong> ${documentosolicitante}</li>
        <li style="font-size:20px;" ><strong style="font-size:20px;" >Correo del empleado:</strong> ${solicitanteEmail}</li>
        <li style="font-size:20px;" ><strong style="font-size:20px;" >Fecha de la solicitud:</strong> ${fechasolicitud}</li>
        <li style="font-size:20px;" ><strong style="font-size:20px;" >Tipo de permiso:</strong> ${tipoPermiso}</li>
        <li style="font-size:20px;" ><strong style="font-size:20px;" >Fecha del permiso:</strong> ${fechaPermiso}</li>
        <li style="font-size:20px;" ><strong style="font-size:20px;" >Hora de salida:</strong> ${horasalida}</li>
        <li style="font-size:20px;" ><strong style="font-size:20px;" >Hora de llegada:</strong> ${horallegada}</li>
        <li style="font-size:20px;" ><strong style="font-size:20px;" >Observaciones:</strong> ${observaciones}</li>
      </ul>
  
      <p>Por favor, haga clic en el siguiente enlace para aprobar o rechazar la solicitud:</p>
  
      <form  method="POST" style="margin-bottom: 20px; display:flex; flex-dirrecion:colum;">
        <input type="hidden" name="id_solicitud_respuesta" id="id_solicitud_respuesta" value="${solicitudId}">
        <input type="hidden" name="accion" value="aceptar">
        <input type="hidden" name="corresolicitante" value="${solicitanteEmail}">
        <input type="text" name="comentario" placeholder="Comentario (opcional)" style="width: 70%; padding: 10px; margin-bottom: 10px; border: 1px solid black; border-radius: 4px;">
        <button type="submit" value="aceptar" name="accion" formaction="${aceptarUrl}" style="    background-color: #72be44; color: #ffffff; padding: 5px 10px; border: none; border-radius: 4px;     position: relative;
      top: 45px;
      right: 60%;
   height: 45px; cursor:pointer;">Aprovar Solicitud</button>
        <button type="submit" value="rechazar" name="accion" formaction="${rechazarUrl}" style="background-color: #e74c3c; color: #ffffff; padding: 5px 10px; border: none; border-radius: 4px;     position: relative;
      top: 45px;
      right: 40%;
   height: 45px; cursor: pointer;">Rechazar Solicitud</button>
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
    const hojaCalculo = SpreadsheetApp.openById('1D5oxcGPlD82T-9rj0O7BrAHCu4YmDbxHYfoF3J6tmTM'); // Reemplaza con tu ID real
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
    const hojaCalculo = SpreadsheetApp.openById('1D5oxcGPlD82T-9rj0O7BrAHCu4YmDbxHYfoF3J6tmTM');
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
    if (!respuesta_solicitud) {
      return HtmlService.createHtmlOutput("<p>Error: No se recibió ninguna solicitud.</p>");
    }
  
    // Obtener valores de acción e ID de solicitud
    var accion = respuesta_solicitud.parameter.accion; // "aceptar" o "rechazar"
    var solicitudId = respuesta_solicitud.parameter.id; // ID de la solicitud
  
    // Verificación de parámetros
    if (!accion) {
      Logger.log("Error: Acción indefinida");
      return HtmlService.createHtmlOutput("<p>Error: Acción indefinida.</p>");
    }
    
    if (!solicitudId) {
      Logger.log("Error: ID de solicitud indefinido");
      return HtmlService.createHtmlOutput("<p>Error: ID de solicitud indefinido.</p>");
    }
  
    const hojaCalculo = SpreadsheetApp.openById('1D5oxcGPlD82T-9rj0O7BrAHCu4YmDbxHYfoF3J6tmTM');
    const hojaRespuestas = hojaCalculo.getSheetByName('prueba1');
  
    // Obtener todos los valores de la columna L (desde la fila 2)
    var valoresColumnaL = hojaRespuestas.getRange(2, 12, hojaRespuestas.getLastRow() - 1).getValues();
  
    // Variable para almacenar la fila correspondiente donde se encontró el ID
    let filaEncontrada = -1;
  
    // Revisar los valores de la columna L para encontrar la solicitudId
    for (let i = 0; i < valoresColumnaL.length; i++) {
      if (valoresColumnaL[i][0] === solicitudId.trim()) {
        filaEncontrada = i + 2; // +2 porque comenzamos en la fila 2
        break;
      }
    }
  
    Logger.log(`ID en hoja: ${solicitudId}, fila encontrada: ${filaEncontrada}`);
  
    // Comprobar si se encontró el ID y verificar si la solicitud ya tiene respuesta en la columna M
    if (filaEncontrada !== -1) {
      var celdaRespuesta = hojaRespuestas.getRange(filaEncontrada, 13); // Columna M
      var respuestaExistente = celdaRespuesta.getValue();
  
      if (respuestaExistente) {
        Logger.log(`La solicitud ${solicitudId} ya ha sido respondida con: ${respuestaExistente}`);
        return HtmlService.createHtmlOutput(`<p>La solicitud ya ha sido respondida como: ${respuestaExistente}.</p>`);
      } else {
        // Si no hay respuesta existente, agregar la nueva respuesta
        celdaRespuesta.setValue(accion === 'aceptar' ? 'Aprobada' : 'Rechazada');
        Logger.log(`La solicitud ${solicitudId} ha sido ${accion === 'aceptar' ? 'Aprobada' : 'Rechazada'} correctamente en la fila ${filaEncontrada}.`);
        
        return HtmlService.createHtmlOutput(`<p>La solicitud ha sido ${accion} correctamente.</p>`);
      }
    } else {
      Logger.log(`Error: No se encontró una solicitud con el ID ${solicitudId}.`);
      return HtmlService.createHtmlOutput("<p>Error: No se encontró la solicitud especificada.</p>");
    }
  }
  
  function enviarCorreoRespuesta(){
    // URL del Web App
    const webAppUrl = "https://script.google.com/a/macros/providenciacfi.com/s/AKfycbxOzMyu8wo7UUugHdwuFQaQRRzzGYuqsquDPcxLHbxw/dev"; // Reemplaza con tu URL de Web App
    var solicitudId = identificador; // Usa el identificador de la solicitud como ID único
  
    // Enlaces de aprobación y rechazo con parámetros de acción
   var aceptarUrl = `${webAppUrl}?id=${solicitudId}&accion=aceptar`;
    var rechazarUrl = `${webAppUrl}?id=${solicitudId}&accion=rechazar`;
  
    var asunto = `${identificador} de Permiso Pendiente de Aprobación`;
    var mensaje = `
      Estimado Supervisor,
      
      El empleado ${nombresolicitante} ha solicitado un permiso.
      - Documento: ${documentosolicitante}
      - Correo del empleado: ${solicitanteEmail}
      - Fecha de la solicitud: ${fechasolicitud}
      - Tipo de permiso: ${tipoPermiso}
      - Fecha del permiso: ${fechaPermiso}
      - Hora de salida: ${horasalida}
      - Hora de llegada: ${horallegada}
      - Observaciones: ${observaciones}
      
     
      <p>Por favor, haga clic en el siguiente enlace para aprobar o rechazar la solicitud:</p>
    <form  method="POST">
  
      <input type="hidden" name="id_solicitud_respuesta" id="id_solicitud_respuesta" value="${solicitudId}">
      <input type="hidden" name="accion" value="aceptar">
      <button type="submit">Aceptar Solicitud</button>
    </form>
    <form action="${rechazarUrl}" method="POST">
      <input type="text" readonly name="id" value="${solicitudId}">
      <input type="hidden" name="accion" value="rechazar">
      <button type="submit">Rechazar Solicitud</button>
    </form>
      
      Gracias.
    `;
  
    // Enviar el correo al supervisor con formato HTML
    MailApp.sendEmail({
      to: supervisorEmail,
      subject: asunto,
      htmlBody: mensaje
    });
  }
  
  