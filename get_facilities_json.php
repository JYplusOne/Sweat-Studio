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

$facilitiesType = isset($_GET['facilitiesType']) ? $_GET['facilitiesType'] : "";

// Build the SQL query based on the filter
$sql = "SELECT * FROM facilities WHERE 1";

if (!empty($facilitiesType)) {
    $sql .= " AND facility_type = '$facilitiesType'";
}

$result = $conn->query($sql);

$facilities = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $facilityData = array(
            'facility_id' => $row['facility_id'],
            'facility_name' => $row['facility_name'],
            'price' => $row['price'],
            'description' => $row['description'],
            'facility_type' => $row['facility_type'],
            'image_path' => $row['image_path']
        );
        $facilities[] = $facilityData;
    }
}

$conn->close();

// Return the data in JSON format
header('Content-Type: application/json');
echo json_encode($facilities);
?>