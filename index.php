<?php
// Start session at the beginning
session_start();

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "intelli_host";
$port = 3307;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    error_log("Database connection failed: " . $conn->connect_error);
    die(json_encode(['status' => 'error', 'message' => 'Database connection failed']));
}

// Handle Signup
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signup-name'])) {
    $response = handleSignup($conn);
    echo json_encode($response);
    exit;
}

// Handle Login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login-userid'])) {
    $response = handleLogin($conn);
    echo json_encode($response);
    exit;
}

$conn->close();

// Signup Handler Function
function handleSignup($conn) {
    // Validate required fields
    $required = ['signup-userid', 'signup-name', 'signup-email', 'signup-password'];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            return ['status' => 'error', 'message' => 'All fields are required'];
        }
    }
    
    // Sanitize inputs
    $userid = trim($_POST['signup-userid']);
    $name = trim($_POST['signup-name']);
    $address = trim($_POST['signup-address'] ?? '');
    $email = trim($_POST['signup-email']);
    $password = $_POST['signup-password'];
    
    // Basic validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return ['status' => 'error', 'message' => 'Invalid email format'];
    }
    
    if (strlen($password) < 6) {
        return ['status' => 'error', 'message' => 'Password must be at least 6 characters long'];
    }
    
    // Check if user already exists
    $check_stmt = $conn->prepare("SELECT id FROM users WHERE userid = ? OR email = ?");
    $check_stmt->bind_param("ss", $userid, $email);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    
    if ($check_result->num_rows > 0) {
        $check_stmt->close();
        return ['status' => 'error', 'message' => 'User ID or Email already exists'];
    }
    $check_stmt->close();
    
    // Hash password and insert user
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    $stmt = $conn->prepare("INSERT INTO users (userid, name, address, email, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $userid, $name, $address, $email, $hashed_password);
    
    if ($stmt->execute()) {
        $_SESSION['user_id'] = $stmt->insert_id;
        $_SESSION['user_name'] = $name;
        $stmt->close();
        return ['status' => 'success', 'message' => 'Registration successful', 'redirect' => 'index.html'];
    } else {
        $error = $stmt->error;
        $stmt->close();
        error_log("Signup error: " . $error);
        return ['status' => 'error', 'message' => 'Registration failed. Please try again.'];
    }
}

// Login Handler Function
function handleLogin($conn) {
    // Validate required fields
    if (empty($_POST['login-userid']) || empty($_POST['login-password'])) {
        return ['status' => 'error', 'message' => 'User ID and password are required'];
    }
    
    $userid = trim($_POST['login-userid']);
    $password = $_POST['login-password'];
    
    $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE userid = ?");
    $stmt->bind_param("s", $userid);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        $stmt->close();
        return ['status' => 'error', 'message' => 'Invalid User ID or password'];
    }
    
    $user = $result->fetch_assoc();
    
    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $stmt->close();
        return ['status' => 'success', 'message' => 'Login successful', 'redirect' => 'index.html'];
    } else {
        $stmt->close();
        return ['status' => 'error', 'message' => 'Invalid User ID or password'];
    }
}
?>