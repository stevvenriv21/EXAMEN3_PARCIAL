<?php
require_once '../conexion/db.php';

$sql = "SELECT 
            c.id,
            p.nombre AS paciente_nombre,
            m.nombre AS medico_nombre,
            c.fecha,
            c.hora_inicio,
            c.hora_fin,
            c.duracion,
            c.costo_total,
            c.estado
        FROM citas c
        INNER JOIN pacientes p ON c.paciente_id = p.id
        INNER JOIN medicos m ON c.medico_id = m.id
        ORDER BY c.fecha DESC, c.hora_inicio ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$citas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Lista de Citas</title>
    <link rel="stylesheet" href="../public/lib/bootstrap-5.3.5-dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" />
    <style>
    body {
        background: linear-gradient(135deg, #232526 0%, #414345 100%);
        font-family: "Segoe UI", Arial, sans-serif;
        margin: 0;
        padding: 0;
        color: #e0e0e0;
    }
    .container {
        max-width: 95%;
        margin: 0 auto;
        padding: 24px;
    }

    /* TABLA MÁS ANCHA Y COMPACTA VERTICALMENTE */
    .table-responsive {
        width: 100%;
        overflow-x: auto;
        margin-bottom: 20px;
    }
    #tabla-citas {
        width: 100%;
        table-layout: auto;
        border-collapse: collapse; /* unificar bordes */
    }
    #tabla-citas th, #tabla-citas td {
        padding: 8px 18px; /* vertical y horizontal */
        text-align: center;
        vertical-align: middle;
        border: 1px solid #444; /* bordes iguales para todo */
        background-color: #2a2a2a; /* mismo fondo que las filas */
        color: #e0e0e0;
    }
    #tabla-citas thead th {
        background-color: #2a2a2a; /* mismo fondo que celdas normales */
        font-weight: 600;
    }
    .text-center {
    text-align: center !important;
}
.d-flex.justify-content-center {
    display: flex;
    justify-content: center;
}
    #tabla-citas tbody tr {
        transition: all 0.3s;
    }
    #tabla-citas tbody tr:hover {
        background-color: #414345;
    }

    button, a.btn {
        background: linear-gradient(90deg, #c9a86a 0%, #8d6e63 100%);
        color: #232526;
        border: none;
        border-radius: 7px;
        padding: 6px 14px;
        margin: 2px 2px;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s, color 0.2s, transform 0.2s;
        box-shadow: 0 2px 6px #0004;
        text-decoration: none;
        display: inline-block;
    }
    button:hover, a.btn:hover {
        background: linear-gradient(90deg, #bfa05c 0%, #6d4c41 100%);
        color: #fff;
        transform: translateY(-2px);
    }

    @media (max-width: 900px) {
        #tabla-citas th, #tabla-citas td {
            padding: 6px 12px;
        }
    }
    @media (max-width: 600px) {
        #tabla-citas th, #tabla-citas td {
            font-size: 0.85rem;
            padding: 6px 8px;
        }
    }
    /* Aumentar ancho horizontal solo para Médico y Fecha */
#tabla-citas th:nth-child(3),
#tabla-citas td:nth-child(3) {
    min-width: 140px; /* columna Médico */
}

#tabla-citas th:nth-child(4),
#tabla-citas td:nth-child(4) {
    min-width: 140px; /* columna Fecha */
}
/* Estilo para modal de editar usuario igual a notas */
.modal-content {
    background: linear-gradient(135deg, #232526 0%, #2c3e50 100%);
    border-radius: 14px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.35);
    border: 1px solid #444;
    transition: transform 0.2s, box-shadow 0.2s;
    color: #e0e0e0;
}

.modal-content:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 32px rgba(201,168,106,0.18);
    border-color: #c9a86a;
}

