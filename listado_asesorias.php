<?php
include 'conexion.php';

// Consulta para obtener todos los registros de Tutorias
$sql = "SELECT a.id, c.nombre AS 'carrera', m.nombre AS 'materia', al.nombre AS 'alumno', 
    t.nombre AS 'asesor', observaciones, fecha_asesoria  FROM asesorias a JOIN carreras c ON a.id_carrera=c.id 
        JOIN materias m ON a.id_materia=m.id JOIN alumnos al ON a.id_alumno=al.id JOIN tutores t ON a.id_asesor=t.id ";
// En caso de que sease para un alumno pero no se defina el id
if(isset($_GET['id_alumno']) && empty($_GET['id_alumno'])) header('Location: listado_asesorias.php');
// En caso de que sease para un alumno con id definido
else if (!empty($_GET['id_alumno'])) {
    $sql .= "WHERE id_alumno = ".$_GET['id_alumno']." ORDER BY a.id";
    // Almacenamos los datos del alumno definido en caso de que exista
    $alumno = $conn->query("SELECT * FROM alumnos WHERE id=".$_GET['id_alumno']);
}
// En caso de que no sea para un alumno, sino para todas las asesorias
else $sql .= "ORDER BY a.id";
$result = $conn->query($sql);

if(isset($alumno)) {
    if($alumno->num_rows == 0 || $alumno->num_rows > 1) header('Location: listado_alumnos.php');
    else $d_alumno = $alumno->fetch_assoc();
}

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

$asesorias_data = [];
if($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $asesorias_data = $row;
    }
    $result = $conn->query($sql);
}

if(isset($_POST['export_asesorias'])) exportToXLS('asesorias'.(isset($alumno) ? '_'.$d_alumno['matricula'] : ''), $asesorias_data);
?>

<html lang="es">
<head>
    <title>Asesorias</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
<?php include "nav_bar.html"; ?>
<div class="container mt-5 mb-5">
    <a href="." class="btn btn-secondary mb-2">Regresar</a>
    <h2>Listado de Asesorías<?= isset($alumno) ? ' de '.$d_alumno['nombre'] : '' ?></h2>
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Carrera</th>
            <th>Materia</th>
            <th>Alumno</th>
            <th>Asesor</th>
            <th>Observaciones</th>
            <th>Fecha</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <!-- Recorrido en la tabla de vehiculos para obtener los registros -->
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?=$row['id']?></td>
                <td><?=$row['carrera']?></td>
                <td><?=$row['materia']?></td>
                <td><?=$row['alumno']?></td>
                <td><?=$row['asesor']?></td>
                <td><?=$row['observaciones']?></td>
                <td><?=$row['fecha_asesoria']?></td>
                <td>
                    <form class="d-inline" onsubmit="eliminar(event, <?=$row['id']?>)" method="POST">
                        <a href="editar_asesoria.php?id=<?=$row['id']?>" class="btn btn-info">Editar</a>
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
        <form action="" class="d-inline" method="POST">
            <a href="alta_asesoria.php<?= isset($alumno) ? '?id_alumno='.$d_alumno['id'] : ''?>" class="btn btn-primary">Agregar Asesoría</a>
            <input type="submit" name="export_asesorias" value="Exportar a XLS" class="btn btn-success">
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
            text: "¡No podrás recuperar ningún dato de esta asesoría!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD3333FF",
            confirmButtonText: "Confirmar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'crud.php?eliminar_asesoria='+id;
            }
        });
    }
</script>