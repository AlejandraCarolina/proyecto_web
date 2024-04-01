<?php
include 'conexion.php';

// Verificar si se recibió el ID de la carrera por POST
if(isset($_POST['carrera_id'])) {
    $carrera_id = $_POST['carrera_id'];

    // Consulta para obtener los tutores de la carrera seleccionada
    $sql = "SELECT id, nombre FROM tutores WHERE id_carrera = $carrera_id";
    $result = $conn->query($sql);

    $tutores = array();
    while($row = $result->fetch_assoc()) {
        $tutor = array(
            'id' => $row['id'],
            'nombre' => $row['nombre']
        );
        $tutores[] = $tutor;
    }

    // Convertir a formato JSON y devolver como respuesta
    echo json_encode($tutores);
} else {
    // Si no se recibió el ID de la carrera, devolver un JSON vacío o un mensaje de error
    echo json_encode(array('error' => 'ID de carrera no recibido'));
}

?>