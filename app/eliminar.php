<?php
require_once '../conexion/db.php';

// recibir datos por JSON
$request = json_decode(file_get_contents("php://input"), true);

$id = $request['id'];

//preparar my query
$consulta = "DELETE FROM pacientes WHERE id = :id";
// ejecutar la consulta
$stmt = $pdo->prepare($consulta);
$stmt->bindParam(':id', $id);
$stmt->execute();


// devolver el paciente encontrado o un mensaje si no existe
echo json_encode([
    'message' => 'Paciente Eliminado correctamente del Sistema'
]);

?>