<?php
$host = 'localhost';
$db = 'intelli_host';
$username = 'root';
$password = '';
$port = 3307;

$conn = new mysqli($host, $username, $password, $db, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT count FROM viewers_count WHERE id = 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $viewerCount = $row['count'];
    echo json_encode(['count' => $viewerCount]);
} else {
    echo json_encode(['count' => 0]);
}

$conn->close();
?>
