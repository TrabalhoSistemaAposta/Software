<?php
session_start();
header('Content-Type: application/json');
$conn = new mysqli("localhost", "root", "", "betfriends");

$data = json_decode(file_get_contents("php://input"), true);

if ($data['action'] === 'register') {
    $username = $data['username'];
    $email = $data['email'];
    $password = password_hash($data['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);
    $stmt->execute();

    echo json_encode(['success' => true]);
}

if ($data['action'] === 'login') {
    $email = $data['email'];
    $password = $data['password'];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if ($result && password_verify($password, $result['password'])) {
        echo json_encode(['success' => true, 'user_id' => $result['id']]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Credenciais incorretas']);
    }
}
?>
