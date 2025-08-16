<?php
require_once '../conexion/db.php';

// Forzar la cabecera JSON
header('Content-Type: application/json');

// recibir datos por JSON
$request = json_decode(file_get_contents("php://input"), true);

$id = $request['id'] ?? null;

if (!$id) {
    echo json_encode(['error' => 'ID no proporcionado']);
    exit;
}

// preparar la consulta
$consulta = "SELECT * FROM pacientes WHERE id = :id";
$stmt = $pdo->prepare($consulta);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();

$paciente = $stmt->fetch(PDO::FETCH_ASSOC);

if ($paciente) {
    echo json_encode($paciente);
} else {
    echo json_encode(['error' => 'Paciente no encontrado']);
}
?>
