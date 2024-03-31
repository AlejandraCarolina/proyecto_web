<?php
    // Integramos el archivo de conexión a la base de datos
    include 'conexion.php';

    // Hacemos la consulta para obtener los registros de la tabla carreras
    $sql = "SELECT * FROM carreras";
    $result = $conn->query($sql);

    // Almacenamos los datos de las carreras en un array
    $carreras_data = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $carreras_data[] = $row;
        }
    }

    //función para exportar en XLS
    function exportToXLS($filename, $data) {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="' . $filename . '.xls"');

        echo '<table border="1">';
        foreach ($data as $row) {
            echo '<tr>';
            foreach ($row as $column) {
                echo '<td>' . $column . '</td>';
            }
            echo '</tr>';
        }
        echo '</table>';
    }

    if (isset($_POST['export_carreras'])) {
        exportToXLS('carreras', $carreras_data);
        exit();
    }
?>

<html lang="es">
<head>
    <title>Carreras</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
    <?php include "nav_bar.html"; ?>
    <div class="container mt-5">
        <a href="." class="btn btn-secondary mb-2">Regresar</a>
        <h2>Listado de Carreras</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($carreras_data as $row): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['nombre']; ?></td>
                    <td>
                        <a href="editar_carrera.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Editar</a>
                        <form class="d-inline" action="crud.php" method="GET">
                            <input type="hidden" name="id_carrera" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="btn btn-danger" name="eliminar_carrera">Eliminar</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="alta_carrera.php" class="btn btn-success">Agregar Carrera</a>
        <form action="" method="POST" class="d-inline">
            <input type="submit" name="export_carreras" value="Exportar a XLS" class="btn btn-info">
        </form>
        <br>
        <br>
    </div>
</body>
</html>
