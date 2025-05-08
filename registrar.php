<?php
// Incluir la conexión a la base de datos
include('conexion.php');
 // Ruta al archivo de conexión

// Procesar el formulario al enviarlo
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    // Verificar si el correo electrónico ya está registrado con una consulta preparada
    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);  // "s" significa string
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // El correo ya está registrado
        echo "Este correo ya está registrado. Por favor, intenta con otro.";
    } else {
        // Cifrar la contraseña
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insertar los datos del nuevo usuario con una consulta preparada
        $sql = "INSERT INTO usuarios (nombre, email, usuario, password) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $nombre, $email, $usuario, $hashed_password);  // "ssss" significa que todos son strings

        if ($stmt->execute()) {
            // El registro fue exitoso, redirigir al login
            header('Location: login.php?registro=exitoso');
            exit();
        } else {
            // Si ocurre un error al insertar
            echo "Error al registrar el usuario: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VIAJANDO POR MEXICO</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/estilo.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="shortcut icon" href="img/portada.ico" type="image/x-icon">
    <script src="panel/script.js"></script>
</head>
<body>
    <!-- Formulario de Registro -->
    <div class="container mt-4">
        <form action="" method="POST" class="formulario__register">
            <h2>Regístrarse</h2>
            <input type="text" placeholder="Nombre completo" name="nombre" required>
            <input type="email" placeholder="Correo Electrónico" name="email" required>
            <input type="text" placeholder="Usuario" name="usuario" required>
            <input type="password" placeholder="Contraseña" name="password" required>
            <button type="submit">Regístrarse</button>
        </form>

        <!-- Botón de regreso al Login -->
        <div class="mt-3">
            <a href="login.php" class="btn btn-secondary">Volver </a>
        </div>
    </div>
</body>
</html>
