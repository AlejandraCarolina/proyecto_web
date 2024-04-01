<html lang="es">
<head>
    <title>Alta de Alumnos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
</head>
<body>
    <?php include "nav_bar.html"; ?>
    <div class="container mt-5">
        <h2>Alta de Alumno</h2>
        <form action="crud.php" method="POST">
            <div class="form-group">
                <label for="matricula">Matricula:</label>
                <input type="text" class="form-control" id="matricula" name="matricula" required>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="correo">Email:</label>
                <input type="email" class="form-control" id="correo" name="correo" required>
            </div>
            <div class="form-group">
                <label for="id_carrera">Carrera:</label>
                <select class="form-control" id="id_carrera" name="id_carrera" required>
                    <option value="" selected disabled>Selecciona una carrera</option>
                    <?php
                        include 'conexion.php';
                        //consulta de id carrera
                        $sql_carrera = "SELECT * FROM carreras";
                        $result_carrera = $conn->query($sql_carrera);
                        while($row = $result_carrera->fetch_assoc()){
                    ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?></option>
                    <?php
                        }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="id_tutor">Tutor:</label>
                <select class="form-control" id="id_tutor" name="id_tutor" required>
                    <option value="" selected disabled>Selecciona un Tutor</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" name="alta_alumno">Agregar alumno</button>
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
                        $('#id_tutor').append("<option value='' selected disabled>Selecciona un Tutor</option>");
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