<?php
$host = 'localhost';
$dbname = 'practice';
$user = 'root';
$pass = '';

$conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$data = json_decode(file_get_contents('php://input'), true);

$audioId = $data['id'];
$status = $data['status'];

// Update the status of the audio file
$stmt = $conn->prepare("UPDATE audio_files SET status = :status WHERE id = :id");
$stmt->bindParam(':status', $status);
$stmt->bindParam(':id', $audioId);
$stmt->execute();

http_response_code(200);
echo json_encode(['message' => 'Status updated successfully']);
?>
