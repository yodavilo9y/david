<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_vehiculo = trim($_POST['id_vehiculo']);
    $id_ruta = trim($_POST['id_ruta']);
    $id_conductor = trim($_POST['id_conductor']);
    $fecha = trim($_POST['fecha']);
    $horario = trim($_POST['horario']);
    $estado = trim($_POST['estado']);


    // Validaciones básicas
    if (empty($id_vehiculo) || empty($id_ruta) || empty($id_conductor)|| empty($fecha) || empty($horario)|| empty($estado)) {
        
    }

    // Verificar duplicado por licencia
    $sqlExiste = mysqli_query($conn, "SELECT * FROM viajes WHERE id_vehiculo = '$id_vehiculo'");

    if (mysqli_num_rows($sqlExiste) > 0) {
        
    }

    // Insertar en la base de datos
    $sql = "INSERT INTO viajes (id_vehiculo, id_ruta, id_conductor, fecha, horario, estado) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssss", $id_vehiculo, $id_ruta, $id_conductor, $fecha, $horario, $estado);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: viajes.php?success=1");
        exit();
    } else {
        echo "Error al guardar el conductor: " . mysqli_error($conn);
    }
}
?>
