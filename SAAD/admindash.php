<?php
include('connection.php');

    // Calculate daily, weekly, monthly orders
    $daily_orders_query = "SELECT COUNT(*) AS total_orders FROM orders WHERE DATE(order_date) = CURDATE()"; 
    $daily_orders_result = $conn->query($daily_orders_query);
    $daily_orders = $daily_orders_result->fetch_assoc()['total_orders'];

    $weekly_orders_query = "SELECT COUNT(*) AS total_orders FROM orders WHERE order_date >= DATE(NOW() - INTERVAL 7 DAY)"; 
    $weekly_orders_result = $conn->query($weekly_orders_query);
    $weekly_orders = $weekly_orders_result->fetch_assoc()['total_orders']; 

    $monthly_orders_query = "SELECT COUNT(*) AS total_orders FROM orders WHERE order_date >= DATE(NOW() - INTERVAL 1 MONTH)"; 
    $monthly_orders_result = $conn->query($monthly_orders_query);
    $monthly_orders = $monthly_orders_result->fetch_assoc()['total_orders']; 

    // Calculate total revenue
    $total_revenue_query = "SELECT SUM(total_price) AS total_revenue FROM orders";
    $total_revenue_result = $conn->query($total_revenue_query);
    $total_revenue = $total_revenue_result->fetch_assoc()['total_revenue'];

    // Calculate order counts for specific statuses
    $pending_orders_query = "SELECT COUNT(*) AS order_count FROM orders WHERE status = 'Pending'";
    $pending_orders_result = $conn->query($pending_orders_query);
    $pending_orders = $pending_orders_result->fetch_assoc()['order_count'];

    $progress_orders_query = "SELECT COUNT(*) AS order_count FROM orders WHERE status = 'In-progress'";
    $progress_orders_result = $conn->query($progress_orders_query);
    $progress_orders = $progress_orders_result->fetch_assoc()['order_count'];

    $completed_orders_query = "SELECT COUNT(*) AS order_count FROM orders WHERE status = 'Completed'";
    $completed_orders_result = $conn->query($completed_orders_query);
    $completed_orders = $completed_orders_result->fetch_assoc()['order_count'];
// Fetch orders with details
$orders_query = "SELECT o.order_id, o.order_date, o.total_price, o.status, fname, lname FROM orders o JOIN userinfo u ON o.user_id = u.user_id";

// Handle search and filtering
$where_clause = "";

if (isset($_GET['status']) && !empty($_GET['status'])) {
    $status = mysqli_real_escape_string($conn, $_GET['status']); 
    $where_clause .= " WHERE o.status = '$status'";
}

if (isset($_GET['date_from']) && !empty($_GET['date_from']) && isset($_GET['date_to']) && !empty($_GET['date_to'])) {
    $date_from = mysqli_real_escape_string($conn, $_GET['date_from']);
    $date_to = mysqli_real_escape_string($conn, $_GET['date_to']);

    if (empty($where_clause)) {
        $where_clause .= " WHERE ";
    } else {
        $where_clause .= " AND ";
    }

    $where_clause .= "o.order_date BETWEEN '$date_from' AND '$date_to'";
}

// Append WHERE clause to the main query
$orders_query .= $where_clause;

