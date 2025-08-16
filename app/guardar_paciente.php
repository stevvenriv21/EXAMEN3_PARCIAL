<?php
// conecar a base de datos con conexion/db.php
require_once '../conexion/db.php';

// recibir los datos del formulario

    $nombres= $_POST['nombre'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    
    $fecha_actual = date('Y-m-d');
    if ($fecha_nacimiento > $fecha_actual) {
        echo "ERROR: La fecha de nacimiento no puede ser mayor a hoy.";
        exit;
    }

    //  ingresar los datos en la base de datos
    $sql = "INSERT INTO pacientes (nombre, correo, telefono, fecha_nacimiento) VALUES (:nombre, :correo, :telefono, :fecha_nacimiento)";
    // enviar varias con binparam para evitar inyeccion sql
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nombre', $nombres);
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':telefono', $telefono);
    $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);
    if ($stmt->execute()) {
    echo "El usuario $nombres ha sido creado";
} else {
    echo "Error al crear el usuario";
}
?>