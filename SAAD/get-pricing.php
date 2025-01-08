<?php

include('connection.php');

// Retrieve food_id and size_id from GET parameters
$food_id = isset($_GET['food_id']) ? intval($_GET['food_id']) : 0;
$size_id = isset($_GET['size_id']) ? intval($_GET['size_id']) : 0;

$response = ['pricing_id' => null];

if ($food_id > 0 && $size_id > 0) {
    $stmt = $conn->prepare("SELECT pricing_id FROM food_size_pricing WHERE food_id = ? AND size_id = ?");
    $stmt->bind_param("ii", $food_id, $size_id);
    $stmt->execute();
    $stmt->bind_result($pricing_id);
    if ($stmt->fetch()) {
        $response['pricing_id'] = $pricing_id;
    }
    $stmt->close();
}

$conn->close();
echo json_encode($response);
?>

