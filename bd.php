<?php

  //conexion a la base de datos

  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "universidad";

  // crear conexion

  $conn = new mysqli ($servername, $username, $password, $dbname);

  // verificar la conexion

  if ($conn->connect_error){
    die("Conexión fallida: " . $conn->connect_error);
  }
  
  ?>