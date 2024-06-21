<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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
$user_full_name = $_POST['full_name'];
$user_username = $_POST['username'];
$user_email = $_POST['email'];
$user_password = $_POST['password'];

// Validar que los datos no estén vacíos
if (empty($user_full_name) || empty($user_username) || empty($user_email) || empty($user_password)) {
    echo json_encode(['error' => 'Por favor, complete todos los campos.']);
    exit();
}

// Validar que el nombre de usuario no esté ya registrado
$sql = "SELECT id FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo json_encode(['error' => 'El nombre de usuario ya está registrado.']);
    $stmt->close();
    $conn->close();
    exit();
}
$stmt->close();

// Validar que el correo electrónico no esté ya registrado
$sql = "SELECT id FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo json_encode(['error' => 'El correo electrónico ya está registrado.']);
    $stmt->close();
    $conn->close();
    exit();
}
$stmt->close();

// Encriptar la contraseña
$hashed_password = password_hash($user_password, PASSWORD_DEFAULT);

// Insertar nuevo usuario en la base de datos
$sql = "INSERT INTO users (full_name, username, email, password) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $user_full_name, $user_username, $user_email, $hashed_password);

if ($stmt->execute()) {
    echo json_encode(['success' => 'Registro exitoso. Por favor, inicie sesión.']);
} else {
    echo json_encode(['error' => 'Error al registrar el usuario. Por favor, inténtelo de nuevo.']);
}

$stmt->close();
$conn->close();
?>
