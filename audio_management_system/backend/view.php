<?php
$host = 'localhost:3306';
$dbname = 'practice';
$user = 'root';
$pass = 'Ashwin@2002';

$conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 5; // Number of files per page
$offset = ($page - 1) * $limit;

// Fetch audio files with pagination
$stmt = $conn->prepare("SELECT * FROM audio_files LIMIT :limit OFFSET :offset");
$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$audioFiles = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get total audio files count
$totalStmt = $conn->query("SELECT COUNT(*) FROM audio_files");
$totalFiles = $totalStmt->fetchColumn();

$response = [
    'audioFiles' => $audioFiles,
    'totalPages' => ceil($totalFiles / $limit)
];

header('Content-Type: application/json');
echo json_encode($response);
?>
