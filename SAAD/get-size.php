<?php
include 'connection.php';  // Include your database connection

// Get the food_id and size_id (pricing_id) from the GET request
$food_id = isset($_GET['food_id']) ? intval($_GET['food_id']) : null;
$size_id = isset($_GET['size_id']) ? intval($_GET['size_id']) : null;  // This now refers to pricing_id

if (!$conn) {
    echo json_encode(['error' => 'Database connection failed.']);
    exit;
}

if (!$food_id) {
    echo json_encode(['error' => 'Missing food_id parameter.']);
    exit;
}

// Fetch all size options with pricing for a specific food item
if (!$size_id) {
    $query = "SELECT fsp.pricing_id, s.size_name AS name, fsp.price 
              FROM size s 
              INNER JOIN food_size_pricing fsp ON s.size_id = fsp.size_id 
              WHERE fsp.food_id = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $food_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $sizes = [];
        while ($row = $result->fetch_assoc()) {
            $sizes[] = [
                'id' => $row['pricing_id'],  // Use pricing_id to uniquely identify the option
                'name' => $row['name'],       // Size name
                'price' => $row['price']      // Price of this size
            ];
        }

        if (empty($sizes)) {
            echo json_encode(['error' => 'No sizes available for the given food_id.']);
            exit;
        }
        echo json_encode(['sizes' => $sizes]);
    } else {
        echo json_encode(['error' => 'Failed to prepare query for sizes.']);
    }
} else {
    // Fetch size details and price based on pricing_id
    $query = "SELECT s.size_name, fsp.price, fsp.pricing_id 
              FROM food_size_pricing fsp 
              INNER JOIN size s ON fsp.size_id = s.size_id 
              WHERE fsp.food_id = ? AND fsp.pricing_id = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("ii", $food_id, $size_id);  // size_id now refers to pricing_id
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            echo json_encode([
                'size_name' => $row['size_name'],
                'price' => $row['price'],
                'pricing_id' => $row['pricing_id']
            ]);
        } else {
            echo json_encode([
                'error' => 'No matching size or price found for the given food_id and pricing_id.',
                'food_id' => $food_id,
                'size_id' => $size_id
            ]);
        }
    } else {
        echo json_encode(['error' => 'Failed to prepare query for size and price.']);
    }
}
?>


