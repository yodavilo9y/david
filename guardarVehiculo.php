<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $placa = $_POST['placa'];
    $modelo = $_POST['modelo'];
    $año = $_POST['año'];
    $capacidad = $_POST['capacidad'];

    // Validar capacidad
    if (!is_numeric($capacidad) || intval($capacidad) <= 0) {
       
    }

    $capacidad = intval($capacidad);

    // Validar imagen
    if (!isset($_FILES['foto']) || $_FILES['foto']['error'] != 0) {
        
    }

    $foto = $_FILES['foto']['tmp_name'];
    $fotografia = file_get_contents($foto); // Sin addslashes si usamos parámetros preparados

    // Validar duplicado
    $sqlExiste = mysqli_query($conn, "SELECT * FROM vehiculos WHERE placa = '$placa'");
    if (mysqli_num_rows($sqlExiste) > 0) {
        echo "<script>
                alert('Ya existe un vehículo con esa placa.');
                window.location.href='vehiculos.php';
              </script>";
        exit();
    }

    // Guardar con prepared statement
    $sql = "INSERT INTO vehiculos (placa, modelo, año, capacidad, foto) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssis", $placa, $modelo, $año, $capacidad, $fotografia);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: vehiculos.php?success=1");
        exit();
    } else {
        echo "Error al guardar el vehículo: " . mysqli_error($conn);
    }
}
?>
