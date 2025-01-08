<?php
session_start();

// Get the method of the request
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod === 'POST') {
    // Handle saving the cart data to the session
    $cart = json_decode(file_get_contents('php://input'), true);
    $_SESSION['cart'] = $cart;
    echo json_encode(['success' => true, 'message' => 'Cart updated successfully.']);
} elseif ($requestMethod === 'GET') {
    // Handle retrieving the cart data from the session
    $cart = $_SESSION['cart'] ?? [];
    echo json_encode($cart);
} else {
    // Handle unsupported request methods
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}
