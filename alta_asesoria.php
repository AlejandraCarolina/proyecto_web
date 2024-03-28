<?php
include 'conexion.php';

// Consulta de Carreras
$sql = "SELECT * FROM carreras";
$result = $conn->query($sql);
?>

<html lang="es">
<head>
    <title>Alta de Asesorías</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
</head>
<body>
<?php include "nav_bar.html"; ?>
<div class="container mt-5 mb-5">
    <a href="listado_asesorias.php" class="btn btn-info mb-3">Regresar</a>
    <h2>Alta de Asesoría</h2>
    <form action="crud.php" method="POST">
        <div class="row row-cols-3">
            <div class="form-group col">
                <!-- Mostrar registros de Carreras -->
                <label for="carrera"><?= $result->num_rows == 0 ? 'No se encuentra ningúna carrera a la que se le pueda asignar' : 'Carrera:' ?></label>
                <select class="form-control" name="carrera" id="carrera" <?= $result->num_rows == 0 ? 'disabled' : ''?>>
                    <option value="0" selected disabled><?= $result->num_rows == 0 ? 'Sin carreras registradas' : 'Seleccione una carrera' ?></option>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <option value="<?=$row['id']?>"><?=$row['nombre']?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group col">
                <!-- Mostrar registros de Materias de la Carrera seleccionada -->
                <label for="materia_carrera"><?= $result->num_rows == 0 ? 'No se encuentra ningúna materia asignada a esta carrera' : 'Materia:' ?></label>
                <select class="form-control" name="materia" id="materia_carrera" disabled>
                    <option value="0" selected disabled><?= $result->num_rows == 0 ? 'Sin carreras asignadas' : 'Seleccione una carrera primero' ?></option>
                    <!-- Más opciones através de JS -->
                </select>
            </div>
            <div class="form-group col">
                <label for="fecha_asesoria">Fecha:</label>
                <input type="date" class="form-control" name="fecha" id="fecha_asesoria" required>
            </div>
        </div>
        <div class="row row-cols-2">
            <div class="form-group col">
                <!-- Mostrar registros de Asesores de la Carrera seleccionada -->
                <label for="asesor"><?= $result->num_rows == 0 ? 'No se encuentra ningún asesor asignado a esta carrera' : 'Asesor:' ?></label>
                <select class="form-control" name="asesor" id="asesor" disabled>
                    <option value="0" selected disabled><?= $result->num_rows == 0 ? 'Sin asesores asignados' : 'Seleccione una carrera primero' ?></option>
                    <!-- Más opciones através de JS -->
                </select>
            </div>
            <div class="form-group col">
                <!-- Mostrar registros de Alumnos del Asesor seleccionado -->
                <label for="alumno"><?= $result->num_rows == 0 ? 'No se encuentra ningún alumno asignado a este tutor' : 'Alumno:' ?></label>
                <select class="form-control" name="alumno" id="alumno" disabled>
                    <option value="0" selected disabled><?= $result->num_rows == 0 ? 'Sin alumnos asignados' : 'Seleccione un asesor primero' ?></option>
                    <!-- Más opciones através de JS -->
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="observaciones">Observaciones</label>
            <textarea rows="2" name="observaciones" id="observaciones" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary" id="envio" name="alta_asesoria" <?=$result->num_rows == 0 ? 'disabled' : '' ?>>Agregar Asesoria</button>
    </form>
</div>
</body>
</html>

<script>
    // Consulta dinámica de datos dependiendo de su selección de Carrera
    // Uso de JQuery, AJAX y SweetAlert
    $(document).ready(function() {
        // Instanciar selects
        const carreraSelect = $('#carrera');
        const materiaSelect = $('#materia_carrera');
        const asesorSelect = $('#asesor');
        const alumnoSelect = $('#alumno');

        // Para select 'carrera'
        carreraSelect.change(function() {
            const id_carrera = $(this).val();
            $.ajax({
                type: 'POST',
                url: 'crud.php',
                data: {q_materia_carrera: id_carrera},
                dataType: 'json',
                success: function(data) {
                    const materias = data.materias;
                    materiaSelect.empty();
                    if (materias.length > 0) {
                        materiaSelect.prop('disabled', false);
                        materiaSelect.append('<option value="0" selected disabled>Selecccione una materia</option>');
                        $.each(materias, function(key, materia_carrera) {
                            materiaSelect.append('<option value="' + materia_carrera.id + '">' + materia_carrera.nombre + '</option>');
                        });
                    } else{
                        materiaSelect.append('<option value="0" selected disabled>Sin materias asignadas</option>');
                        materiaSelect.prop('disabled', true);
                    }

                    const asesores = data.a_t;
                    asesorSelect.empty();
                    if (asesores.length > 0) {
                        asesorSelect.prop('disabled', false);
                        asesorSelect.append('<option value="0" selected disabled>Seleccione un asesor</option>');
                        $.each(asesores, function(key, asesor) {
                            asesorSelect.append('<option value="' + asesor.id + '">' + asesor.nombre + '</option>');
                        });
                    } else{
                        asesorSelect.append('<option value="0" selected disabled>Sin asesores asignados</option>');
                        asesorSelect.prop('disabled', true);
                    }

                    alumnoSelect.empty();
                    alumnoSelect.append('<option value="0" selected disabled>Seleccione un asesor primero</option>');
                    alumnoSelect.prop('disabled', true);
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title:  "¡Error!",
                        text:   "Error al obtener las materias: " + error,
                        icon:   "error"
                    });
                }
            });
        });

        // Para select 'asesor'
        asesorSelect.change(function () {
            const id_asesor = $(this).val();
            $.ajax({
                type: 'POST',
                url: 'crud.php',
                data: {q_alumno_tutor: id_asesor},
                dataType: 'json',
                success: function (data) {
                    alumnoSelect.empty();
                    if (data.length > 0) {
                        alumnoSelect.prop('disabled', false);
                        alumnoSelect.append('<option value="0" selected disabled>Seleccione un alumno</option>');
                        $.each(data, function (key, alumno) {
                            alumnoSelect.append('<option value="' + alumno.id + '">' + alumno.nombre + '</option>');
                        });
                    } else {
                        alumnoSelect.append('<option value="0" selected disabled>Sin alumnos asignados</option>');
                        alumnoSelect.prop('disabled', true);
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title:  "¡Error!",
                        text:   "Error al obtener los alumnos: " + error,
                        icon:   "error"
                    });
                }
            });
        });

        // Validación de selects
        $('#envio').on("click", function (event) {
            if(carreraSelect.val() == null || materiaSelect.val() == null || asesorSelect.val() == null || alumnoSelect.val() == null) {
                event.preventDefault();

                Swal.fire({
                    title:  "¡Advertencia!",
                    text:   "Falto alguna seleccion entre: carrera, materia, asesor o alumno. Asegurese de seleccionar todos los campos",
                    icon:   "warning"
                });
            }
        });
    });
</script>
