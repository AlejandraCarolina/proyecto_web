<html>
<head>
    <title>Editar Alumno</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
</head>
<body>
<?php include "nav_bar.html"; ?>
<div class="container mt-5">
    <h2>Editar Alumno</h2>
    <?php
    include 'conexion.php';

    // Verificamos si se ha enviado el ID del alumno a editar
    if(isset($_GET['id'])) {
        $id_alumno = $_GET['id'];

        // Consulta para obtener los datos del alumno a editar
        $sql_alumno = "SELECT * FROM alumnos WHERE id = $id_alumno";
        $result_alumno = $conn->query($sql_alumno);

        if($result_alumno->num_rows > 0) {
            $alumno = $result_alumno->fetch_assoc();
        } else {
            echo "No se encontró ningún alumno con ese ID.";
            exit; 
        }
    } else {
        echo "ID del alumno no proporcionado.";
        exit;
    }
    ?>
    <form action="crud.php" method="POST">
        <input type="hidden" name="id_alumno" value="<?php echo $id_alumno; ?>">
        <div class="form-group">
            <label for="matricula">Matricula:</label>
            <input type="text" class="form-control" id="matricula" name="matricula" value="<?php echo $alumno['matricula']; ?>" required>
        </div>
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $alumno['nombre']; ?>" required>
        </div>
        <div class="form-group">
            <label for="correo">Correo:</label>
            <input type="email" class="form-control" id="correo" name="correo" value="<?php echo $alumno['correo']; ?>" required>
        </div>
        <div class="form-group">
            <label for="id_carrera">Carrera:</label>
            <select class="form-control" id="id_carrera" name="id_carrera" required>
                <option value="">Selecciona una carrera</option>
                <?php
                // Consulta para obtener las carreras
                $sql_carrera = "SELECT * FROM carreras";
                $result_carrera = $conn->query($sql_carrera);

                while($row = $result_carrera->fetch_assoc()) {
                    $selected = ($row['id'] == $alumno['id_carrera']) ? 'selected' : '';
                    echo "<option value='".$row['id']."' ".$selected.">".$row['nombre']."</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="id_tutor">Tutor:</label>
            <select class="form-control" id="id_tutor" name="id_tutor" required>
                <option value="">Selecciona un Tutor</option>
                <?php
                // Consulta para obtener los tutores
                $sql_tutor = "SELECT * FROM tutores";
                $result_tutor = $conn->query($sql_tutor);

                while($row = $result_tutor->fetch_assoc()) {
                    $selected = ($row['id'] == $alumno['id_tutor']) ? 'selected' : '';
                    echo "<option value='".$row['id']."' ".$selected.">".$row['nombre']."</option>";
                }
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary" name="cambio_alumno">Guardar cambios</button>
    </form>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#id_carrera').change(function(){
                var carrera_id = $(this).val();
                $.ajax({
                    url: 'obtener_tutores.php',
                    type: 'post',
                    data: {carrera_id: carrera_id},
                    dataType: 'json',
                    success:function(response){
                        var len = response.length;
                        $('#id_tutor').empty();
                        $('#id_tutor').append("<option value=''>Selecciona un Tutor</option>");
                        for( var i = 0; i<len; i++){
                            var id = response[i]['id'];
                            var nombre = response[i]['nombre'];
                            $('#id_tutor').append("<option value='"+id+"'>"+nombre+"</option>");
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>