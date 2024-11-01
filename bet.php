<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost", "root", "", "betfriends");

$data = json_decode(file_get_contents("php://input"), true);
$user_id = $data['userId'];
$event = $data['event'];
$outcome = $data['outcome'];
$amount = $data['amount'];

$user = $conn->query("SELECT * FROM users WHERE id = $user_id")->fetch_assoc();
if ($user['credits'] >= $amount) {
    $new_credits = $user['credits'] - $amount;
    $conn->query("UPDATE users SET credits = $new_credits WHERE id = $user_id");

    $stmt = $conn->prepare("INSERT INTO bets (user_id, event, outcome, amount) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("issi", $user_id, $event, $outcome, $amount);
    $stmt->execute();

    echo json_encode(['success' => true, 'credits' => $new_credits]);
} else {
    echo json_encode(['success' => false, 'message' => 'Saldo insuficiente']);
}
?>
