<?php
include 'conexion.php';

// Verificar que se recibió un ID válido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_viaje = intval($_GET['id']); // Conversión explícita

    // Verificar si el conductor tiene viajes asociados
    $sqlboletos = mysqli_query($conn, "SELECT * FROM boletos WHERE id_viaje = $id_viaje");
    if (mysqli_num_rows($sqlboletos) > 0) {
        // Si el conductor tiene viajes, mostrar una notificación y redirigir
        header("Location: viajes.php?error=viajes_asociados");
        exit();
    }

    // Preparar la sentencia para eliminar el conductor
    $stmt = mysqli_prepare($conn, "DELETE FROM viajes WHERE id_viaje = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id_viaje);
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            header("Location: viajes.php?eliminado=1");
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
