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
    $carrera = $_POST['carrera'];

    $sql = "INSERT INTO materias (nombre, id_carrera) VALUES ('$nombre', '$carrera')";
    $result = $conn->query($sql);

    header("Location: listado_materias.php");
}

// Cambio de Materia
if(isset($_POST['cambio_materia'])) {
    $id = $_POST['id_materia'];
    $nombre = $_POST['nombre'];
    $carrera = $_POST['carrera'];

    $sql = "UPDATE materias SET nombre='$nombre', id_carrera='$carrera' WHERE id='$id'";
    $result = $conn->query($sql);

    header("Location: listado_materias.php");
}

// Eliminar Materia
if(isset($_GET['eliminar_materia'])) {
    $id = $_GET['eliminar_materia'];

    $sql = "DELETE FROM materias WHERE id='$id'";
    $result = $conn->query($sql);

    header("Location: listado_materias.php");
}
