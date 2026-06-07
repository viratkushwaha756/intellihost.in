<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "intelli_host";
$port = 3307;

try {
    $conn = new PDO("mysql:host=$servername;port=$port;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $query = $_POST['query'];

        // Get userid instead of id
        $stmt = $conn->prepare("SELECT userid FROM users WHERE email = :email LIMIT 1");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $userid = $user['userid'];  // Now getting userid

            // Updated to use userid instead of user_id
            $sql = "INSERT INTO contact_users (userid, name, email, phone, address, query) 
                    VALUES (:userid, :name, :email, :phone, :address, :query)";
            
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':userid', $userid);  // Changed to userid
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':query', $query);
            $stmt->execute();

            header("Location: contact.html");
            exit();
        } else {
            echo "User does not exist.";
        }
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>