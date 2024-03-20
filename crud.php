<?php 

//Integrar archivo de conexi+on

include 'bd.php';

// Alta de archivo de conexión
    if(isset($_POST['alta_alumno'])){
        $matricula = $_POST['matricula'];
        $nombre = $_POST['nombre'];
        $edad = $_POST['edad'];
        $email = $_POST['email'];
        $id_carrera = $_POST['id_carrera'];

    //Guardar valores a la tabla alumnos

        $sql = "INSERT INTO alumnos (matricula, nombre, edad, email, id_carrera) VALUES ('$matricula', '$nombre', '$edad', '$email', '$id_carrera')";
        $result = $conn->query($sql);
        header("Location: listado_alumno.php");
    }

//Cambios de alumnos

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

?>