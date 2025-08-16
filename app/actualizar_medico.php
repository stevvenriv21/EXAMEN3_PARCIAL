<?php
require_once '../conexion/db.php';

// recibir datos por JSON
$request = json_decode(file_get_contents("php://input"), true);

$id = $request['id'];
$nombre = $request['nombre'];
$especialidad = $request['especialidad'];
$tarifa_por_hora = $request['tarifa_por_hora'];

$consulta = "UPDATE medicos SET nombre = :nombre, especialidad = :especialidad, tarifa_por_hora = :tarifa_por_hora WHERE id = :id";
$stmt = $pdo->prepare($consulta);
$stmt->bindParam(':id', $id);
$stmt->bindParam(':nombre', $nombre);
$stmt->bindParam(':especialidad', $especialidad);
$stmt->bindParam(':tarifa_por_hora', $tarifa_por_hora);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "message" => "Médico actualizado correctamente"
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "No se pudo actualizar el médico"
    ]);
}
?>
<?php