$orders_result = $conn->query($orders_query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="css/admindash.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="top">
            <div class="logo">
                <i class='bx bxl-codepen'></i>
                <span>HUHUHUHUHU</span>
            </div>
            <i class="bx bx-menu" id="btn"></i>
        </div>

        <div class="user">
            <div>
                <p class="bold">Ferd O.</p>
                <p>Admin</p>
            </div>
        </div>
        <ul>
            <li>
                <a href="admindash.php">
                    <i class="bx bxs-grid-alt"></i>
                    <span class="nav-item">Dashboard</span>
                </a>
                <span class="tooltip">Dashboard</span>
            </li>
            <li>
                <a href="order_management.php">
                    <i class="bx bx-list-check"></i>
                    <span class="nav-item">Order Management</span>
                </a>
                <span class="tooltip">Order Management</span>
            </li>
            <li>
                <a href="menu_management.php">
                    <i class="bx bxs-shopping-bag"></i>
                    <span class="nav-item">Menu Management</span>
                </a>
                <span class="tooltip">Menu Management</span>
            </li>
            <li>
                <a href="#">
                    <i class="bx bxs-food-menu"></i>
                    <span class="nav-item">Customer Management</span>
                </a>
                <span class="tooltip">Customer Management</span>
            </li>
            <li>
                <a href="#">
                    <i class="bx bx-log-out"></i>
                    <span class="nav-item">Logout</span>
                </a>
                <span class="tooltip">Logout</span>
            </li>
        </ul>
    </div>

    <h3 class="head-t">Welcome Admin!😭😭😭</h3>

    <!-- HTML Form -->

    <!-- Total order -->
    <div class="stock-info">
    <div class="stock">
      <h3>Total Orders</h3>
    </div>
      <ul>
        <li>
          <span>Today:</span>
          <br>
          <span class="stock-number"><?php echo $daily_orders; ?></span>
        </li>
        <li>
          <span>This Week:</span>
          <br>
          <span class="stock-number"><?php echo $weekly_orders; ?></span>
        </li>
        <li>
          <span>This Month:</span>
          <br>
          <span class="stock-number"><?php echo $monthly_orders; ?></span>
        </li>
      </ul>
    </div>

    <!-- revenue -->
    <div class="stock-info">
    <div class="stock">
      <h3>Revenue Summary</h3>
    </div>
      <ul>
        <li>
          <span>Total Revenue:</span>
          <br>
          <span class="stock-number"><?php echo number_format($total_revenue, 2); ?></span>
        </li>
      </ul>
    </div>
    
    <!-- order status-->
    <div class="stock-info">
    <div class="stock">
        <h3>Order Status</h3>
    </div>
    <ul>
        <li> 
        <span>Pending:</span>
        <br>
        <span class="stock-number"><?php echo $pending_orders; ?></span>
        </li>
        <li> 
        <span>In-progress:</span>
        <br>
        <span class="stock-number"><?php echo $progress_orders; ?></span>
        </li>
        <li>
        <span>Completed:</span>
        <br>
        <span class="stock-number"><?php echo $completed_orders; ?></span>
        </li>
    </ul>
</div>

    <!--order management-->
    <div class="order-management">
        <h2>Order Management</h2>

        <form>
            <label for="status">Filter by Status:</label>
            <select name="status">
                <option value="">All</option>
                <option value="Pending">Pending</option>
                <option value="Preparing">Preparing</option>
                <option value="Out for Delivery">Out for Delivery</option>
                <option value="Delivered">Delivered</option>
                <option value="Cancelled">Cancelled</option>
                <option value="Completed">Completed</option>
            </select>

            <label for="date_from">Date From:</label>
            <input type="date" name="date_from">

            <label for="date_to">Date To:</label>
            <input type="date" name="date_to">

            <button type="submit">Filter</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Order Date</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Delivery/Pickup Time</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($orders_result->num_rows > 0) {
                    while ($row = $orders_result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['order_id'] . "</td>";
                        echo "<td>" . $row['fname'] . " " . $row['lname'] . "</td>";
                        echo "<td>" . $row['order_date'] . "</td>";
                        echo "<td>" . $row['total_price'] . "</td>";
                        echo "<td>" . $row['status'] . "</td>";
                        echo "<td>
                                <button>View Details</button> 
                                <button>Update Status</button> 
                            </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No orders found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>

<script>
    let btn = document.querySelector('#btn')
    let sidebar = document.querySelector('.sidebar')

    btn.onclick = function(){
        sidebar.classList.toggle('active')
    };
</script>

</html>