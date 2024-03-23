<?php
include 'conexion.php';

// Consulta de Materias
$sql = "SELECT * FROM carreras";
$result = $conn->query($sql);
?>

<html lang="es">
<head>
    <title>Alta de Tutores</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
<div class="container mt-5">
    <a href="listado_tutores.php" class="btn btn-secondary mb-2">Regresar</a>
    <h2>Alta de Tutor</h2>
    <form action="crud.php" method="POST">
        <div class="row row-cols-2">
            <div class="form-group col">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" name="nombre" id="nombre" required>
            </div>
            <div class="form-group col">
                <label for="correo">Correo:</label>
                <input type="text" class="form-control" name="correo" id="correo" required>
            </div>
        </div>

        <div class="form-group">
            <!-- Mostrar registros de Carreras -->
            <label><?= $result->num_rows == 0 ? 'No se encuentra ningúna carrera a la que se le pueda asignar' : 'Carrera:' ?></label>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="custom-control custom-radio">
                    <input type="radio" class="custom-control-input" name="carreras[]" id="<?=$row['id']?>" value="<?=$row['id']?>">
                    <label class="custom-control-label" for="<?=$row['id']?>"><?=$row['nombre']?></label>
                </div>
            <?php endwhile; ?>
        </div>
        <button type="submit" class="btn btn-primary mb-3" name="alta_tutor" <?=$result->num_rows == 0 ? 'disabled' : '' ?>>Agregar Tutor</button>
    </form>
</div>
</body>
</html>

<!-- Validar selección de carrera -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.querySelector('form');

        form.addEventListener('submit', function(event) {
            const carrerasSeleccionadas = document.querySelectorAll('input[name="carreras[]"]:checked'); // selecciona todas las carreras seleccionadas
            if (carrerasSeleccionadas.length === 0) { // si no hay carreras seleccionadas
                event.preventDefault();
                Swal.fire({
                    title:  "Advertencia",
                    text:   "Debes de seleccionar una carrera",
                    icon:   "warning"
                });
            }
        });
    });
</script>

