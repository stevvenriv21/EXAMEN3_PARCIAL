<?php
// Conectar a base de datos
require_once '../conexion/db.php';

// Recibir los datos del formulario
$paciente_id = $_POST['paciente_id'];
$medico_id   = $_POST['medico_id'];
$fecha       = $_POST['fecha'];
$hora_inicio = $_POST['hora_inicio'];
$hora_fin    = $_POST['hora_fin'];

// ======= CÁLCULOS PREVIOS =======
$fecha_actual = date('Y-m-d');
$hora_actual = date('H:i');

// Validar fecha
if (strtotime($fecha) < strtotime($fecha_actual)) {
    echo "Error: la fecha de la cita no puede ser anterior al día actual";
    exit;
}

// Si es hoy, validar hora de inicio contra hora actual
if ($fecha === $fecha_actual && strtotime($hora_inicio) < strtotime($hora_actual)) {
    echo "Error: la hora de inicio no puede ser anterior a la hora actual";
    exit;
}

// Validar que la hora de inicio sea después o igual a las 9:00 AM
if (strtotime($hora_inicio) < strtotime('09:00')) {
    echo "Error: la hora de inicio no puede ser antes de las 9:00 AM";
    exit;
}

// Validar que la hora de fin no sea después de las 6:00 PM
if (strtotime($hora_fin) > strtotime('18:00')) {
    echo "Error: la hora de fin no puede ser después de las 6:00 PM";
    exit;
}

// Calcular duración en minutos
$duracion = (strtotime($hora_fin) - strtotime($hora_inicio)) / 60;

// Validar que la duración sea positiva
if ($duracion <= 0) {
    echo "Error: la hora de fin debe ser mayor a la hora de inicio";
    exit;
}

// Obtener tarifa por hora del médico
$stmt = $pdo->prepare("SELECT tarifa_por_hora FROM medicos WHERE id = :id");
$stmt->bindParam(':id', $medico_id);
$stmt->execute();
$tarifa = $stmt->fetchColumn();

// Si no se encontró tarifa, error
if ($tarifa === false) {
    echo "Error: médico no encontrado";
    exit;
}

// Calcular costo total (tarifa por hora * fracción de hora)
$costo_total = ($duracion / 60) * $tarifa;

$estado = 'programada';
// ================================

// Insertar en la base de datos
$sql = "INSERT INTO citas (paciente_id, medico_id, fecha, hora_inicio, hora_fin, duracion, costo_total, estado) 
        VALUES (:paciente_id, :medico_id, :fecha, :hora_inicio, :hora_fin, :duracion, :costo_total, :estado)";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':paciente_id', $paciente_id);
$stmt->bindParam(':medico_id', $medico_id);
$stmt->bindParam(':fecha', $fecha);
$stmt->bindParam(':hora_inicio', $hora_inicio);
$stmt->bindParam(':hora_fin', $hora_fin);
$stmt->bindParam(':duracion', $duracion);
$stmt->bindParam(':costo_total', $costo_total);
$stmt->bindParam(':estado', $estado);

if ($stmt->execute()) {
    echo "Cita creada correctamente. Duración: {$duracion} minutos, Costo: $" . number_format($costo_total, 2) . ", Estado: {$estado}";
} else {
    echo "Error al crear la cita";
}
?>
