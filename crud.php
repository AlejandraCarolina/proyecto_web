<?php
// Integrar archivo de conexión
include 'conexion.php';

// Alta de archivo de conexión
if(isset($_POST['alta_alumno'])){
    $matricula = $_POST['matricula'];
    $nombre = $_POST['nombre'];
    $email = $_POST['correo'];
    $id_carrera = $_POST['id_carrera'];
    $id_tutor = $_POST['id_tutor'];

// Guardar valores a la tabla alumnos

    $sql = "INSERT INTO alumnos (matricula, nombre, correo, id_carrera, id_tutor) VALUES ('$matricula', '$nombre', '$email', '$id_carrera', '$id_tutor')";
    $result = $conn->query($sql);
    header("Location: listado_alumno.php");
}

// Cambios de alumnos
if(isset($_POST['cambio_alumno'])){
    $id = $_POST['id_alumno'];
    $matricula = $_POST['matricula'];
    $nombre = $_POST['nombre'];
    $email = $_POST['correo'];
    $id_carrera = $_POST['id_carrera'];
    $id_tutor = $_POST['id_tutor'];


    //query de actualización en la tabla alumnos
    $sql = "UPDATE alumnos SET matricula='$matricula', nombre='$nombre', correo='$email', id_carrera='$id_carrera', id_tutor='$id_tutor' WHERE id=$id";
    $result = $conn->query($sql);
    header("Location: listado_alumno.php");

}

//Baja de alumnos
if(isset($_GET['eliminar_alumno'])){
    $id = $_GET['eliminar_alumno'];
    
    $sql = "DELETE FROM alumnos WHERE id=$id";
    $result = $conn->query($sql);
    header("Location: listado_alumno.php");
}



// Alta de Tutores
if(isset($_POST['alta_tutor'])) {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $carrera = $_POST['carrera'] == '0' ? 'NULL' : "'".$_POST['carrera']."'";

    $sql = "INSERT INTO tutores (nombre, correo, id_carrera) VALUES ('$nombre', '$correo', $carrera)";
    $result = $conn->query($sql);

    header("Location: listado_tutores.php");
}

