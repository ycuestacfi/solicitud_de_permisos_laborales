function onFormSubmit(formResponse) {
    if (formResponse ) {
    
      const respuestas = formResponse.values;
  
      // Asigna cada columna a una variable
      const solicitanteEmail = respuestas[0];
      const documentosolicitante = respuestas[1];
      const nombresolicitante = respuestas[2];
      const fechasolicitud = respuestas[3];
      const fechaPermiso = respuestas[4];
      const horasalida = respuestas[5];
      const horallegada = respuestas[6];
      const departamento_solicitante = respuestas[7];
      const tipoPermiso = respuestas[8];
      const observaciones = respuestas[9];
  
      // Buscar el correo del aprobador correspondiente
      const supervisorEmail = obtenerCorreoAprobador(departamento_solicitante);
      if (!supervisorEmail) {
        Logger.log("No se encontró aprobador para el departamento: " + departamento_solicitante);
        return;
      }
  
      // Enviar correo de notificación al supervisor
      enviarCorreoAprobacion(
        solicitanteEmail, nombresolicitante, documentosolicitante, fechasolicitud, 
        tipoPermiso, fechaPermiso, horasalida, horallegada, observaciones, supervisorEmail
      );
    }else{
      Logger.log("Error: El evento o los valores no están definidos.");
      return;
    }
  
   
  }
  
  /**
   * Buscar el correo del aprobador basado en el departamento
   */
  
  // Array de datos de departamentos
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
  
  function obtenerCorreoAprobador(departamento_solicitante) {
    for (const departamento of departamentos) {
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
  ){
    const asunto = "Solicitud de Permiso Pendiente de Aprobación";
    const mensaje = `
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
      
      Para aprobar o rechazar la solicitud, haz clic en los siguientes enlaces:
     
      - [Aprobar](https://script.google.com/macros/s/YOUR_SCRIPT_ID/exec?fila=${ultimaFila}&accion=aprobar)
      - [Rechazar](https://script.google.com/macros/s/YOUR_SCRIPT_ID/exec?fila=${ultimaFila}&accion=rechazar)
    `;
  
    MailApp.sendEmail(supervisorEmail, asunto, mensaje);
  };
  
  
  
  