<?php
    include 'conexion.php';
    $id_carrera = $_GET['id'];
    $sql_carrera = "SELECT * FROM carreras WHERE id = $id_carrera";
    $result_carrera = $conn->query($sql_carrera);
    $row_carrera = $result_carrera->fetch_assoc();
?>

<html lang="es">
    <head>
        <title>Editar Carrera</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    </head>
    <body>
        <?php include "nav_bar.html"; ?>
        <div class="container mt-5">
            <a href="listado_carreras.php" class="btn btn-secondary mb-3">Regresar</a>
            <h2>Editar Carrera</h2>
            <form action="crud.php" method="POST">
                <input type="hidden" name="id" value="<?=$row_carrera['id']?>">

                <div class="form-group">
                    <label for="nombre">Nombre de la carrera:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?= $row_carrera['nombre']?>" required>
                </div>
                <button type="submit" class="btn btn-primary" name="cambio_carrera">Editar carrera</button>
            </form>
        </div>
    </body>
</html>