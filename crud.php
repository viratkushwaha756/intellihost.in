<?php
include('config.php'); // Include the database connection

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['action']) && $_GET['action'] == 'fetch_users') {
        $sql = "SELECT * FROM users"; // Fetch users from the 'users' table
        $result = $conn->query($sql);
        $users = [];

        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }

        echo json_encode($users);
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $inputData = json_decode(file_get_contents('php://input'), true);

    if (isset($inputData['action'])) {
        if ($inputData['action'] == 'add_user') {
            $name = $inputData['name'];
            $email = $inputData['email'];
            $phone = $inputData['phone'];
            $address = $inputData['address'];

            $sql = "INSERT INTO users (name, email, phone, address) VALUES ('$name', '$email', '$phone', '$address')";
            if ($conn->query($sql)) {
                echo json_encode(['success' => true, 'message' => 'User added successfully.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error adding user.']);
            }
        } elseif ($inputData['action'] == 'update_user') {
            $userId = $inputData['user_id'];
            $name = $inputData['name'];
            $email = $inputData['email'];
            $phone = $inputData['phone'];
            $address = $inputData['address'];

            $sql = "UPDATE users SET name='$name', email='$email', phone='$phone', address='$address' WHERE userid='$userId'";
            if ($conn->query($sql)) {
                echo json_encode(['success' => true, 'message' => 'User updated successfully.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error updating user.']);
            }
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    if (isset($_GET['action']) && $_GET['action'] == 'delete_user') {
        $userId = $_GET['user_id'];

        $sql = "DELETE FROM users WHERE userid='$userId'";
        if ($conn->query($sql)) {
            echo json_encode(['success' => true, 'message' => 'User deleted successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error deleting user.']);
        }
    }
}

$conn->close();
?>
