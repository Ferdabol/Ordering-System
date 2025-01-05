<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session for user authentication
session_start();

// Set header to return JSON
header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['userinfo']['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit;
}

// Retrieve the user_id from the session
$user_id = $_SESSION['userinfo']['user_id'];

// Include database connection
include 'connection.php';

// Debug: Verify database connection
if (!$conn) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . mysqli_connect_error()]);
    exit;
}

// Check if action and order_items are set
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'checkout') {
    $orderItems = json_decode($_POST['order_items'], true);

    if (!$orderItems || empty($orderItems)) {
        echo json_encode(['success' => false, 'message' => 'No order items provided.']);
        exit;
    }

    // Insert data into checked_out_foods table
    $insertedItems = [];
    foreach ($orderItems as $item) {
        $food_id = $item['food_id'];
        $name = mysqli_real_escape_string($conn, $item['name']);
        $price = floatval($item['price']);
        $quantity = intval($item['quantity']);

        // Check if food_id is valid
        if (!mysqli_query($conn, "SELECT 1 FROM food WHERE food_id = '$food_id'")) {
            echo json_encode(['success' => false, 'message' => 'Invalid food_id']);
            exit;
        }

        $query = "INSERT INTO checked_out_foods (user_id, food_id, quantity, price, checked_out_at) VALUES ('$user_id', '$food_id', $quantity, $price, NOW())";
        if (!mysqli_query($conn, $query)) {
            echo json_encode(['success' => false, 'message' => 'Failed to save order item: ' . mysqli_error($conn), 'query' => $query]);
            exit;
        }

        $insertedItems[] = [
            'name' => $name,
            'quantity' => $quantity,
            'price' => $price
        ];
    }

    // Calculate total price
    $totalPrice = 0;
    foreach ($insertedItems as $item) {
        $totalPrice += $item['price'] * $item['quantity'];
    }

    // Insert into order history with total price
    $query_history = "INSERT INTO order_history (user_id, total_price, order_status, ordered_at) VALUES ('$user_id', '$totalPrice', 'pending', NOW())";
    if (!mysqli_query($conn, $query_history)) {
        echo json_encode(['success' => false, 'message' => 'Failed to save order history: ' . mysqli_error($conn), 'query' => $query_history]);
        exit;
    }

    echo json_encode(['success' => true, 'message' => 'Order placed successfully!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
