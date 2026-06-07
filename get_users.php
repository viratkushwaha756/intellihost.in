<?php
header('Content-Type: application/json');

$host = 'localhost';
$db = 'intelli_host';
$username = 'root';
$password = '';
$port = 3307;

$db = new mysqli($host, $username, $password, $db, $port);

if ($db->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $db->connect_error]));
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id'])) {
        $id = (int) $_GET['id'];
        $query = $db->prepare("SELECT * FROM users WHERE id = ?");
        $query->bind_param("i", $id);
        $query->execute();
        $result = $query->get_result();
        $user = $result->fetch_assoc();
        echo json_encode($user);
    } else {
        $result = $db->query("SELECT * FROM users");
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        echo json_encode($users);
    }
}

elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    if (isset($_GET['id'])) {
        $id = (int) $_GET['id'];
        $query = $db->prepare("DELETE FROM users WHERE id = ?");
        $query->bind_param("i", $id);
        if ($query->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete user']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'User ID is required']);
    }
}



elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['action'])) {
        if ($data['action'] == 'update_user') {
            $id = (int) $data['user_id'];
            $name = $db->real_escape_string($data['name']);
            $email = $db->real_escape_string($data['email']);
            $address = $db->real_escape_string($data['address']);
            $userid = $db->real_escape_string($data['userid']);
            $query = $db->prepare("UPDATE users SET name = ?, email = ?, address = ?, userid = ? WHERE id = ?");
            $query->bind_param("ssssi", $name, $email, $address, $userid, $id);
            if ($query->execute()) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update user']);
            }
        }
    }
    
}




$db->close();
?>
