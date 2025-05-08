<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = trim($_POST['id']);
    $id_viaje = trim($_POST['id_viaje']);
    $asiento = trim($_POST['asiento']);
    $precio = trim($_POST['precio']);


    // Validaciones básicas
    if (empty($id) || empty($id_viaje)|| empty($asiento) || empty($precio)) {
        
    }

    // Verificar duplicado por licencia
    $sqlExiste = mysqli_query($conn, "SELECT * FROM boletos WHERE asiento = '$asiento'");

    if (mysqli_num_rows($sqlExiste) > 0) {
        
    }

    // Insertar en la base de datos
    $sql = "INSERT INTO boletos (id, id_viaje, asiento, precio) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssss", $id, $id_viaje, $asiento, $precio);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: boletos.php?success=1");
        exit();
    } else {
        echo "Error al guardar el conductor: " . mysqli_error($conn);
    }
}
?>
