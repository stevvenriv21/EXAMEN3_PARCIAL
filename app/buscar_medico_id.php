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
$consulta = "SELECT * FROM medicos WHERE id = :id";
$stmt = $pdo->prepare($consulta);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();

$medico = $stmt->fetch(PDO::FETCH_ASSOC);

if ($medico) {
    echo json_encode($medico);
} else {
    echo json_encode(['error' => 'Médico no encontrado']);
}
?>