// Cambio de Tutor
if(isset($_POST['cambio_tutor'])) {
    $id = $_POST['id_tutor'];
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $carrera = $_POST['carrera'] == '0' ? 'NULL' : "'".$_POST['carrera']."'";

    $sql = "UPDATE tutores SET nombre='$nombre', correo='$correo', id_carrera=$carrera WHERE id='$id'";
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

// Consulta para la previa alta de asesorias/tutorias - Materias asignadas a una Carrera
if(isset($_POST['q_materia_carrera'])) {
    $id_carrera = $_POST['q_materia_carrera'];

    // Consulta de Materias asignadas a la Carrera seleccionada (materias_carrera)
    $sql_m_c = "SELECT m_c.id AS 'id_m_c', m.id AS 'id', m.nombre AS 'nombre' FROM materias_carrera m_c 
            JOIN materias m ON m_c.id_materia=m.id WHERE m_c.id_carrera = '$id_carrera' ORDER BY 'id_m_c'";
    $result_m_c = $conn->query($sql_m_c);

    $materias_carrera = [];
    if($result_m_c->num_rows > 0) while ($materia = $result_m_c->fetch_assoc()) $materias_carrera[] = $materia;

    // Consulta de Tutores asignados a la Carrrera seleccionada
    $sql_a = "SELECT t.id, t.nombre FROM tutores t WHERE id_carrera = '$id_carrera'";
    $result_a = $conn->query($sql_a);
    $a_t = []; // Asesor o Tutor
    if($result_a->num_rows > 0) while ($row = $result_a->fetch_assoc()) $a_t[] = $row;

    // Variable para guardar las consultas en JSON
    $datas = array(
        'materias' => $materias_carrera,
        'a_t' => $a_t,
    );

    // Impresión de datos en JSON para el script js
    echo json_encode($datas);
}

// Consulta para la previa alta de asesorias/tutorias - Alumno tiene Tutor / Alumno tiene Asesor
if(isset($_POST['q_alumno_tutor'])) {
    $id_tutor = $_POST['q_alumno_tutor'];

    // Consulta de Alumnos asignados al Tutor seleccionado
    $sql_al = "SELECT al.id, al.nombre FROM alumnos al WHERE id_tutor = '$id_tutor'";
    $result_al = $conn->query($sql_al);

    $data = [];
    if($result_al->num_rows > 0) while ($alumno = $result_al->fetch_assoc()) $data[] = $alumno;

    // Impresión de datos en JSON para el script js
    echo json_encode($data);
}

// Alta de asesorias
if(isset($_POST['alta_asesoria'])) {
    $id_carrera = $_POST['carrera'];
    $id_materia = $_POST['materia'];
    $id_alumno = $_POST['alumno'];
    $id_asesor = $_POST['asesor'];
    $observaciones = $_POST['observaciones'];
    $fecha_asesoria = $_POST['fecha'];

    $sql = "INSERT INTO asesorias (id_carrera, id_materia, id_alumno, id_asesor, observaciones, fecha_asesoria) 
            VALUES ('$id_carrera', '$id_materia', '$id_alumno', '$id_asesor', '$observaciones', '$fecha_asesoria')";
    $result = $conn->query($sql);

    header("Location: listado_asesorias.php");
}

// Consulta previa para el cambio de Asesoria
if(isset($_POST['q_asesoria'])) {
    $id = $_POST['q_asesoria'];

    $sql = "SELECT * FROM asesorias WHERE id='$id'";
    $result = $conn->query($sql);

    // Impresión de datos en JSON para el script js
    echo json_encode($result->fetch_assoc());
}

// Cambio asesoria
if(isset($_POST['cambio_asesoria'])) {
    $id = $_POST['id'];
    $id_carrera = $_POST['carrera'];
    $id_materia = $_POST['materia'];
    $id_alumno = $_POST['alumno'];
    $id_asesor = $_POST['asesor'];
    $observaciones = $_POST['observaciones'];
    $fecha_asesoria = $_POST['fecha'];

    $sql = "UPDATE asesorias SET id_carrera='$id_carrera', id_materia='$id_materia', id_alumno='$id_alumno', id_asesor='$id_asesor',
            observaciones='$observaciones', fecha_asesoria='$fecha_asesoria' WHERE id = '$id'";
    $result = $conn->query($sql);

    header("Location: listado_asesorias.php");
}

// Eliminar asesoria
if(isset($_GET['eliminar_asesoria'])) {
    $id = $_GET['eliminar_asesoria'];

    $sql = "DELETE FROM asesorias WHERE id = '$id'";
    $result = $conn->query($sql);

    header("Location: listado_asesorias.php");
}

// Alta de tutoria
if(isset($_POST['alta_tutoria'])) {
    $id_carrera = $_POST['carrera'];
    $id_materia = $_POST['materia'];
    $id_alumno = $_POST['alumno'];
    $id_tutor = $_POST['tutor'];
    $observaciones = $_POST['observaciones'];
    $fecha_tutoria = $_POST['fecha'];

    $sql = "INSERT INTO tutorias (id_carrera, id_materia, id_alumno, id_tutor, observaciones, fecha_tutoria) 
            VALUES ('$id_carrera', '$id_materia', '$id_alumno', '$id_tutor', '$observaciones', '$fecha_tutoria')";
    $result = $conn->query($sql);

    header("Location: listado_tutorias.php");
}

// Consulta previa para el cambio de Tutoria
if(isset($_POST['q_tutoria'])) {
    $id = $_POST['q_tutoria'];

    $sql = "SELECT * FROM tutorias WHERE id='$id'";
    $result = $conn->query($sql);

    // Impresión de datos en JSON para el script js
    echo json_encode($result->fetch_assoc());
}

// Cambio de tutoria
if(isset($_POST['cambio_tutoria'])) {
    $id = $_POST['id'];
    $id_carrera = $_POST['carrera'];
    $id_materia = $_POST['materia'];
    $id_alumno = $_POST['alumno'];
    $id_tutor = $_POST['tutor'];
    $observaciones = $_POST['observaciones'];
    $fecha_tutoria = $_POST['fecha'];

    $sql = "UPDATE tutorias SET id_carrera='$id_carrera', id_materia='$id_materia', id_alumno='$id_alumno', id_tutor='$id_tutor',
            observaciones='$observaciones', fecha_tutoria='$fecha_tutoria' WHERE id = '$id'";
    $result = $conn->query($sql);

    header("Location: listado_tutorias.php");
}

// Eliminar tutoria
if(isset($_GET['eliminar_tutoria'])) {
    $id = $_GET['eliminar_tutoria'];

    $sql = "DELETE FROM tutorias WHERE id = '$id'";
    $result = $conn->query($sql);

    header("Location: listado_tutorias.php");
}

//Alta de carreras
if(isset($_POST['alta_carrera'])){
    $nombre = $_POST['nombre'];

    //Guardar valores a la tabla carreras

    $sql = "INSERT INTO carreras (nombre) VALUES ('$nombre')";
    $result = $conn->query($sql);
    header("Location: listado_carreras.php");
}

// Editar Carreras

if(isset($_POST['cambio_carrera'])){
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];

    //query de actualización en la tabla carreras

    $sql = "UPDATE carreras SET nombre='$nombre' WHERE id=$id";
    $result = $conn->query($sql);
    header("Location: listado_carreras.php");
}
