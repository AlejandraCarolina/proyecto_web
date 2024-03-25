<?php
include 'conexion.php';

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
<?php include "nav_bar.html"; ?>
<div class="container mt-5 mb-5">
    <a href="listado_materias.php" class="btn btn-info mb-3">Regresar</a>
    <h2>Alta de Materia</h2>
    <form action="crud.php" method="POST">
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" name="nombre" id="nombre" required>
        </div>
        <div class="form-group">
            <!-- Mostrar registros de Carreras -->
            <label><?= $result->num_rows == 0 ? 'No se encuentra ningúna carrera a la que se le pueda asignar' : 'Carrera:' ?></label>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" name="carreras[]" id="<?=$row['id']?>" value="<?=$row['id']?>">
                    <label class="custom-control-label" for="<?=$row['id']?>"><?=$row['nombre']?></label>
                </div>
            <?php endwhile; ?>
        </div>
        <button type="submit" class="btn btn-primary" name="alta_materia" <?=$result->num_rows == 0 ? 'disabled' : '' ?>>Agregar Materia</button>
    </form>
</div>
</body>
</html>
