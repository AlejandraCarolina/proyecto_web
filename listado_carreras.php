<?php
    //integramos el archivo de conexión a la base de datos
    include 'conexion.php';

    //hacemos la consulta para obtener los registros de la tabla carreras
    $sql = "SELECT * FROM carreras";
    $result = $conn->query($sql);
?>

<html lang="es">
    <head>
        <title>Carreras</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">

    </head>
    <body>
    <?php include "nav_bar.html"; ?>
        <div class="container mt-5">
            <a href="." class="btn btn-secondary mb-2">Regresar</a>
            <h2>Listado de Carreras</h2>
            <!--<a href="alta_carrera.php" class="btn btn-primary">Agregar Carrera</a>-->
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        while($row = $result->fetch_assoc()){
                    ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['nombre']; ?></td>
                        <td>
                            <!-- el get se representa con el signo de "?" y el nombre de la variable-->
                            <a href="editar_carrera.php?id_carrera=<?php echo $row['id']; ?>" class="btn btn-primary">Editar</a>
                            <form class="d-inline" action="crud.php" method="POST">
                                <input type="hidden" name="id_carrera" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="btn btn-danger" name="eliminar_carrera">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    <?php
                      }
                    ?>
                </tbody>
            </table>
            <a href="alta_carrera.php" class="btn btn-success">Agregar Carrera</a>
<!--            <a href="exportar_carreras.php" class="btn btn-info">Exportar a XLS</a>-->
            <br>
            <br>
        </div>
    </body>
</html>
