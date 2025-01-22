<?php
include('connection.php');

if (isset($_GET['food_id'])) {
    $food_id = intval($_GET['food_id']);
    $food_sql = "SELECT f.name, f.description, c.category_name 
                 FROM food f 
                 JOIN category c ON f.category_id = c.category_id 
                 WHERE f.food_id = ?";
    $stmt = $conn->prepare($food_sql);
    $stmt->bind_param("i", $food_id);
    $stmt->execute();
    $food_result = $stmt->get_result()->fetch_assoc();

    $size_sql = "SELECT s.size_id, s.size_name, fsp.price 
                 FROM food_size_pricing fsp 
                 JOIN size s ON fsp.size_id = s.size_id 
                 WHERE fsp.food_id = ?";
    $stmt = $conn->prepare($size_sql);
    $stmt->bind_param("i", $food_id);
    $stmt->execute();
    $size_result = $stmt->get_result();

    $sizes = [];
    while ($row = $size_result->fetch_assoc()) {
        $sizes[] = $row;
    }

    echo json_encode([
        'name' => $food_result['name'],
        'description' => $food_result['description'],
        'category' => $food_result['category_name'],
        'sizes' => $sizes
    ]);
}
?>

