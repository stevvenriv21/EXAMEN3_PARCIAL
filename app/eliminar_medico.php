<?php
require_once '../conexion/db.php';

// recibir datos por JSON
$request = json_decode(file_get_contents("php://input"), true);

$id = $request['id'];

//preparar my query
$consulta = "DELETE FROM medicos WHERE id = :id";
// ejecutar la consulta
$stmt = $pdo->prepare($consulta);
$stmt->bindParam(':id', $id);
$stmt->execute();


// devolver el médico encontrado o un mensaje si no existe
echo json_encode([
    'message' => 'Médico Eliminado correctamente del Sistema'
]);

?>