<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost", "root", "", "betfriends");

$data = json_decode(file_get_contents("php://input"), true);

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
