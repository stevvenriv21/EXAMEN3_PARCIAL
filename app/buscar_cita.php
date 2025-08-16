<?php
require_once '../conexion/db.php';
header('Content-Type: application/json');

try {
    // Recibir datos JSON
    $input = json_decode(file_get_contents('php://input'), true);
    $id = $input['id'] ?? '';
    
    if (empty($id)) {
        echo json_encode(['error' => 'ID es requerido']);
        exit;
    }
    
    // Traer datos de la cita incluyendo paciente y médico
    $sql = "SELECT 
                c.id, 
                c.paciente_id, 
                p.nombre AS paciente_nombre,
                c.medico_id,
                m.nombre AS medico_nombre,
                c.fecha, 
                c.hora_inicio, 
                c.hora_fin, 
                c.estado
            FROM citas c
            INNER JOIN pacientes p ON c.paciente_id = p.id
            INNER JOIN medicos m ON c.medico_id = m.id
            WHERE c.id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $cita = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($cita) {
        echo json_encode($cita);
    } else {
        echo json_encode(['error' => 'Cita no encontrada']);
    }
    
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
}
?>
