<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "sweatstudio";

// Create a database connection
$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$specialtyType = isset($_GET['specialtyType']) ? $_GET['specialtyType'] : "";

// Build the SQL query based on filters
$sql = "SELECT trainer_id, trainer_name, specialty, trainer_picture FROM trainers";

if (!empty($specialtyType)) {
    $sql .= " WHERE specialty = '$specialtyType'";
}

$result = $conn->query($sql);

$trainers = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $trainerData = array(
            'trainer_id' => (int)$row['trainer_id'],
            'trainer_name' => $row['trainer_name'],
            'specialty' => $row['specialty'],
            'trainer_picture' => $row['trainer_picture']
        );
        $trainers[] = $trainerData;
    }
}

$conn->close();

// Return the data in JSON format
header('Content-Type: application/json');
echo json_encode($trainers);
?>