.modal-header {
    border-bottom: none;
    background: linear-gradient(135deg, #232526 0%, #2c3e50 100%);
    color: #c9a86a;
}

.modal-header .modal-title {
    font-weight: 600;
}

.modal-body label {
    display: block;
    margin-bottom: 6px;
    font-weight: 600;
    color: #c9a86a;
}

.modal-body input[type="text"],
.modal-body input[type="email"],
.modal-body input[type="date"] {
    width: 100%;
    padding: 10px 12px;
    margin-bottom: 18px;
    border: 1px solid #555;
    border-radius: 8px;
    background-color: #2a2a2a;
    color: #e0e0e0;
    font-size: 1rem;
    transition: border-color 0.2s, box-shadow 0.2s;
}

.modal-body input:focus {
    border-color: #c9a86a;
    box-shadow: 0 0 6px rgba(201,168,106,0.4);
    outline: none;
}

.modal-footer {
    border-top: none;
    justify-content: flex-end;
}

.modal-footer button {
    background: linear-gradient(90deg, #c9a86a 0%, #8d6e63 100%);
    color: #232526;
    border: none;
    border-radius: 7px;
    padding: 10px 22px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s, color 0.2s, transform 0.2s;
    box-shadow: 0 2px 8px #0004;
}

.modal-footer button:hover {
    background: linear-gradient(90deg, #bfa05c 0%, #6d4c41 100%);
    color: #fff;
    transform: translateY(-2px);
}


</style>


</head>
<body class="p-4">

<div class="container text-center">
    <h3 class="mb-4"><i class="bi bi-calendar2-check"></i> Lista de Citas</h3>

    <div class="mb-3 text-center">
        <span class="badge bg-primary fs-6 px-3 py-2">
            <i class="bi bi-list-check"></i>
            Total: <?php echo count($citas); ?> registro<?php echo count($citas) != 1 ? 's' : ''; ?>
        </span>
    </div>

<div class="table-responsive rounded-3">
    <table class="table align-middle text-center" id="tabla-citas" style="width:95%; margin:0 auto; border-collapse: separate; border-spacing: 0 8px;">
        <thead style="background-color:#c9a86a; color:#232526;">
            <tr>
                <th>ID</th>
                <th>Paciente</th>
                <th>Médico</th>
                <th>Fecha</th>
                <th>Hora Inicio</th>
                <th>Hora Fin</th>
                <th>Duración</th>
                <th>Costo Total</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($citas as $cita): ?>
                <tr id="fila-<?php echo htmlspecialchars($cita['id']); ?>" style="background:#2a2a2a; box-shadow:0 2px 6px #0004; border-radius:8px; transition: all 0.3s;">
                    <td><?php echo htmlspecialchars($cita['id']); ?></td>
                    <td><i class="bi bi-person-circle text-primary me-1"></i><?php echo htmlspecialchars($cita['paciente_nombre']); ?></td>
                    <td><i class="bi bi-person-badge text-success me-1"></i><?php echo htmlspecialchars($cita['medico_nombre']); ?></td>
                    <td><?php echo htmlspecialchars($cita['fecha']); ?></td>
                    <td><?php echo htmlspecialchars($cita['hora_inicio']); ?></td>
                    <td><?php echo htmlspecialchars($cita['hora_fin']); ?></td>
                    <td><?php echo htmlspecialchars($cita['duracion']); ?> min</td>
                    <td>$<?php echo number_format($cita['costo_total'], 2); ?></td>
                    <td>
                        <?php if ($cita['estado'] == 'confirmada'): ?>
                            <span class="badge bg-success">Confirmada</span>
                        <?php elseif ($cita['estado'] == 'pendiente'): ?>
                            <span class="badge bg-warning text-dark">Pendiente</span>
                        <?php else: ?>
                            <span class="badge bg-secondary"><?php echo htmlspecialchars($cita['estado']); ?></span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <button class="btn btn-warning btn-sm btn-editar-cita" data-id="<?php echo htmlspecialchars($cita['id']); ?>">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-danger btn-sm btn-eliminar-cita" data-id="<?php echo htmlspecialchars($cita['id']); ?>"
                                data-paciente="<?php echo htmlspecialchars($cita['paciente_nombre']); ?>"
                                data-medico="<?php echo htmlspecialchars($cita['medico_nombre']); ?>">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


    <div class="mt-3 d-flex justify-content-center">
        <a href="../index.php" class="btn btn-secondary me-2">
            <i class="bi bi-arrow-left"></i> Volver al Menú
        </a>
    </div>
</div>

<!-- Modal para editar cita -->
<!-- Modal para editar cita -->
<div class="modal fade" id="editarCita" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-pencil"></i> Editar Cita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="cita_id" />

                <div class="mb-3">
                    <label for="edit_paciente" class="form-label">Paciente</label>
                    <select class="form-select" id="edit_paciente">
                        <?php
                        $sqlPacientes = "SELECT id, nombre FROM pacientes ORDER BY nombre ASC";
                        $stmtPac = $pdo->prepare($sqlPacientes);
                        $stmtPac->execute();
                        $pacientes = $stmtPac->fetchAll(PDO::FETCH_ASSOC);
                        foreach($pacientes as $p) {
                            echo "<option value='{$p['id']}'>{$p['nombre']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="edit_medico" class="form-label">Médico</label>
                    <select class="form-select" id="edit_medico">
                        <?php
                        $sqlMedicos = "SELECT id, nombre FROM medicos ORDER BY nombre ASC";
                        $stmtMed = $pdo->prepare($sqlMedicos);
                        $stmtMed->execute();
                        $medicos = $stmtMed->fetchAll(PDO::FETCH_ASSOC);
                        foreach($medicos as $m) {
                            echo "<option value='{$m['id']}'>{$m['nombre']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="edit_fecha" class="form-label">Fecha</label>
                    <input type="date" class="form-control" id="edit_fecha" required>
                </div>

                <div class="mb-3">
                    <label for="edit_hora_inicio" class="form-label">Hora Inicio</label>
                    <input type="time" class="form-control" id="edit_hora_inicio" required>
                </div>

                <div class="mb-3">
                    <label for="edit_hora_fin" class="form-label">Hora Fin</label>
                    <input type="time" class="form-control" id="edit_hora_fin" required>
                </div>

                <div class="mb-3">
                    <label for="edit_estado" class="form-label">Estado</label>
                    <select class="form-select" id="edit_estado">
                        <option value="confirmada">Confirmada</option>
                        <option value="pendiente">Pendiente</option>
                        <option value="cancelada">Cancelada</option>
                    </select>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btn-actualizar-cita">
                    <i class="bi bi-save"></i> Actualizar Cita
                </button>
            </div>
        </div>
    </div>
</div>


<script src="../public/lib/bootstrap-5.3.5-dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
const modal = new bootstrap.Modal(document.getElementById('editarCita'));

// Eventos en la tabla
document.getElementById('tabla-citas').addEventListener('click', function(e) {
    const editBtn = e.target.closest('.btn-editar-cita');
    if (editBtn) {
        cargarCita(editBtn.dataset.id);
    }
    const deleteBtn = e.target.closest('.btn-eliminar-cita');
    if (deleteBtn) {
        eliminarCita(deleteBtn.dataset.id, deleteBtn.dataset.paciente, deleteBtn.dataset.medico);
    }
});

// Cargar datos de cita en modal
function cargarCita(id) {
    fetch('buscar_cita.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id })
    })
    .then(r => r.json())
    .then(cita => {
    document.getElementById('cita_id').value = cita.id;
    document.getElementById('edit_fecha').value = cita.fecha;
    document.getElementById('edit_hora_inicio').value = cita.hora_inicio;
    document.getElementById('edit_hora_fin').value = cita.hora_fin;

    // Seleccionar paciente y médico
    const selectPaciente = document.getElementById('edit_paciente');
    for (let i = 0; i < selectPaciente.options.length; i++) {
        if (selectPaciente.options[i].text === cita.paciente_nombre) {
            selectPaciente.selectedIndex = i;
            break;
        }
    }

    const selectMedico = document.getElementById('edit_medico');
    for (let i = 0; i < selectMedico.options.length; i++) {
        if (selectMedico.options[i].text === cita.medico_nombre) {
            selectMedico.selectedIndex = i;
            break;
        }
    }

    // Estado
    const selectEstado = document.getElementById('edit_estado');
    for (let i = 0; i < selectEstado.options.length; i++) {
        if (selectEstado.options[i].value === cita.estado.toLowerCase()) {
            selectEstado.selectedIndex = i;
            break;
        }
    }

    modal.show();
})
    .catch(err => {
        console.error(err);
        Swal.fire('Error', 'No se pudo cargar la cita', 'error');
    });
}

// Actualizar cita
document.getElementById('btn-actualizar-cita').addEventListener('click', function() {
    const datos = {
        id: document.getElementById('cita_id').value,
        fecha: document.getElementById('edit_fecha').value,
        hora_inicio: document.getElementById('edit_hora_inicio').value,
        hora_fin: document.getElementById('edit_hora_fin').value,
        estado: document.getElementById('edit_estado').value,
        paciente_id: document.getElementById('edit_paciente').value, // nuevo
        medico_id: document.getElementById('edit_medico').value      // nuevo
    };

    fetch('actualizar_citas.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(datos)
    })
    .then(r => r.json())
    .then(resp => {
        if (resp.success) {
            Swal.fire('Actualizado', 'Cita actualizada correctamente', 'success')
                 .then(() => location.reload());
            modal.hide();
        } else {
            Swal.fire('Error', resp.error, 'error');
        }
    })
    .catch(err => {
        console.error(err);
        Swal.fire('Error', 'No se pudo actualizar la cita', 'error');
    });
});


// Eliminar cita
function eliminarCita(id, paciente, medico) {
    Swal.fire({
        title: '¿Eliminar cita?',
        html: `<strong>Paciente:</strong> ${paciente}<br><strong>Médico:</strong> ${medico}`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('eliminar_cita.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id })
            })
            .then(r => r.json())
            .then(resp => {
                if (resp.success) {
                    Swal.fire('Eliminada', resp.message, 'success');
                    document.getElementById('fila-' + id).remove();
                } else {
                    Swal.fire('Error', resp.error, 'error');
                }
            })
            .catch(err => {
                console.error(err);
                Swal.fire('Error', 'No se pudo eliminar la cita', 'error');
            });
        }
    });
}
</script>

</body>
</html>
