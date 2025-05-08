<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario con verificación
    $origen = $_POST['origen'] ?? '';
    $destino = $_POST['destino'] ?? '';
    $distancia = $_POST['distancia'] ?? '';

    // Validar que no estén vacíos
    if (empty($origen) || empty($destino) || empty($distancia)) {
        die("Todos los campos son obligatorios.");
    }

    // Validar que distancia sea numérica
    if (!is_numeric($distancia)) {
        die("La distancia debe ser un valor numérico.");
    }

    // Insertar en la base de datos
    $sql = "INSERT INTO rutas (origen, destino, distancia) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssd", $origen, $destino, $distancia);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: rutas.php?success=1");
        exit();
    } else {
        echo "Error al guardar la ruta: " . mysqli_error($conn);
    }
}
?>

