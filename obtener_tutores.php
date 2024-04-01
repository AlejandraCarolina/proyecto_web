<?php
include 'conexion.php';

if(isset($_POST['datos_alumno'])){
    $result = $conn->query("SELECT * FROM alumnos WHERE id =".$_POST['datos_alumno']);
    echo json_encode($result->fetch_assoc());
}

// Verificar si se recibió el ID de la carrera por POST
if(isset($_POST['carrera_id'])) {
    $carrera_id = $_POST['carrera_id'];

    // Consulta para obtener los tutores de la carrera seleccionada
    $sql = "SELECT * FROM tutores WHERE id_carrera = $carrera_id";
    $result = $conn->query($sql);

    $tutores = [];
    while($row = $result->fetch_assoc()) {
        $tutores[] = $row;
    }

    // Convertir a formato JSON y devolver como respuesta
    echo json_encode($tutores);
}
