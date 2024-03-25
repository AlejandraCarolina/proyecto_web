<?php
include 'conexion.php';

if(!isset($_GET['id'])) {
    header('Location: listado_tutores.php');
    return;
}

// Validación de que exista el tutor
$id = $_GET['id'];
$sql = "SELECT * FROM tutores WHERE id='$id'";
$result = $conn->query($sql);
// Enviar alerta
if($result->num_rows == 0 || $result->num_rows > 1) return;
$tutor = $result->fetch_assoc();

// Consulta de Carreras
$sql = "SELECT * FROM carreras";
$result = $conn->query($sql);
?>

<html lang="es">
<head>
    <title>Editar Tutores</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<?php include "nav_bar.html"; ?>
<body>
<div class="container mt-5 mb-5">
    <a href="listado_tutores.php" class="btn btn-secondary mb-2">Regresar</a>
    <h2>Editar Tutor</h2>
    <form action="crud.php" method="POST">
        <input type="hidden" name="id_tutor" value="<?=$tutor['id']?>">
        <div class="row row-cols-2">
            <div class="form-group col">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" name="nombre" id="nombre" value="<?=$tutor['nombre']?>" required>
            </div>
            <div class="form-group col">
                <label for="correo">Correo:</label>
                <input type="text" class="form-control" name="correo" id="correo" value="<?=$tutor['correo']?>" required>
            </div>
        </div>

        <div class="form-group">
            <!-- Mostrar registros de Carreras -->
            <label><?= $result->num_rows == 0 ? 'No se encuentra ningúna carrera a la que se le pueda asignar' : 'Carrera:' ?></label>
            <?php while ($row = $result->fetch_assoc()):
                // Buscamos la carrera seleccionada
                $sql_t_m = "SELECT * FROM tutores t JOIN carreras c ON t.id_carrera=c.id WHERE t.id = ".$tutor['id']." AND c.id = ".$row['id'];
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
        <button type="submit" class="btn btn-primary" name="cambio_tutor" <?=$result->num_rows == 0 ? 'disabled' : '' ?>>Guardar Cambios</button>
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

