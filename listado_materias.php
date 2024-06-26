<?php
include 'conexion.php';

// Consulta para obtener todos los registros de Materias
$sql = "SELECT * FROM materias";
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

$materias_data = [];
if($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $materias_data = $row;
    }
    $result = $conn->query($sql);
}

if(isset($_POST['export_materias'])) exportToXLS('materias', $materias_data);
?>

<html lang="es">
<head>
    <title>Materias</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
<?php include "nav_bar.html"; ?>
<div class="container mt-5 mb-5">
    <a href="." class="btn btn-secondary mb-2">Regresar</a>
    <h2>Listado de Materias</h2>
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Carrera(s)</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <!-- Recorrido en la tabla de vehiculos para obtener los registros -->
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?=$row['id']?></td>
                <td><?=$row['nombre']?></td>
                <td>
                    <?php
                        $sql_carreras = "SELECT c.nombre AS 'carrera_asignada' FROM materias_carrera m_c 
                                JOIN materias m ON m.id=m_c.id_materia JOIN carreras c ON c.id=m_c.id_carrera
                                WHERE m.id=".$row['id'];
                        $result_carreras = $conn->query($sql_carreras);

                        // Resultados de consulta
                        if ($result_carreras->num_rows == 0) echo '<em>Sin asignar</em>';
                        else {
                            echo '<ul>';
                            while ($row_carrera = $result_carreras->fetch_assoc())
                                echo'<li>'.$row_carrera['carrera_asignada'].'</li>';
                            echo '</ul>';
                        }
                    ?>
                </td>
                <td>
                    <a href="editar_materia.php?id=<?=$row['id']?>" class="btn btn-info">Editar</a>
                    <form class="d-inline" onsubmit="eliminar(event, <?=$row['id']?>)" method="POST">
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    <form action="" method="POST">
        <a href="alta_materia.php" class="btn btn-primary">Agregar Materia</a>
        <input type="submit" name="export_materias" value="Exportar a XLS" class="btn btn-success">
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
            text: "!Se eliminará su asignacion en las carreras y los registros que se tengan en las asesorías y tutorías!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD3333FF",
            confirmButtonText: "Confirmar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'crud.php?eliminar_materia='+id;
            }
        });
    }
</script>