<?php
// Integrar archivo de conexión
include 'conexion.php';

// Alta de archivo de conexión
if(isset($_POST['alta_alumno'])){
    $matricula = $_POST['matricula'];
    $nombre = $_POST['nombre'];
    $edad = $_POST['edad'];
    $email = $_POST['email'];
    $id_carrera = $_POST['id_carrera'];

// Guardar valores a la tabla alumnos

    $sql = "INSERT INTO alumnos (matricula, nombre, edad, email, id_carrera) VALUES ('$matricula', '$nombre', '$edad', '$email', '$id_carrera')";
    $result = $conn->query($sql);
    header("Location: listado_alumno.php");
}

// Cambios de alumnos
if(isset($_POST['cambio_alumno'])){
    $id = $_POST['id'];
    $matricula = $_POST['matricula'];
    $nombre = $_POST['nombre'];
    $edad = $_POST['edad'];
    $email = $_POST['email'];
    $id_carrera = $_POST['id_carrera'];

    //query de actualización en la tabla alumnos
    $sql = "UPDATE alumnos SET matricula='$matricula', nombre='$nombre',edad='$edad', email='$email', id_carrera='$id_carrera' WHERE id=$id";
    $result = $conn->query($sql);
    header("Location: listado_alumno.php");

}

// Alta de Tutores
if(isset($_POST['alta_tutor'])) {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $carrera = $_POST['carrera'];

    $sql = "INSERT INTO tutores (nombre, correo, id_carrera) VALUES ('$nombre', '$correo', '$carrera')";
    $result = $conn->query($sql);

    header("Location: listado_tutores.php");
}

// Cambio de Tutor
if(isset($_POST['cambio_tutor'])) {
    $id = $_POST['id_tutor'];
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $carrera = $_POST['carrera'];

    $sql = "UPDATE tutores SET nombre='$nombre', correo='$correo', id_carrera='$carrera' WHERE id='$id'";
    $result = $conn->query($sql);

    header("Location: listado_tutores.php");
}

// Eliminar Tutor
if(isset($_GET['eliminar_tutor'])) {
    $id = $_GET['eliminar_tutor'];

    $sql = "DELETE FROM tutores WHERE id='$id'";
    $result = $conn->query($sql);

    header("Location: listado_tutores.php");
}

// Alta de Materias
if(isset($_POST['alta_materia'])) {
    $nombre = $_POST['nombre'];

    $sql = "INSERT INTO materias (nombre) VALUES ('$nombre')";
    $result = $conn->query($sql);
    $id = $conn->insert_id;

    foreach ($_POST['carreras'] as $id_carrera) {
        $sql = "INSERT INTO materias_carrera (id_materia, id_carrera) VALUES ('$id', '$id_carrera')";
        $result = $conn->query($sql);
    }

    header("Location: listado_materias.php");
}

// Cambio de materias
if(isset($_POST['cambio_materia'])) {
    $id_materia = $_POST['id'];
    $nombre = $_POST['nombre'];

    $sql = "UPDATE materias SET nombre='$nombre' WHERE id='$id_materia'";
    $result = $conn->query($sql);

    // Consultar si dicha materia ya estaba asignada en la carrera
    if(isset($_POST['carreras'])) {
        $sql_carreras_deseleccionadas = "SELECT * FROM materias_carrera WHERE id_materia='$id_materia'";
        foreach ($_POST['carreras'] as $id_carrera) {
            $sql_carreras_deseleccionadas .= " AND id_carrera!='$id_carrera'";
            $sql_carreras = "SELECT * FROM materias_carrera WHERE id_materia='$id_materia' AND id_carrera='$id_carrera'";
            $result_carreras = $conn->query($sql_carreras);

            // Insertar en caso de que no haya sido seleccionada antes
            if($result_carreras->num_rows == 0) {
                $sql = "INSERT INTO materias_carrera (id_materia, id_carrera) VALUES ('$id_materia', '$id_carrera')";
                $result = $conn->query($sql);
            }
        }

        // Consulta de las carreras deseleccionadas en la materia
        $result_carreras_deseleccionadas = $conn->query($sql_carreras_deseleccionadas);
        if($result_carreras_deseleccionadas->num_rows > 0) {
            // Eliminar relacion de la materia con la carrera
            while ($row = $result_carreras_deseleccionadas->fetch_assoc()) {
                $sql = "DELETE FROM materias_carrera WHERE id=".$row['id'];
                $result = $conn->query($sql);
            }
        }
    } else {
        // Dado que no hay selección, entonces la materia no está asignada ninguna carrera
        $sql = "DELETE FROM materias_carrera WHERE id_materia='$id_materia'";
        $result = $conn->query($sql);
    }

    header('Location: listado_materias.php');
}

// Eliminar Materia
if(isset($_GET['eliminar_materia'])) {
    $id = $_GET['eliminar_materia'];

    $sql = "DELETE FROM materias WHERE id='$id'";
    $result = $conn->query($sql);

    header("Location: listado_materias.php");
}
