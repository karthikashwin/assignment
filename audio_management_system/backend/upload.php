<?php
// Connect to the database
$conn = new mysqli("localhost", "root", "", "practice"(dbname));

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $language = $_POST['language'];
    $description = $_POST['description'];

    // Handle the file upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["audio_file"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if file is an audio file
    $allowedTypes = array("mp3", "wav", "ogg", "m4a");
    if (!in_array($fileType, $allowedTypes)) {
        echo "Sorry, only audio files are allowed.";
        $uploadOk = 0;
    }

    // Check if file upload is successful
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["audio_file"]["tmp_name"], $target_file)) {
            // Insert data into the database
            $sql = "INSERT INTO audio_files (file_path, language, description, status) 
                    VALUES ('$target_file', '$language', '$description', 'pending')";

            if ($conn->query($sql) === TRUE) {
                // Redirect to manage_audio.html after successful upload
                header('Location: manage_audio.html');
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

$conn->close();
?>
