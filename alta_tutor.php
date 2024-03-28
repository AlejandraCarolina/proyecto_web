<?php
include 'conexion.php';

// Consulta de Carreras
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
<?php include "nav_bar.html"; ?>
<div class="container mt-5 mb-5">
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
            <label>Carrera:</label>
            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" name="carrera" id="0" value="0" checked>
                <label class="custom-control-label" for="0">Sin asignar</label>
            </div>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="custom-control custom-radio">
                    <input type="radio" class="custom-control-input" name="carrera" id="<?=$row['id']?>" value="<?=$row['id']?>">
                    <label class="custom-control-label" for="<?=$row['id']?>"><?=$row['nombre']?></label>
                </div>
            <?php endwhile; ?>
        </div>
        <button type="submit" class="btn btn-primary" name="alta_tutor">Agregar Tutor</button>
    </form>
</div>
</body>
</html>

<script>
    // Validar selección de carrera
    // document.addEventListener("DOMContentLoaded", function() {
    //     document.querySelector('form').addEventListener('submit', function(event) {
    //         // Validamos que haya una carerera seleccionada
    //         const carrerasSeleccionadas = document.querySelectorAll('input[name="carrera"]:checked');
    //         if (carrerasSeleccionadas.length === 0 || carrerasSeleccionadas.length > 1) {
    //             event.preventDefault();
    //             Swal.fire({
    //                 title:  "¡Advertencia!",
    //                 text:   "Debes de seleccionar una carrera",
    //                 icon:   "warning"
    //             });
    //         }
    //     });
    // });
</script>

