<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "intelli_host";
$port = 3307;

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $password = $_POST['password'];

    if (!empty($user_id) && !empty($password)) {
        $sql = "SELECT * FROM admins WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            
            // If the password is correct, set the session variable for admin
            if ($row['password'] === $password) {
                $_SESSION['is_admin'] = true;  // Set session to allow admin access
                header('Location: admin.php');  // Redirect to admin dashboard
                exit();
            } else {
                echo "<p>Invalid password!</p>";
            }
        } else {
            echo "<p>Admin user not found!</p>";
        }

        $stmt->close();
    } else {
        echo "<p>Please fill in both fields!</p>";
    }
}

$conn->close();
?>
