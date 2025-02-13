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

$classType = isset($_GET['classType']) ? $_GET['classType'] : "";
$trainer = isset($_GET['trainer']) ? $_GET['trainer'] : "";

// Build the SQL query based on filters
$sql = "SELECT c.class_id, c.title, c.price, c.class_type, t.trainer_name AS trainer_name, c.class_picture, t.trainer_picture
        FROM classes c
        JOIN trainers t ON c.trainer_id = t.trainer_id
        WHERE 1=1 ";

if (!empty($classType)) {
    $sql .= "AND c.class_type = '$classType' ";
}

if (!empty($trainer)) {
    $sql .= "AND c.trainer_id = $trainer ";
}

$result = $conn->query($sql);

$classes = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $classData = array(
            'class_id' => (int)$row['class_id'],
            'title' => $row['title'],
            'price' => $row['price'],
            'class_type' => $row['class_type'],
            'trainer_name' => $row['trainer_name'],
            'class_picture' => $row['class_picture'], // Update field name
            'trainer_picture' => $row['trainer_picture'] // Update field name
        );
        $classes[] = $classData;
    }
}

$conn->close();

// Return the data in JSON format
header('Content-Type: application/json');
echo json_encode($classes);
?>