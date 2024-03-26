<?php
include 'conexion.php';

// Consulta de Carreras
$sql = "SELECT * FROM carreras";
$result = $conn->query($sql);
?>

<html lang="es">
<head>
    <title>Alta de Asesorías</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
<?php include "nav_bar.html"; ?>
<div class="container mt-5 mb-5">
    <a href="listado_materias.php" class="btn btn-info mb-3">Regresar</a>
    <h2>Alta de Asesoría</h2>
    <form action="crud.php" method="POST">
        <div class="row row-cols-2">
            <div class="form-group col">
                <!-- Mostrar registros de Carreras -->
                <label for="carrera"><?= $result->num_rows == 0 ? 'No se encuentra ningúna carrera a la que se le pueda asignar' : 'Carrera:' ?></label>
                <select class="form-control" id="carrera" <?= $result->num_rows == 0 ? 'disabled' : ''?>>
                    <option value="0" selected disabled><?= $result->num_rows == 0 ? 'Sin carreras registradas' : 'Eliga una carrera' ?></option>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <option value="<?=$row['id']?>"><?=$row['nombre']?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group col">
                <!-- Mostrar registros de Materias de la Carrera seleccionada -->
                <label for="materia_carrera"><?= $result->num_rows == 0 ? 'No se encuentra ningúna materia asignada a esta carrera' : 'Materias:' ?></label>
                <select class="form-control" id="materia_carrera" <?= $result->num_rows == 0 ? 'disabled' : '' ?>>
                    <option value="0" selected disabled><?= $result->num_rows == 0 ? 'Sin carreras asignadas' : 'Eliga una materia' ?></option>
                    <!-- Más opciones através de JS -->
                </select>
            </div>
        </div>
        <div class="row row-cols-2">
            <div class="form-group col">
                <!-- Mostrar registros de Asesores de la Carrera seleccionada -->
                <label for="asesor"><?= $result->num_rows == 0 ? 'No se encuentra ningún asesor asignado a esta carrera' : 'Asesores:' ?></label>
                <select class="form-control" id="asesor" <?= $result->num_rows == 0 ? 'disabled' : '' ?>>
                    <option value="0" selected disabled><?= $result->num_rows == 0 ? 'Sin asesores asignados' : 'Eliga un Asesor' ?></option>
                    <!-- Más opciones através de JS -->
                </select>
            </div>
            <div class="form-group col">
                <!-- Mostrar registros de Alumnos del Asesor seleccionado -->
                <label for="alumno"><?= $result->num_rows == 0 ? 'No se encuentra ningún alumno asignado a este tutor' : 'Alumnos:' ?></label>
                <select class="form-control" id="alumno" <?= $result->num_rows == 0 ? 'disabled' : '' ?>>
                    <option value="0" selected disabled><?= $result->num_rows == 0 ? 'Sin alumnos asignados' : 'Eliga un Alumno' ?></option>
                    <!-- Más opciones através de JS -->
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary" name="alta_materia" <?=$result->num_rows == 0 ? 'disabled' : '' ?>>Agregar Materia</button>
    </form>
</div>
</body>
</html>

<script>
    // Consulta dinámica de datos dependiendo de su selección de Carrera
    // Uso de JQuery, AJAX y SweetAlert
    $(document).ready(function() {
        // Para select 'carrera'
        $('#carrera').change(function() {
            const id_carrera = $(this).val();
            if (id_carrera !== '0') {
                $.ajax({
                    type: 'POST',
                    url: 'crud.php',
                    data: {previa_asesoria_carrera: id_carrera},
                    dataType: 'json',
                    success: function(data) {
                        const materias = data.materias;
                        const materiasSelect = $('#materia_carrera');
                        materiasSelect.empty();
                        if (materias.length > 0) {
                            $.each(materias, function(key, materia_carrera) {
                                materiasSelect.append('<option value="' + materia_carrera.id + '">' + materia_carrera.nombre + '</option>');
                            });
                        } else {
                            materiasSelect.append('<option value="0" selected disabled>Sin materias asignadas</option>');
                        }
                        materiasSelect.prop('disabled', false);

                        const asesores = data.asesores;
                        const asesoresSelect = $('#asesor');
                        asesoresSelect.empty();
                        if (asesores.length > 0) {
                            $.each(asesores, function(key, asesor) {
                                asesoresSelect.append('<option value="' + asesor.id + '">' + asesor.nombre + '</option>');
                            });
                        } else {
                            asesoresSelect.append('<option value="0" selected disabled>Sin asesores asignados</option>');
                        }
                        asesoresSelect.prop('disabled', false);
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            title:  "¡Error!",
                            text:   "Error al obtener las materias: " + error,
                            icon:   "error"
                        });
                    }
                });
            } else {
                $('#materia_carrera').empty().prop('disabled', true).append('<option value="0" selected disabled>Seleccione una carrera primero</option>');
            }
        });
    });
    // Para select 'asesores'
    $('#asesor').change(function () {
        const id_asesor = $(this).val();
        if(id_asesor !== '0') {
            $.ajax({
                type: 'POST',
                url: 'crud.php',
                data: {previa_asesoria_alumno: id_asesor},
                dataType: 'json',
                success: function (data) {
                    const alumnoSelect = $('#alumno')
                    alumnoSelect.empty();
                    if (data.length > 0) {
                        $.each(data, function (key, alumno) {
                            alumnoSelect.append('<option value="' + alumno.id + '">' + alumno.nombre + '</option>');
                        });
                    } else {
                        alumnoSelect.append('<option value="0" selected disabled>Sin alumnos asignados</option>');
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
        } else {
            $('#alumno').empty().prop('disabled', true).append('<option value="0" selected disabled>Seleccione una carrera primero</option>');
        }
    });
</script>
