// Nombre de la hoja donde están los datos de los aprobadores
const documento = "CFIP solicitudes de permisos laborales"
const prueba = abrir(documento);

function abrir(documento){
  // Buscar el archivo en Google Drive por su nombre
  const files = DriveApp.getFilesByName(nombreArchivo);

  // Verificar si el archivo existe
  if (files.hasNext()) {
    const file = files.next();
    const spreadsheet = SpreadsheetApp.open(file);
    return spreadsheet; // Devuelve el objeto Spreadsheet
  } else {
    Logger.log("No se encontró ningún archivo con el nombre: " + nombreArchivo);
    return null; // Retorna null si no se encuentra el archivo
  }
}
const HOJA_APROBADORES = "Lideres_aprobadores"; // Cambia si usas otro nombre
const HOJA_RESPUESTAS = "CFIP solicitudes de permisos laborales"; // Cambia al nombre de la hoja de respuestas de tu formulario

/**
 * Función que se ejecuta al enviar el formulario
 */
function onFormSubmit(e) {
  // Obtener la hoja de respuestas directamente de la hoja de cálculo activa
  const spreadsheet = SpreadsheetApp.getActiveSpreadsheet();
  const hoja = spreadsheet.getSheetByName("CFIP solicitudes de permisos laborales");

  if (!hoja) {
    Logger.log("La hoja de respuestas no existe.");
    return;
  }

  

  const ultimaFila = hoja.getLastRow();
  
  // Obtener datos del formulario desde la última fila de la hoja
  const solicitanteEmail = hoja.getRange(ultimaFila, 1).getValue();
  const documentosolicitante = hoja.getRange(ultimaFila, 2).getValue();
  const nombresolicitante = hoja.getRange(ultimaFila, 3).getValue();
  const fechasolicitud = hoja.getRange(ultimaFila, 4).getValue();
  const fechaPermiso = hoja.getRange(ultimaFila, 5).getValue();
  const horasalida = hoja.getRange(ultimaFila, 6).getValue();
  const horallegada = hoja.getRange(ultimaFila, 7).getValue();
  const departamento = hoja.getRange(ultimaFila, 8).getValue();
  const tipoPermiso = hoja.getRange(ultimaFila, 9).getValue();
  const observaciones = hoja.getRange(ultimaFila, 10).getValue();

  // Buscar el correo del aprobador correspondiente
  const supervisorEmail = obtenerCorreoAprobador(departamento);
  if (!supervisorEmail) {
    Logger.log("No se encontró aprobador para el departamento: " + departamento);
    return;
  }

  // Enviar correo de notificación al supervisor
  enviarCorreoAprobacion(
    solicitanteEmail, nombresolicitante, documentosolicitante, fechasolicitud, 
    tipoPermiso, fechaPermiso, horasalida, horallegada, observaciones, ultimaFila, supervisorEmail
  );
}

function abrir(documento){
    // Buscar el archivo en Google Drive por su nombre
    const files = DriveApp.getFilesByName(nombreArchivo);
  
    // Verificar si el archivo existe
    if (files.hasNext()) {
      const file = files.next();
      const spreadsheet = SpreadsheetApp.open(file);
      return spreadsheet; // Devuelve el objeto Spreadsheet
    } else {
      Logger.log("No se encontró ningún archivo con el nombre: " + nombreArchivo);
      return null; // Retorna null si no se encuentra el archivo
    }
  }

/**
 * Buscar el correo del aprobador basado en el departamento
 */
function obtenerCorreoAprobador(departamento) {
  // Abre la hoja de cálculo activa
  const spreadsheet = SpreadsheetApp.getActiveSpreadsheet();
  
  // Obtén la hoja de aprobadores por su nombre
  const sheet = spreadsheet.getSheetByName(HOJA_APROBADORES);
  
  if (!sheet) {
    Logger.log("La hoja de aprobadores especificada no existe.");
    return null;
  }

  // Obtiene el rango de datos de la hoja
  const data = sheet.getDataRange().getValues();

  // Recorre las filas buscando el departamento
  for (let i = 0; i < data.length; i++) {
    if (data[i][0] === departamento) { // Suponiendo que los departamentos están en la primera columna
      return data[i][1]; // Retorna el valor de la columna derecha (correo del supervisor)
    }
  }

  Logger.log(`Departamento "${departamento}" no encontrado.`);
  return null; // Retorna null si el departamento no se encuentra
}

/**
 * Envía un correo al supervisor con la opción de aprobar o rechazar
 */
function enviarCorreoAprobacion(
  solicitanteEmail, nombresolicitante, documentosolicitante, fechasolicitud, 
  tipoPermiso, fechaPermiso, horasalida, horallegada, observaciones, ultimaFila, supervisorEmail
) {
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
}
