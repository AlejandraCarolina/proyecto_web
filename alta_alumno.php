<html>
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
                    <input type="correo" class="form-control" id="correo" name="correo" required>
                </div>
                <div class="form-group">
                    <label for="id_carrera">Carrera:</label>
                    <select class="form-control" id="id_carrera" name="id_carrera" required>
                        <option value="">Selecciona una carrera</option>
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
                        <option value="">Selecciona un Tutor</option>
                        <?php
                            include 'conexion.php';
                            //consulta de id carrera
                           $sql_tutor = "SELECT * FROM tutores";
                           $result_tutor = $conn->query($sql_tutor);
                           while($row = $result_tutor->fetch_assoc()){
                        ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?></option>
                        <?php
                           }
                        ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" name="alta_alumno">Agregar alumno</button>
            </form>
        </div>
    </body>
</html>