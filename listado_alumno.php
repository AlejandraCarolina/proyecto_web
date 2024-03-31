<?php

// Conexión a la base de datos
include 'conexion.php';

// Consulta SQL para obtener todos los registros de la tabla alumnos
$sql = 'SELECT alumnos.id, alumnos.matricula, alumnos.nombre, alumnos.correo, 
        carreras.nombre as carrera_nombre, tutores.nombre as tutor_nombre FROM alumnos 
            LEFT JOIN carreras ON alumnos.id_carrera = carreras.id 
            LEFT JOIN tutores ON alumnos.id_tutor = tutores.id';
$result = $conn->query($sql);

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

$alumnos_data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $alumnos_data[] = $row;
    }
}

if (isset($_POST['export_alumnos'])) {
    exportToXLS('alumnos', $alumnos_data);
    exit();
}
?>

<html lang="es">
<head>
    <title>Listado de Alumnos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        <?php foreach ($alumnos_data as $row): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['matricula']; ?></td>
                <td><?php echo $row['nombre']; ?></td>
                <td><?php echo $row['correo']; ?></td>
                <td><?= $row['carrera_nombre'] == null ? '<em>Sin asignar</em>' : $row['carrera_nombre'] ?></td>
                <td><?= $row['tutor_nombre'] == null ? '<em>Sin asignar</em>' : $row['tutor_nombre'] ?></td>
                <td>
                    <a href="editar_alumno.php?id=<?= $row['id'] ?>" class="btn btn-primary">Editar</a>
                    <a href="crud.php?eliminar_alumno=<?= $row['id'] ?>" class="btn btn-danger"
                       onclick="return mostrarSweetAlert(<?php echo $row['id']; ?>)">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>

        </tbody>
    </table>
    <a href="alta_alumno.php" class="btn btn-success">Agregar Alumno</a>
    <form action="" method="POST" class="d-inline">
        <input type="submit" name="export_alumnos" value="Exportar a XLS" class="btn btn-info">
    </form>
    <br>
    <br>
</div>
<!--script de ventana para eliminar-->
<script>
    function mostrarSweetAlert(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esto!",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, ¡elimínalo!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "crud.php?eliminar_alumno=" + id;
            }
        });

        return false;
    }
</script>
</body>
</html>
