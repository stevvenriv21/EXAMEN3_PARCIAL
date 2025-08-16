<?php
require_once './conexion/db.php';

// Obtener pacientes
$sqlPacientes = "SELECT * FROM pacientes";
$pacientes = $pdo->query($sqlPacientes)->fetchAll(PDO::FETCH_ASSOC);

// Obtener médicos
$sqlMedicos = "SELECT * FROM medicos";
$medicos = $pdo->query($sqlMedicos)->fetchAll(PDO::FETCH_ASSOC);


?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CLINICA CENTRAL RIO</title>
    <link rel="stylesheet" href="./public/lib/bootstrap-5.3.5-dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #232526 0%, #414345 100%);
            font-family: "Segoe UI", Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #e0e0e0;
        }
        .main-title {
            text-align: center;
            font-size: 2.2rem;
            font-weight: 700;
            color: #c9a86a;
            margin: 40px 0 28px 0;
            letter-spacing: 2px;
            text-shadow: 0 2px 12px #000a;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 24px;
            display: flex;
            gap: 24px;
            justify-content: center;
            flex-wrap: wrap;
        }
        .card {
            flex: 1 1 240px;
            min-width: 240px;
            max-width: 300px;
            background: linear-gradient(135deg, #232526 0%, #2c3e50 100%);
            border-radius: 14px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.35);
            padding: 32px 20px;
            margin-bottom: 20px;
            text-align: center;
            border: 1px solid #444;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .card:hover {
            transform: translateY(-6px) scale(1.03);
            box-shadow: 0 8px 32px rgba(201,168,106,0.18);
            border-color: #c9a86a;
        }
        .card h2 {
            color: #c9a86a;
            margin-bottom: 12px;
            font-size: 1.25rem;
            font-weight: 600;
            text-shadow: 0 1px 8px #0008;
        }
        .card .icon {
            font-size: 2.5rem;
            color: #c9a86a;
            margin-bottom: 12px;
            text-shadow: 0 2px 10px #000a;
        }
        .card .desc {
            font-size: 1rem;
            color: #bdbdbd;
            margin-bottom: 20px;
        }
        button, a.btn {
            background: linear-gradient(90deg, #c9a86a 0%, #8d6e63 100%);
            color: #232526;
            border: none;
            border-radius: 7px;
            padding: 10px 22px;
            margin: 0 6px 10px 0;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s, color 0.2s;
            box-shadow: 0 2px 8px #0004;
            text-decoration: none;
            display: inline-block;
        }
        button:hover, a.btn:hover {
            background: linear-gradient(90deg, #bfa05c 0%, #6d4c41 100%);
            color: #fff;
        }
        @media (max-width: 900px) {
            .container {
                gap: 12px;
            }
            .card {
                min-width: 200px;
                max-width: 100%;
            }
        }
        @media (max-width: 600px) {
            .main-title {
                font-size: 1.5rem;
                margin: 24px 0 14px 0;
            }
            .container {
                flex-direction: column;
                padding: 10px;
                gap: 0;
            }
            .card {
                padding: 20px 10px;
                margin-bottom: 14px;
            }
            button, a.btn {
                width: 100%;
                margin: 8px 0;
                font-size: 1.05rem;
            }
        }
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
    form {
        max-width: 600px;
        margin: 0 auto;
        background: linear-gradient(135deg, #232526 0%, #2c3e50 100%);
        padding: 30px 25px;
        border-radius: 14px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.35);
        border: 1px solid #444;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    form:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 32px rgba(201,168,106,0.18);
        border-color: #c9a86a;
    }
    label {
        display: block;
        margin-bottom: 6px;
        font-weight: 600;
        color: #c9a86a;
    }
    input[type="text"],
    input[type="email"],
    input[type="date"] {
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
    input:focus {
        border-color: #c9a86a;
        box-shadow: 0 0 6px rgba(201,168,106,0.4);
        outline: none;
    }
    input[type="submit"] {
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
        width: 100%;
    }
    input[type="submit"]:hover {
        background: linear-gradient(90deg, #bfa05c 0%, #6d4c41 100%);
        color: #fff;
        transform: translateY(-2px);
    }
    @media (max-width: 600px) {
        h1 {
            font-size: 1.5rem;
            margin: 24px 0 14px 0;
        }
        form {
            padding: 20px;
        }
        input[type="submit"] {
            font-size: 1.05rem;
        }
    }
    /* Estilo para modales */
.modal-content {
    background: linear-gradient(135deg, #232526 0%, #2c3e50 100%);
    color: #e0e0e0;
    border-radius: 14px;
    border: 1px solid #444;
    box-shadow: 0 4px 24px rgba(0,0,0,0.35);
    transition: transform 0.2s, box-shadow 0.2s;
}
.modal-content:hover {
    box-shadow: 0 8px 32px rgba(201,168,106,0.18);
    border-color: #c9a86a;
}
.modal-header {
    border-bottom: 1px solid #444;
}
.modal-title {
    color: #c9a86a;
    font-weight: 600;
    text-shadow: 0 1px 8px #0008;
}
.modal-body label {
    color: #c9a86a;
}
.modal-body input,
.modal-body select {
    background-color: #2a2a2a;
    border: 1px solid #555;
    color: #e0e0e0;
    border-radius: 8px;
}
.modal-body input:focus,
.modal-body select:focus {
    border-color: #c9a86a;
    box-shadow: 0 0 6px rgba(201,168,106,0.4);
}
.modal-footer {
    border-top: 1px solid #444;
}

    </style>
</head>
<body>
    
    <div class="main-title">CLINICA CENTRAL RIO</div>
    <div class="container">
        <div class="card">
            <div class="icon"><i class="bi bi-person-vcard"></i></div>
            <h2>Gestión de Pacientes</h2>
            <div class="desc">Administra el registro y consulta de pacientes.</div>

            <a href="#" class="btn btn-secondary mb-2" data-bs-toggle="modal" data-bs-target="#crearPacienteModal">Registrar Paciente</a>
            <button onclick="window.location.href='./app/listar_pacientes.php'">Listar Pacientes</button>
        </div>  

        <div class="card">
            <div class="icon"><i class="bi bi-person-badge"></i></div>
            <h2>Gestión de Médicos</h2>
            <div class="desc">Registra nuevos médicos y consulta el listado.</div>

            <!-- Botón modal con <a> -->
            <a href="#" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#crearMedicoModal">
                Registrar Médico
            </a>

            <a href="./app/listar_medicos.php" class="btn btn-secondary">
                Listar Médicos
            </a>
        </div>

        <div class="card">
            <div class="icon"><i class="bi bi-calendar-check"></i></div>
            <h2>Gestión de Citas</h2>
            <div class="desc">Crea y visualiza las citas médicas programadas.</div>
            <a href="#" class="btn btn-secondary mb-2" data-bs-toggle="modal" data-bs-target="#crearCitaModal">Crear Cita</a>

            <button onclick="window.location.href='./app/listar_citas.php'">Listar Citas</button>
        </div>
    </div>

    <!-- Modal Crear Médico -->
    <div class="modal fade" id="crearMedicoModal" tabindex="-1" aria-labelledby="crearMedicoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title text-primary" id="crearMedicoModalLabel">Crear Médico</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <div class="modal-body">
                    <form id="crear-medico">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre:</label>
                            <input type="text" id="nombre" name="nombre" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="especialidad" class="form-label">Especialidad:</label>
                            <input type="text" id="especialidad" name="especialidad" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="tarifa_por_hora" class="form-label">Tarifa por Hora:</label>
                            <input type="number" id="tarifa_por_hora" name="tarifa_por_hora" class="form-control" required>
                        </div>
                        <button type="submit" class="btn">Crear Médico</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal Crear Paciente -->
    <div class="modal fade" id="crearPacienteModal" tabindex="-1" aria-labelledby="crearPacienteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title text-primary" id="crearPacienteModalLabel">Crear Paciente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <div class="modal-body">
                    <form id="crear-paciente">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre:</label>
                            <input type="text" id="nombre" name="nombre" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo:</label>
                            <input type="email" id="correo" name="correo" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono:</label>
                            <input type="text" id="telefono" name="telefono" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento:</label>
                            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control" required>
                        </div>
                        
                        <button type="submit" class="btn">Crear Paciente</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal Crear Cita -->
    <div class="modal fade" id="crearCitaModal" tabindex="-1" aria-labelledby="crearCitaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title text-primary" id="crearCitaModalLabel">Crear Cita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <div class="modal-body">
                    <form id="crear-cita">
                        <div class="mb-3">
                            <label for="paciente_id" class="form-label">Paciente:</label>
                            <select id="paciente_id" name="paciente_id" class="form-select" required>
                                <option value="">Seleccione un paciente</option>
                                <?php foreach ($pacientes as $paciente): ?>
                                    <option value="<?php echo $paciente['id']; ?>"><?php echo htmlspecialchars($paciente['nombre']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="medico_id" class="form-label">Médico:</label>
                            <select id="medico_id" name="medico_id" class="form-select" required>
                                <option value="">Seleccione un médico</option>
                                <?php foreach ($medicos as $medico): ?>
                                    <option value="<?php echo $medico['id']; ?>"><?php echo htmlspecialchars($medico['nombre']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="fecha" class="form-label">Fecha:</label>
                            <input type="date" id="fecha" name="fecha" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="hora_inicio" class="form-label">Hora de Inicio:</label>
                            <input type="time" id="hora_inicio" name="hora_inicio" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="hora_fin" class="form-label">Hora de Fin:</label>
                            <input type="time" id="hora_fin" name="hora_fin" class="form-control" required>
                        </div>
                        <button type="submit" class="btn">Crear Cita</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="./public/lib/bootstrap-5.3.5-dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const formCrearMedico = document.getElementById('crear-medico');
        formCrearMedico.addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(formCrearMedico);
            fetch('./app/guardar_medico.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                Swal.fire('Genial', data, 'success');
                formCrearMedico.reset();
                // Cierra el modal automáticamente
                const modal = bootstrap.Modal.getInstance(document.getElementById('crearMedicoModal'));
                modal.hide();
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Ocurrió un problema al guardar', 'error');
            });
        });
    </script>

    <script>
        const formCrearPaciente = document.getElementById('crear-paciente');
        formCrearPaciente.addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(formCrearPaciente);
            fetch('./app/guardar_paciente.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                Swal.fire('Genial', data, 'success');
                formCrearPaciente.reset();
                // Cierra el modal automáticamente
                const modal = bootstrap.Modal.getInstance(document.getElementById('crearPacienteModal'));
                modal.hide();
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Ocurrió un problema al guardar', 'error');
            });
        });
    </script>




   <script>
const formCrearCita = document.getElementById('crear-cita');
formCrearCita.addEventListener('submit', function(event) {
    event.preventDefault();
    const formData = new FormData(formCrearCita);

    fetch('./app/guardar_cita.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        // Si el backend devuelve un texto que empieza con "ERROR"
        if (data.trim().toUpperCase().startsWith("ERROR")) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data
            });
        } else {
            Swal.fire({
                icon: 'success',
                title: 'Genial',
                text: data
            });
            formCrearCita.reset();
            // Cierra el modal automáticamente
            const modal = bootstrap.Modal.getInstance(document.getElementById('crearCitaModal'));
            modal.hide();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Ocurrió un problema al guardar'
        });
    });
});
</script>

</body>
</html>
