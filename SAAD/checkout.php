<?php
session_start();
include("connection.php");  // Ensure your database connection script is included

// Decode JSON data from the input stream
$data = json_decode(file_get_contents('php://input'), true);

// Check if action is set and if it is a checkout request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($data['action']) && $data['action'] === 'checkout') {
    if (!isset($_SESSION['userinfo'])) {
        echo json_encode(['success' => false, 'message' => 'User not logged in']);
        exit;
    }
    
    $userId = $_SESSION['userinfo']['user_id'];  // Access user_id from session
    $orderItems = $data['order_items'] ?? [];  // Access order items from JSON data

    if (empty($orderItems)) {
        echo json_encode(['success' => false, 'message' => 'No items in order']);
        exit;
    }

    // Calculate the total price
    $totalPrice = 0;
    foreach ($orderItems as $item) {
        if (empty($item['pricing_id']) || empty($item['quantity'])) {
            echo json_encode(['success' => false, 'message' => 'Invalid item data']);
            exit;
        }
        $totalPrice += $item['price'] * $item['quantity'];
    }

    // Use the first item's prep_date for the order (adjust logic if needed)
    $preparation_date = reset($orderItems)['prep_date'] ?? date('Y-m-d');

    // Insert into the orders table (one-time insert)
    $stmt = $conn->prepare("INSERT INTO orders (user_id, order_date, preparation_date, total_price, status) VALUES (?, NOW(), ?, ?, 'Pending')");
    $stmt->bind_param("ssd", $userId, $preparation_date, $totalPrice);
    if (!$stmt->execute()) {
        echo json_encode(['success' => false, 'message' => 'Failed to create order: ' . $stmt->error]);
        exit;
    }
    $orderId = $stmt->insert_id;  // Get the last inserted order ID

    // Insert each item into the order_items table
    $stmt = $conn->prepare("INSERT INTO order_items (order_id, pricing_id, quantity) VALUES (?, ?, ?)");
    foreach ($orderItems as $item) {
        $pricingId = $item['pricing_id'];
        $quantity = $item['quantity'];
        $stmt->bind_param("iii", $orderId, $pricingId, $quantity);
        if (!$stmt->execute()) {
            echo json_encode(['success' => false, 'message' => 'Failed to add item to order: ' . $stmt->error]);
            exit;
        }
    }

    echo json_encode(['success' => true, 'message' => 'Order placed successfully!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>