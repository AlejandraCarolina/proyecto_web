<?php

// Conexión a la base de datos
include 'conexion.php';

// Consulta SQL para obtener todos los registros de la tabla alumnos
$sql = 'SELECT alumnos.id, alumnos.matricula, alumnos.nombre, alumnos.edad, alumnos.email, 
carrera.nombre as carrera_nombre FROM alumnos INNER JOIN carrera ON alumnos.id_carrera = carrera.id_carrera';
$result = $conn->query($sql);

?>

<html lang="es">
    <head>
        <title>Listado de Alumnos</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
        
    </head>
    <body>
        
        <div class="container mt-5">
            <h2> Listado de Alumnos</h2>
            <table class="table">
                <thead>
                    <th>ID Alumno</th>
                    <th>Matrícula</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Carrera</th>
                    <th>Tutor</th>
                    <th>Accion</th>
                </thead>
                <tbody>
                    <?php 

                        // Recorrido en la tabla de carreras para obtener los registros
                        while ($row = $result->fetch_assoc()){ 
                    ?>
                    <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['matricula'];?></td>
                    <td><?php echo $row['nombre'];?></td>
                    <td><?php echo $row['email'];?></td>
                    <td><?php echo $row['carrera_nombre'];?></td>
                    <td><?php echo $row['tutor_nombre'];?></td>
                    <td>
                            <a href="editar_alumno.php?id=<?= $row['id']?>" class="btn btn-primary">Editar</a>
                            <a href="crud.php?eliminar_alumno=<?= $row['id']?>" class="btn btn-danger">Eliminar</a>
                            <a href="ver_calificaciones.php?id=<?= $row['id']; ?>" class="btn btn-secondary">Ver calificaciones</a>
                    </td>
                    </tr>
                    <?php } ?>

                </tbody>
            </table>
            <a href="alta_alumno.php" class="btn btn-success">Agregar Alumno</a>
            <a href="exportar_alumnos.php" class="btn btn-info">Exportar a Excel</a>
            <br>
            <br>
           
        </form>

        </div>
    </body>
</html>