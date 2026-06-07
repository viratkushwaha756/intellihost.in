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
        $query = $db->prepare("SELECT * FROM contact_users WHERE id = ?");
        $query->bind_param("i", $id);
        $query->execute();
        $result = $query->get_result();
        $contact = $result->fetch_assoc();
        echo json_encode($contact);
    } else {
        $result = $db->query("SELECT * FROM contact_users");
        $contact_queries = [];
        while ($row = $result->fetch_assoc()) {
            $contact_queries[] = $row;
        }
        echo json_encode($contact_queries);
    }
}

elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    if (isset($_GET['id'])) {
        $id = (int) $_GET['id'];
        $query = $db->prepare("DELETE FROM contact_users WHERE id = ?");
        $query->bind_param("i", $id);
        if ($query->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete contact query']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Contact query ID is required']);
    }
}

elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['action']) && $data['action'] == 'update_contact_query') {
        $id = (int) $data['contact_id'];
        $name = $db->real_escape_string($data['name']);
        $email = $db->real_escape_string($data['email']);
        $phone = $db->real_escape_string($data['phone']);
        $address = $db->real_escape_string($data['address']);
        $query = $db->real_escape_string($data['query']);
        
        $update_query = $db->prepare("UPDATE contact_users SET name = ?, email = ?, phone = ?, address = ?, query = ? WHERE id = ?");
        $update_query->bind_param("sssssi", $name, $email, $phone, $address, $query, $id);
        if ($update_query->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update contact query']);
        }
    }
}

$db->close();
?>
