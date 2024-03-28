<?php

// Conexión a la base de datos
include 'conexion.php';

// Consulta SQL para obtener todos los registros de la tabla alumnos
$sql = 'SELECT alumnos.id, alumnos.matricula, alumnos.nombre, alumnos.correo, 
        carreras.nombre as carrera_nombre, tutores.nombre as tutor_nombre FROM alumnos 
            LEFT JOIN carreras ON alumnos.id_carrera = carreras.id 
            LEFT JOIN tutores ON alumnos.id_tutor = tutores.id';
$result = $conn->query($sql);

?>

<html lang="es">
    <head>
        <title>Listado de Alumnos</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
        
    </head>
    <body>
    <?php include "nav_bar.html"; ?>

        <div class="container mt-5">
            <a href="." class="btn btn-secondary mb-2">Regresar</a>
            <h2> Listado de Alumnos</h2>
            <table class="table">
                <thead>
                <tr>
                    <th>ID Alumno</th>
                    <th>Matrícula</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Carrera</th>
                    <th>Tutor</th>
                    <th>Accion</th>
                </tr>
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
                        <td><?php echo $row['correo'];?></td>
                        <td><?= $row['carrera_nombre'] == null ? '<em>Sin asignar</em>' : $row['carrera_nombre'] ?></td>
                        <td><?= $row['tutor_nombre'] == null ? '<em>Sin asignar</em>' : $row['tutor_nombre'] ?></td>
                        <td>
                                <a href="editar_alumno.php?id=<?= $row['id']?>" class="btn btn-primary">Editar</a>
                                <a href="crud.php?eliminar_alumno=<?= $row['id']?>" class="btn btn-danger">Eliminar</a>
<!--                                <a href="ver_calificaciones.php?id=--><?php //= $row['id']; ?><!--" class="btn btn-secondary">Ver calificaciones</a>-->
                        </td>
                    </tr>
                    <?php } ?>

                </tbody>
            </table>
            <a href="alta_alumno.php" class="btn btn-success">Agregar Alumno</a>
<!--            <a href="exportar_alumnos.php" class="btn btn-info">Exportar a Excel</a>-->
            <br>
            <br>
        </div>
    </body>
</html>