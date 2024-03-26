<?php
include 'conexion.php';

// Consulta para obtener todos los registros de Tutorias
$sql = "SELECT a.id, c.nombre AS 'carrera', m.nombre AS 'materia', al.nombre AS 'alumno', 
    t.nombre AS 'asesor', observaciones, fecha_asesoria  FROM asesorias a JOIN carreras c ON a.id_carrera=c.id 
        JOIN materias m ON a.id_materia=m.id JOIN alumnos al ON a.id_alumno=al.id JOIN tutores t ON a.id_asesor=t.id
    ORDER BY a.id";
$result = $conn->query($sql);

if(isset($_POST['editar'])) {
    // Validación de que exista la asesoria
    $id = $_POST['id_asesoria'];
    $sql = "SELECT * FROM asesorias WHERE id='$id'";
    $result = $conn->query($sql);
    // Enviar alerta
    if($result->num_rows == 0 || $result->num_rows > 1) return;
    $asesoria = $result->fetch_assoc();

    echo json_encode($asesoria);
    header("Location: editar_asesoria.php?id=".$asesoria['id']);
}
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
    <h2>Listado de Asesorías</h2>
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
                    <form class="d-inline-block" action="" method="POST">
                        <input type="hidden" name="id_asesoria" value="<?=$row['id']?>">
                        <button type="submit" class="btn btn-info" name="editar">Editar</button>
                    </form>
<!--                    <a href="editar_asesoria.php?id=--><?php //=$row['id']?><!--" class="btn btn-info">Editar</a>-->
                    <form class="d-inline-block" onsubmit="eliminar(event, <?=$row['id']?>)" method="POST">
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    <a href="alta_asesoria.php" class="btn btn-primary">Agregar Asesoría</a>
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
                window.location.href = 'crud.php?eliminar_asesoria='+id;
            }
        });
    }
</script>