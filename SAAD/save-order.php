<?php
// save-order.php
session_start();
// Check if the order_items and subtotal keys exist in the $_POST array
if (isset($_POST['order_items']) && isset($_POST['subtotal'])) {
    echo "Order items and subtotal data is present!";
    $orderItems = json_decode($_POST['order_items'], true);
    $subtotal = $_POST['subtotal'];

    echo "Order items: ";
    print_r($orderItems);
    echo "Subtotal: $subtotal";

    // Update the order data in the session
    $_SESSION['order']['order_items'] = $orderItems;
    $_SESSION['order']['subtotal'] = $subtotal;
    $_SESSION['order']['tax'] = $subtotal * 0.10;
    $_SESSION['order']['total'] = $subtotal + 50;

    echo "Order updated successfully!";
} else {
    echo "Error: Missing order data.";
}
?>


