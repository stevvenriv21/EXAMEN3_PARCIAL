<?php 
require_once '../conexion/db.php';
$sql = "SELECT * FROM medicos";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$medicos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Lista de Usuarios</title>
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
        h1 {
            text-align: center;
            font-size: 2.2rem;
            font-weight: 700;
            color: #c9a86a;
            margin: 40px 0 28px 0;
            letter-spacing: 2px;
            text-shadow: 0 2px 12px #000a;
        }
        table {
            width: 90%;
            margin: 0 auto 40px auto;
            border-collapse: collapse;
        }
        table th, table td {
            padding: 12px 15px;
            border: 1px solid #555;
            text-align: center;
        }
        table th {
            background-color: #c9a86a;
            color: #232526;
        }
        table tr:nth-child(even) {
            background-color: #2a2a2a;
        }
        table tr:hover {
            background-color: #414345;
        }
        button, a.btn {
            background: linear-gradient(90deg, #c9a86a 0%, #8d6e63 100%);
            color: #232526;
            border: none;
            border-radius: 7px;
            padding: 8px 18px;
            margin: 4px 2px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s, color 0.2s;
            box-shadow: 0 2px 8px #0004;
            text-decoration: none;
        }
        button:hover, a.btn:hover {
            background: linear-gradient(90deg, #bfa05c 0%, #6d4c41 100%);
            color: #fff;
        }
        @media (max-width: 768px) {
            table, table th, table td {
                font-size: 0.85rem;
                padding: 8px 10px;
            }
            button, a.btn {
                font-size: 0.8rem;
                padding: 6px 12px;
            }
        }
        #tabla_medicos tr:hover {
        background: linear-gradient(90deg, #414345 0%, #232526 100%);
        transform: translateY(-2px);
    }

    #tabla_medicos th, #tabla_medicos td {
        padding: 12px 15px;
        font-weight: 500;
        border: none;
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
    }

    button:hover, a.btn:hover {
        background: linear-gradient(90deg, #bfa05c 0%, #6d4c41 100%);
        color: #fff;
        transform: translateY(-2px);
    }

    @media (max-width: 768px) {
        #tabla_medicos th, #tabla_medicos td {
            padding: 8px 10px;
            font-size: 0.85rem;
        }
        button, a.btn {
            font-size: 0.8rem;
            padding: 5px 10px;
        }
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
<body>
    <h1><i class="bi bi-people-fill"></i> Lista de Medicos</h1>

    <table id="tabla_medicos" class="table align-middle text-center" style="width:90%; margin:0 auto 40px auto; border-collapse: separate; border-spacing: 0 8px;">
    <thead>
        <tr style="background-color:#c9a86a; color:#232526; border-radius:10px;">
            <th>ID</th>
            <th>Nombre</th>
            <th>Especialidad</th>
            <th>Tarifa Por Hora</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($medicos as $medico): ?>
            <tr id="fila-<?php echo $medico['id']; ?>" style="background: #2a2a2a; transition: all 0.3s; box-shadow: 0 2px 6px #0004; border-radius:8px; margin-bottom:8px;">
                <td><?php echo $medico['id']; ?></td>
                <td><?php echo htmlspecialchars($medico['nombre']); ?></td>
                <td><?php echo htmlspecialchars($medico['especialidad']); ?></td>
                <td><?php echo $medico['tarifa_por_hora']; ?></td>
                <td>
                    <button type="button" class="btn btn-warning btn-editar-medico btn-sm" data-id="<?php echo $medico['id']; ?>">
                        <i class="bi bi-pencil-square"></i> Editar
                    </button>
                    <button type="button" class="btn btn-danger btn-eliminar-medico btn-sm" data-id="<?php echo $medico['id']; ?>" data-nombre="<?php echo htmlspecialchars($medico['nombre']); ?>">
                        <i class="bi bi-trash"></i> Eliminar
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

    <div class="text-center mb-4">
        <a href="../index.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Volver al Menú</a>
    </div>

    <!-- Modal para editar usuario sigue igual -->
    <div class="modal fade" id="modalEditarUsuario" tabindex="-1" aria-labelledby="modalEditarUsuarioLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content shadow rounded">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="modalEditarUsuarioLabel">Editar Usuario</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id" />
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" required />
                    </div>
                    <div class="mb-3">
                        <label for="especialidad" class="form-label">Especialidad</label>
                        <input type="text" class="form-control" id="especialidad" required />
                    </div>
                    <div class="mb-3">
                        <label for="tarifa_por_hora" class="form-label">Tarifa Por Hora</label>
                        <input type="text" class="form-control" id="tarifa_por_hora" required />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" id="btn-actualizar-usuario" class="btn btn-primary">Actualizar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../public/lib/bootstrap-5.3.5-dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const modalEditarUsuario = new bootstrap.Modal(document.getElementById('modalEditarUsuario'), { keyboard: false });

        document.getElementById('tabla_medicos').addEventListener('click', e => {
    if(e.target.closest('.btn-editar-medico')) { // clase correcta
        const btn = e.target.closest('.btn-editar-medico');
        const id = btn.dataset.id;

        fetch('buscar_medico_id.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: id })
        })
        .then(res => res.json())
        .then(data => {
            modalEditarUsuario.show();
            document.getElementById('id').value = data.id;
            document.getElementById('nombre').value = data.nombre;
            document.getElementById('especialidad').value = data.especialidad;
            document.getElementById('tarifa_por_hora').value = data.tarifa_por_hora;
        })
        .catch(() => {
            Swal.fire('Error', 'No se pudo cargar el médico', 'error');
        });
    }

    if(e.target.closest('.btn-eliminar-medico')) { // clase correcta
        const btn = e.target.closest('.btn-eliminar-medico');
        const id = btn.dataset.id;
        const nombre = btn.dataset.nombre;

        Swal.fire({
            title: '¿Estás seguro de eliminar al médico?',
            text: nombre,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then(result => {
            if(result.isConfirmed) {
                fetch('eliminar_medico.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: id })
                })
                .then(res => res.json())
                .then(data => {
                    Swal.fire('¡Listo!', data.message, 'success');
                    const fila = document.getElementById('fila-' + id);
                    if(fila) fila.remove();
                })
                .catch(() => {
                    Swal.fire('Error', 'No se pudo eliminar el médico', 'error');
                });
            }
        });
    }
});


        document.getElementById('btn-actualizar-usuario').addEventListener('click', () => {
            const id = document.getElementById('id').value;
            const nombre = document.getElementById('nombre').value.trim();
            const especialidad = document.getElementById('especialidad').value.trim();
            const tarifa_por_hora = document.getElementById('tarifa_por_hora').value.trim();

            if(!nombre || !especialidad || !tarifa_por_hora) {
                Swal.fire('Atención', 'Todos los campos son obligatorios', 'warning');
                return;
            }

            fetch('actualizar_medico.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id, nombre, especialidad, tarifa_por_hora })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    Swal.fire('¡Actualizado!', data.message, 'success').then(() => {
                    modalEditarUsuario.hide();
                    location.reload(); // recarga después de cerrar el modal
                });
                } else {
                    Swal.fire('Error', data.message || 'No se pudo actualizar', 'error');
                }
            })
            .catch(() => {
                Swal.fire('Error', 'Error en la actualización', 'error');
            });
        });
    });
    </script>
</body>
</html>
