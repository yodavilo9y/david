<?php
include 'conexion.php';

// Verificar que se recibió un ID válido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_boleto = intval($_GET['id']); // Conversión explícita

    
    // Preparar la sentencia para eliminar el conductor
    $stmt = mysqli_prepare($conn, "DELETE FROM boletos WHERE id_boleto = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id_boleto);
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            header("Location: boletos.php?eliminado=1");
            exit();
        } else {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            die("Error al ejecutar la eliminación: " . mysqli_error($conn));
        }
    } else {
        mysqli_close($conn);
        die("Error al preparar la consulta: " . mysqli_error($conn));
    }
} else {
    die("ID no válido.");
}
?>
