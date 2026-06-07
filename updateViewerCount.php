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
    $newCount = $row['count'] + 1;

    $updateSql = "UPDATE viewers_count SET count = $newCount WHERE id = 1";
    if ($conn->query($updateSql) === TRUE) {
        echo "Visitor count updated successfully!";
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    echo "No record found!";
}

$conn->close();
?>
