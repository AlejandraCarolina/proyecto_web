<?php
include 'conexion.php';

if(!isset($_GET['id'])) {
    header('Location: listado_tutores.php');
    return;
}

// Consulta de Tutor
$sql = "SELECT * FROM tutores WHERE id = ".$_GET['id'];
$result = $conn->query($sql);
?>

<html lang="es">
<head>
    <title>Alta de Tutores</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <a href="listado_tutores.php" class="btn btn-secondary mb-2">Regresar</a>
    <h2>Alta de Tutor</h2>
    <form action="crud.php" method="POST">
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" name="nombre" id="nombre" required>
        </div>
        <div class="form-group">
            <label for="correo">Correo:</label>
            <input type="text" class="form-control" name="correo" id="correo" required>
        </div>
        <div class="form-group">
            <!-- Consulta de Carrreras -->
            <label><?= $result->num_rows == 0 ? 'No se encuentra ningúna materia a la que se le pueda asignar' : 'Servicios:' ?></label>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" name="materias[]" id="<?=$row['id']?>" value="<?= $row['id'] ?>">
                    <label class="custom-control-label" for="<?=$row['id']?>"><?= $row['nombre'] ?></label>
                </div>
            <?php endwhile; ?>
        </div>
        <button type="submit" class="btn btn-primary" name="alta_tutor" <?=$result->num_rows == 0 ? 'disabled' : '' ?>>Agregar Tutor</button>
    </form>
</div>
</body>
</html>