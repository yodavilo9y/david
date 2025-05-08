<?php 
include('conexion.php');
session_start();

$mensaje = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['email']) || !isset($_POST['password'])) {
        $mensaje = "Datos no recibidos correctamente.";
    } else {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        if (!empty($email) && !empty($password)) {
            // Verificar conexión
            if (!$conn) {
                die("Error de conexión: " . mysqli_connect_error());
            }

            // Consulta segura con Prepared Statement
            $sql = "SELECT * FROM usuarios WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                // Verificar contraseña
                if (password_verify($password, $row['password'])) {
                    session_regenerate_id(true);
                    $_SESSION['usuario_id'] = $row['id'];
                    $_SESSION['nombre'] = $row['nombre'];
                    $_SESSION['email'] = $row['email'];

                    // Redirige al index dentro de "panel/"
                    header("Location: index.php");
                    exit();
                } else {
                    $mensaje = "⚠️ Contraseña incorrecta.";
                }
            } else {
                $mensaje = "⚠️ No se encontró un usuario con ese correo.";
            }

            $stmt->close();
        } else {
            $mensaje = "⚠️ Por favor, complete todos los campos.";
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
    
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/estilo.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="shortcut icon" href="img/portada.ico" type="image/x-icon">
    <script src="script.js"></script>
</head>
<body>
    <div class="container mt-4">
        <div class="row justify-content-center"> <!-- Ajustado para centrar el contenido -->
            <div class="col-lg-6 col-md-8 col-sm-10"> <!-- Tamaños de columna responsivos -->
                <div class="contenedor__login-register">
                    <!-- Formulario de login -->
                    <form action="login.php" method="POST" class="formulario__login">
                        <h2>Iniciar Sesión</h2>
                        <input type="email" placeholder="Correo Electrónico" name="email" required>
                        <input type="password" placeholder="Contraseña" name="password" required>
                        <button type="submit">Entrar</button>

                        <?php if (!empty($mensaje)) : ?>
                            <p class="mensaje-error"><?= htmlspecialchars($mensaje); ?></p> <!-- Clase para el mensaje de error -->
                        <?php endif; ?>
                    </form>
                </div>
            </div>
            <div class="col-lg-6 col-md-8 col-sm-10">
                <div class="caja__trasera">
                    <h3>¿Aún no tienes una cuenta?</h3>
                    <p>Regístrate para que puedas iniciar sesión</p>
                    <a href="registrar.php" class="btn btn-primary mt-4">REGISTRAR</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
