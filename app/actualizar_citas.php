<?php
require_once '../conexion/db.php';
header('Content-Type: application/json');

try {
    $input = json_decode(file_get_contents('php://input'), true);

    $id = $input['id'] ?? '';
    $paciente_id = $input['paciente_id'] ?? '';
    $medico_id = $input['medico_id'] ?? '';
    $fecha = $input['fecha'] ?? '';
    $hora_inicio = $input['hora_inicio'] ?? '';
    $hora_fin = $input['hora_fin'] ?? '';
    $estado = $input['estado'] ?? '';

    // Validación básica
    if (empty($id) || empty($paciente_id) || empty($medico_id) || empty($fecha) || empty($hora_inicio) || empty($hora_fin) || empty($estado)) {
        echo json_encode(['success' => false, 'error' => 'Todos los campos son requeridos']);
        exit;
    }

    // Validar estado permitido
    $estados_validos = ['confirmada', 'pendiente', 'cancelada'];
    if (!in_array($estado, $estados_validos)) {
        echo json_encode(['success' => false, 'error' => 'Estado inválido']);
        exit;
    }

    // Verificar que paciente exista
    $stmt = $pdo->prepare("SELECT id FROM pacientes WHERE id = ?");
    $stmt->execute([$paciente_id]);
    if ($stmt->rowCount() === 0) {
        echo json_encode(['success' => false, 'error' => 'Paciente no encontrado']);
        exit;
    }

    // Verificar que médico exista
    $stmt = $pdo->prepare("SELECT id FROM medicos WHERE id = ?");
    $stmt->execute([$medico_id]);
    if ($stmt->rowCount() === 0) {
        echo json_encode(['success' => false, 'error' => 'Médico no encontrado']);
        exit;
    }

    // Verificar que la cita exista
    $stmt = $pdo->prepare("SELECT id FROM citas WHERE id = ?");
    $stmt->execute([$id]);
    if ($stmt->rowCount() === 0) {
        echo json_encode(['success' => false, 'error' => 'Cita no encontrada']);
        exit;
    }

    // Actualizar cita
    $sql = "UPDATE citas 
            SET paciente_id = ?, medico_id = ?, fecha = ?, hora_inicio = ?, hora_fin = ?, estado = ? 
            WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$paciente_id, $medico_id, $fecha, $hora_inicio, $hora_fin, $estado, $id]);

    // Siempre devolver success si la cita existe y se ejecutó la query
    echo json_encode(['success' => true, 'message' => 'Cita actualizada correctamente']);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => 'Error en la base de datos: ' . $e->getMessage()]);
}
?>
