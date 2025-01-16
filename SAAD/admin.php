<?php
include('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST["name"];
    $description = $_POST["description"];
    $image = $_FILES["image"];
    $category_name = $_POST["category"];
    $sizes = $_POST['sizes'];
    $prices = $_POST['prices'];

    $category_sql = "SELECT category_id FROM category WHERE category_name = '$category_name'";
    $category_result = $conn->query($category_sql);
    $category_row = $category_result->fetch_assoc();
    $category_id = $category_row['category_id'];

    // Handle image upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($image["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (move_uploaded_file($image["tmp_name"], $target_file)) {
        echo "The file " . basename($image["name"]) . " has been uploaded.<br>";
    } else {
        echo "Sorry, there was an error uploading your file.<br>";
        $uploadOk = 0;
    }

    if ($uploadOk) {
        // Insert into `food` table
        $sql = "INSERT INTO food (name, description, image, category_id) VALUES ('$name', '$description', '$target_file', '$category_id')";
        if ($conn->query($sql) === TRUE) {
            $food_id = $conn->insert_id; // Get the ID of the newly inserted food item

            // Insert sizes and prices into `food_size_pricing` table
            foreach ($sizes as $index => $size_id) {
                $price = $prices[$index];
                $pricing_sql = "INSERT INTO food_size_pricing (food_id, size_id, price) VALUES ('$food_id', '$size_id', '$price')";
                if (!$conn->query($pricing_sql)) {
                    echo "Error: " . $pricing_sql . "<br>" . $conn->error;
                }
            }

            echo "Menu item added successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="css/admin.css">
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
                <a href="#">
                    <i class="bx bxs-grid-alt"></i>
                    <span class="nav-item">Dashboard</span>
                </a>
                <span class="tooltip">Dashboard</span>
            </li>
            <li>
                <a href="#">
                    <i class="bx bx-list-check"></i>
                    <span class="nav-item">Categories</span>
                </a>
                <span class="tooltip">Categories</span>
            </li>
            <li>
                <a href="#">
                    <i class="bx bxs-shopping-bag"></i>
                    <span class="nav-item">Products</span>
                </a>
                <span class="tooltip">Products</span>
            </li>
            <li>
                <a href="#">
                    <i class="bx bxs-food-menu"></i>
                    <span class="nav-item">Orders</span>
                </a>
                <span class="tooltip">Orders</span>
            </li>
            <li>
                <a href="#">
                    <i class="bx bx-body"></i>
                    <span class="nav-item">Customers</span>
                </a>
                <span class="tooltip">Customers</span>
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

    <h3 class="head-t">HUHUHUHUHU</h3>
    <!-- HTML Form -->
    <div class="product-container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <div class="product-box">
            <div class="product-header">
                <h1 class="product-title">ADD PRODUCT</h1>
            </div>
            <div class="edit-product">
                <label for="name">Product Name</label>
                <br>
                <input type="text" id="name" name="name" placeholder="Enter Product Name" required>
            </div>
            
            <div class="edit-product">
                <label for="description">Product Description</label>
                <br>
                <textarea id="description" name="description" placeholder="Enter Product Description" required></textarea>
            </div>
            
            <div class="edit-product">
                <label for="image">Product Image</label>
                <br>
                <input type="file" id="image" name="image" required>
            </div>

            <div class="edit-product">
                <label for="image">Product Category</label>
                <br>
                <select name="category" id="category" required>
                    <?php
                    $category_sql = "SELECT category_name FROM category";
                    $category_result = $conn->query($category_sql);
                    while ($category_row = $category_result->fetch_assoc()) {
                        echo "<option value='" . $category_row['category_name'] . "'>" . $category_row['category_name'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="edit-product">
                <div id="size-pricing">
                    <label>Sizes and Prices:</label>
                    <br>
                    <div class="size-group">
                        <select name="sizes[]" required>
                            <?php
                            // Fetch sizes from the `size` table
                            $size_query = "SELECT size_id, size_name FROM size";
                            $result = $conn->query($size_query);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['size_id'] . "'>" . $row['size_name'] . "</option>";
                                }
                            } else {
                                echo "<option value=''>No sizes available</option>";
                            }
                            ?>
                        </select>
                        <input type="text" name="prices[]" placeholder="Price for this size" required>
                        <br>
                        <button type="button" onclick="addSize()">Add Another Size</button>
                    </div>
                    <br>
                </div>
            </div>
            
            <div class="submit">
                <input type="submit" value="Add Item">               
                <input type="submit" value="Update Item">
            </div>
            <br>

        </div>
        </form>

        <div class="products">
            <div class="header-container">
                <h1 class="title-container">PRODUCT LIST</h1>
            </div>
            <div class="product-list">
                <?php
                // Include database connection
                include('connection.php');

                // Query to fetch product and category details
                $sql = "SELECT f.name AS food_name, f.description, f.image, c.category_name 
                        FROM food f 
                        LEFT JOIN category c ON f.category_id = c.category_id";
                $result = $conn->query($sql);

                // Check if any products exist
                if ($result->num_rows > 0) {
                    echo "<table class='table-header'>
                            <tr class='row-header'>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Image</th>
                                <th>Category</th>
                                <th></th>
                            </tr>";
                    
                    // Loop through each product and display in table
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row['food_name']) . "</td>
                                <td>" . htmlspecialchars($row['description']) . "</td>
                                <td><img src='" . htmlspecialchars($row['image']) . "' alt='Product Image' width='100'></td>
                                <td>" . htmlspecialchars($row['category_name'] ?: 'Uncategorized') . "</td>
                                <td>Details</td>
                            </tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>No products available.</p>";
                }

                // Close the database connection
                $conn->close();
                ?>
            </div>
        </div>

    </div>

    <script>
    function addSize() {
        // Clone the size-group div and append it to the size-pricing section
        const sizeGroup = document.querySelector('.size-group');
        const clone = sizeGroup.cloneNode(true);
        document.getElementById('size-pricing').appendChild(clone);
    }
    </script>

</body>

<script>
    let btn = document.querySelector('#btn')
    let sidebar = document.querySelector('.sidebar')

    btn.onclick = function(){
        sidebar.classList.toggle('active')
    };
</script>

</html>
