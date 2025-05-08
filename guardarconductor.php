<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = trim($_POST['nombre']);
    $telefono = trim($_POST['telefono']);
    $licencia = trim($_POST['licencia']);

    // Validaciones básicas
    if (empty($nombre) || empty($telefono) || empty($licencia)) {
        
    }

    // Verificar duplicado por licencia
    $sqlExiste = mysqli_query($conn, "SELECT * FROM conductores WHERE licencia = '$licencia'");

    if (mysqli_num_rows($sqlExiste) > 0) {
        
    }

    // Insertar en la base de datos
    $sql = "INSERT INTO conductores (nombre, teléfono, licencia) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $nombre, $telefono, $licencia);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: conductores.php?success=1");
        exit();
    } else {
        echo "Error al guardar el conductor: " . mysqli_error($conn);
    }
}
?>
