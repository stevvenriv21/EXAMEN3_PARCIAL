<?php
require_once '../conexion/db.php';

// recibir datos por JSON
$request = json_decode(file_get_contents("php://input"), true);

$id = $request['id'];
$nombre = $request['nombre'];
$correo = $request['correo'];
$telefono = $request['telefono'];
$fecha_nacimiento = $request['fecha_nacimiento'];

$consulta = "UPDATE pacientes SET nombre = :nombre, correo = :correo, telefono = :telefono, fecha_nacimiento = :fecha_nacimiento WHERE id = :id";
$stmt = $pdo->prepare($consulta);
$stmt->bindParam(':id', $id);
$stmt->bindParam(':nombre', $nombre);
$stmt->bindParam(':correo', $correo);
$stmt->bindParam(':telefono', $telefono);
$stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "message" => "Paciente actualizado correctamente"
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "No se pudo actualizar el paciente"
    ]);
}
?>
<?php