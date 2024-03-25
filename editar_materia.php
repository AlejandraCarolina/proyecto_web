<?php
include 'conexion.php';

if(!isset($_GET['id'])) {
    header('Location: listado_materias.php');
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
    <title>Editar Materias</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
<?php include "nav_bar.html"; ?>
<div class="container mt-5 mb-5">
    <a href="listado_materias.php" class="btn btn-info mb-3">Regresar</a>
    <h2>Editar Materia</h2>
    <form action="crud.php" method="POST">
        <input type="hidden" name="id" value="<?=$materia['id']?>">
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" name="nombre" id="nombre" value="<?=$materia['nombre']?>" required>
        </div>
        <div class="form-group">
            <!-- Mostrar registros de Carreras -->
            <label><?= $result->num_rows == 0 ? 'No se encuentra ningúna carrera a la que se le pueda asignar' : 'Carrera:' ?></label>
            <?php while ($row = $result->fetch_assoc()):
                // Buscamos la carrera seleccionada
                $sql_t_m = "SELECT * FROM materias_carrera m_c JOIN carreras c ON m_c.id_carrera=c.id WHERE m_c.id_materia = ".$materia['id']." AND c.id = ".$row['id'];
                $result_t_m = $conn->query($sql_t_m);
            ?>
                <!-- Seleccionamos carrera -->
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" name="carreras[]" id="<?=$row['id']?>"
                           value="<?=$row['id']?>" <?=$result_t_m->num_rows == 0 ? '' : 'checked'?>>
                    <label class="custom-control-label" for="<?=$row['id']?>"><?=$row['nombre']?></label>
                </div>
            <?php endwhile; ?>
        </div>
        <button type="submit" class="btn btn-primary" name="cambio_materia" <?=$result->num_rows == 0 ? 'disabled' : '' ?>>Guardar Cambios</button>
    </form>
</div>
</body>
</html>
