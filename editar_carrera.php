<?php
include 'conexion.php';

if(!isset($_GET['id'])) {
    header('Location: listado_tutores.php');
    return;
}

// Validación de que exista la materia
$id = $_GET['id'];
$sql = "SELECT * FROM materias WHERE id='$id'";
$result = $conn->query($sql);
// Enviar alerta
if($result->num_rows == 0 || $result->num_rows > 1) return;
$materia = $result->fetch_assoc();

// Consulta de Carreras
$sql = "SELECT * FROM carreras";
$result = $conn->query($sql);
?>

<html lang="es">
<head>
    <title>Alta de Materias</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
<div class="container mt-5 mb-5">
    <a href="listado_materias.php" class="btn btn-info mb-3">Regresar</a>
    <h2>Alta de Materia</h2>
    <form action="crud.php" method="POST">
        <input type="hidden" name="id_materia" value="<?=$materia['id']?>">
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" name="nombre" id="nombre" value="<?=$materia['nombre']?>" required>
        </div>
        <div class="form-group">
            <!-- Mostrar registros de Carreras -->
            <label><?= $result->num_rows == 0 ? 'No se encuentra ningúna carrera a la que se le pueda asignar' : 'Carrera:' ?></label>
            <?php while ($row = $result->fetch_assoc()):
                // Buscamos la carrera seleccionada
                $sql_t_m = "SELECT * FROM materias m JOIN carreras c ON m.id_carrera=c.id WHERE m.id = ".$materia['id']." AND c.id = ".$row['id'];
                $result_t_m = $conn->query($sql_t_m);
            ?>
                <!-- Seleccionamos carrera -->
                <div class="custom-control custom-radio">
                    <input type="radio" class="custom-control-input" name="carrera" id="<?=$row['id']?>"
                           value="<?=$row['id']?>" <?=$result_t_m->num_rows == 0 ? '' : 'checked'?>>
                    <label class="custom-control-label" for="<?=$row['id']?>"><?=$row['nombre']?></label>
                </div>
            <?php endwhile; ?>
        </div>
        <button type="submit" class="btn btn-primary" name="cambio_materia" <?=$result->num_rows == 0 ? 'disabled' : '' ?>>Agregar Materia</button>
    </form>
</div>
</body>
</html>

<script>
    // Validar selección de carrera
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelector('form').addEventListener('submit', function(event) {
            // Validamos que haya una carerera seleccionada
            const carrerasSeleccionadas = document.querySelectorAll('input[name="carrera"]:checked');
            if (carrerasSeleccionadas.length === 0 || carrerasSeleccionadas.length > 1) {
                event.preventDefault();
                Swal.fire({
                    title:  "¡Advertencia!",
                    text:   "Debes de seleccionar una carrera",
                    icon:   "warning"
                });
            }
        });
    });
</script>

