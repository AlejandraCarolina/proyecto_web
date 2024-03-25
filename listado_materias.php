<?php
include 'conexion.php';

// Consulta para obtener todos los registros de Materias
$sql = "SELECT m.id, m.nombre, c.nombre AS 'nombre_carrera' FROM materias m JOIN carreras c ON m.id_carrera=c.id
        ORDER BY m.id";
$result = $conn->query($sql);
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
                <td><?=$row['nombre_carrera']?></td>
                <td>
                    <a href="editar_carrera.php?id=<?=$row['id']?>" class="btn btn-info">Editar</a>
                    <form class="d-inline-block" onsubmit="eliminar(event, <?=$row['id']?>)" method="POST">
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    <a href="alta_materia.php" class="btn btn-primary">Agregar Materia</a>
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
                window.location.href = 'crud.php?eliminar_materia='+id;
            }
        });
    }
</script>