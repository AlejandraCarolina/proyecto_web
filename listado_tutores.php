<?php
include 'conexion.php';

// Consulta para obtener todos los registros de Tutores
$sql = "SELECT t.id, t.nombre, t.correo, c.nombre AS 'nombre_carrera' FROM tutores t
            JOIN carreras c ON t.id_carrera = c.id ORDER BY t.id";
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

$tutores_data = [];
if($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tutores_data = $row;
    }
    $result = $conn->query($sql);
}

if(isset($_POST['export_tutores'])) exportToXLS('tutores', $tutores_data);
?>

<html lang="es">
<head>
    <title>Tutores</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
<?php include "nav_bar.html"; ?>
<div class="container mt-5 mb-5">
    <a href="." class="btn btn-secondary mb-2">Regresar</a>
    <h2>Listado de Tutores</h2>
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Carrera</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <!-- Recorrido en la tabla de vehiculos para obtener los registros -->
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?=$row['id']?></td>
                <td><?=$row['nombre']?></td>
                <td><?=$row['correo']?></td>
                <td><?=$row['nombre_carrera']?></td>
                <td>
                    <a href="editar_tutor.php?id=<?=$row['id']?>" class="btn btn-info">Editar</a>
                    <form class="d-inline-block" onsubmit="eliminar(event, <?=$row['id']?>)" method="POST">
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    <form action="" method="POST">
        <a href="alta_tutor.php" class="btn btn-primary">Agregar Tutor</a>
        <input type="submit" name="export_tutores" value="Exportar a XLS" class="btn btn-success">
    </form>
</div>
</body>
</html>

<script>
    // Confirmación de eliminación
    function eliminar(event, id) {
        event.preventDefault();

        Swal.fire({
            title: "¿Estás seguro de eliminar?",
            text: "No podrás recuperar ningún dato!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD3333FF",
            confirmButtonText: "Confirmar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'crud.php?eliminar_tutor='+id;
            }
        });
    }
</script>