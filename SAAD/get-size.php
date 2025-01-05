<?php
include 'connection.php'; // Ensure connection.php properly connects to your database

// Get the food_id and size_id from the GET request
$food_id = isset($_GET['food_id']) ? intval($_GET['food_id']) : null;
$size_id = isset($_GET['size_id']) ? intval($_GET['size_id']) : null;

// Log the received parameters for debugging
error_log("Received food_id: " . ($food_id ?? 'null') . ", size_id: " . ($size_id ?? 'null'));

if (!$food_id) {
    // If food_id is missing, return an error
    echo json_encode(['error' => 'Missing food_id parameter.']);
    exit;
}

// Case 1: Fetch all sizes for a specific food item
if (!$size_id) {
    $query = "SELECT s.size_id AS id, s.size_name AS name 
              FROM size s 
              INNER JOIN food_size_pricing fsp ON s.size_id = fsp.size_id 
              WHERE fsp.food_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $food_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $sizes = [];
    while ($row = $result->fetch_assoc()) {
        $sizes[] = $row;
    }

    // If no sizes are found, log and return an appropriate fallback response
    if (empty($sizes)) {
        error_log("No sizes found for food_id=$food_id. Returning all sizes as fallback.");
        
        // Fetch all available sizes
        $query = "SELECT s.size_id AS id, s.size_name AS name FROM size s";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $sizes[] = $row;
        }

        if (empty($sizes)) {
            echo json_encode(['error' => 'No sizes available in the system.']);
            exit;
        }
    }

    echo json_encode(['sizes' => $sizes]);
} else {
    // Case 2: Fetch price for a specific size
    $query = "SELECT s.size_name, fsp.price 
              FROM food_size_pricing fsp 
              INNER JOIN size s ON fsp.size_id = s.size_id 
              WHERE fsp.food_id = ? AND fsp.size_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $food_id, $size_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        // Return the size name and price if found
        echo json_encode([
            'size_name' => $row['size_name'],
            'price' => $row['price']
        ]);
    } else {
        // Log the error for debugging
        error_log("No matching size or price found for food_id=$food_id and size_id=$size_id.");
        echo json_encode([
            'error' => 'No matching size or price found for the given food_id and size_id.',
            'food_id' => $food_id,
            'size_id' => $size_id
        ]);
    }
}
?>