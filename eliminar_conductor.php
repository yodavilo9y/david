<?php
include 'conexion.php';

// Verificar que se recibió un ID válido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_conductor = intval($_GET['id']); // Conversión explícita

    // Verificar si el conductor tiene viajes asociados
    $sqlViajes = mysqli_query($conn, "SELECT * FROM viajes WHERE id_conductor = $id_conductor");
    if (mysqli_num_rows($sqlViajes) > 0) {
        // Si el conductor tiene viajes, mostrar una notificación y redirigir
        header("Location: conductores.php?error=viajes_asociados");
        exit();
    }

    // Preparar la sentencia para eliminar el conductor
    $stmt = mysqli_prepare($conn, "DELETE FROM conductores WHERE id_conductor = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id_conductor);
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            header("Location: conductores.php?eliminado=1");
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
