<?php
session_start();
header('Content-Type: application/json');

// Conexión a la base de datos
$servername = "localhost";
$username = "root"; // Cambia esto si es necesario
$password = ""; // Cambia esto si es necesario
$dbname = "login"; // Nombre de la base de datos

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['error' => 'Conexión fallida: ' . $conn->connect_error]));
}

// Recoger datos del formulario
$user_email = $_POST['email'];
$user_password = $_POST['password'];

// Validar que los datos no estén vacíos
if (empty($user_email) || empty($user_password)) {
    echo json_encode(['error' => 'Por favor, complete todos los campos.']);
    exit();
}

// Validar usuario y contraseña
$sql = "SELECT id, username, password FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($user_id, $user_username, $hashed_password);

if ($stmt->num_rows > 0) {
    $stmt->fetch();
    if (password_verify($user_password, $hashed_password)) {
        $_SESSION['user_id'] = $user_id; 
        $_SESSION['username'] = $user_username;
        echo json_encode(['success' => 'Inicio de sesión exitoso.']);
    } else {
        echo json_encode(['error' => 'Contraseña incorrecta.']);
    }
} else {
    echo json_encode(['error' => 'Correo electrónico no encontrado.']);
}

$stmt->close();
$conn->close();
?>
