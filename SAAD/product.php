<?php
session_start();
include('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $food_id = isset($_POST["food_id"]) && !empty($_POST["food_id"]) ? intval($_POST["food_id"]) : null;
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

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($image["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (!empty($image["tmp_name"])) {
        if (move_uploaded_file($image["tmp_name"], $target_file)) {
            echo "The file " . basename($image["name"]) . " has been uploaded.<br>";
        } else {
            echo "Sorry, there was an error uploading your file.<br>";
            $uploadOk = 0;
        }
    } else {
        $uploadOk = 0;
    }

    if ($food_id) {
        // Update existing food item
        $update_image = $uploadOk ? ", image = '$target_file'" : "";
        $sql = "UPDATE food SET name = '$name', description = '$description', category_id = '$category_id' $update_image WHERE food_id = $food_id";
        if ($conn->query($sql) === TRUE) {
            // Remove old size/price associations
            $delete_sizes = "DELETE FROM food_size_pricing WHERE food_id = $food_id";
            $conn->query($delete_sizes);
            
            foreach ($sizes as $index => $size_id) {
                $price = $prices[$index];
                $pricing_sql = "INSERT INTO food_size_pricing (food_id, size_id, price) VALUES ('$food_id', '$size_id', '$price')";
                if (!$conn->query($pricing_sql)) {
                    echo "Error: " . $pricing_sql . "<br>" . $conn->error;
                }
            }
            echo "Food item updated successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        // Add new food item
        if ($uploadOk) {
            $sql = "INSERT INTO food (name, description, image, category_id) VALUES ('$name', '$description', '$target_file', '$category_id')";
            if ($conn->query($sql) === TRUE) {
                $food_id = $conn->insert_id;

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
    <input type="checkbox" id="bell">
    <label for="bell" class="label-bell"><i class="bx bx-bell"></i></label>

    <h3 class="head-t" type="hidden">3wad</h3>

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
                <div>
                    <p class="bold"><?php echo $_SESSION['userinfo']['Fname'] . ' ' . substr($_SESSION['userinfo']['Lname'], 0, 1) . '.'; ?></p>
                    <p>Admin</p>
                </div>
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
                <a href="login.php">
                    <i class="bx bx-log-out"></i>
                    <span class="nav-item">Logout</span>
                </a>
                <span class="tooltip">Logout</span>
            </li>
        </ul>
    </div>
    <!-- HTML Form -->
    <div class="product-container">
        <form id="product-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" id="food_id" name="food_id" value="">
            <div class="product-box">
                <div class="product-header">
                    <h1 class="product-title" id="form-title">ADD PRODUCT</h1>
                </div>
                <div class="edit-product">
                    <label for="name">Product Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter Product Name" required>
                </div>
                <div class="edit-product">
                    <label for="description">Product Description</label>
                    <textarea id="description" name="description" placeholder="Enter Product Description" required></textarea>
                </div>
                <div class="edit-product">
                    <label for="image">Product Image</label>
                    <input type="file" id="image" name="image">
                </div>
                <div class="edit-product">
                    <label for="category">Product Category</label>
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
                    <label>Sizes and Prices:</label>
                    <div id="size-pricing">
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
                            <button type="button" onclick="removeSize(this)">Remove</button>
                        </div>
                        <button type="button" onclick="addSize()">Add Another Size</button>
                    </div>

                </div>
                <div class="submit">
                    <input type="submit" id="form-submit" value="Add Item">
                </div>
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

                $sql = "SELECT f.food_id, f.name AS food_name, f.description, f.image, c.category_name 
                FROM food f 
                LEFT JOIN category c ON f.category_id = c.category_id";
                $result = $conn->query($sql);
        
                if ($result->num_rows > 0) {
                    echo "<table class='table-header'>
                            <tr class='row-header'>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Image</th>
                                <th>Category</th>
                            </tr>";
            
                    while ($row = $result->fetch_assoc()) {
                        $food_id = $row['food_id'];
                        echo "<tr class='food-row' data-food-id='$food_id'>
                                <td>" . htmlspecialchars($row['food_name']) . "</td>
                                <td>" . htmlspecialchars($row['description']) . "</td>
                                <td><img src='" . htmlspecialchars($row['image']) . "' alt='Product Image' width='100'></td>
                                <td>" . htmlspecialchars($row['category_name'] ?: 'Uncategorized') . "</td>
                            </tr>";
            
                                // Fetch sizes and prices for this food item
                                $size_price_sql = "SELECT s.size_name, fsp.price 
                                                FROM food_size_pricing fsp
                                                INNER JOIN size s ON fsp.size_id = s.size_id
                                                WHERE fsp.food_id = $food_id";
                                $size_price_result = $conn->query($size_price_sql);
                        
                                echo "<tr class='details-row' id='details-$food_id' style='display: none;'>
                                        <td colspan='4'>
                                            <strong>Sizes and Prices:</strong><br>";
                                if ($size_price_result->num_rows > 0) {
                                    while ($size_price_row = $size_price_result->fetch_assoc()) {
                                        echo htmlspecialchars($size_price_row['size_name']) . ": $" . htmlspecialchars($size_price_row['price']) . "<br>";
                                    }
                                } else {
                                    echo "No size and price information available.";
                                }
                                echo "  </td>
                                    </tr>";
                            }
                            echo "</table>";
                } else {
                    echo "<p>No products available.</p>";
                }
        
                ?>
            </div>
        </div>

    </div>

</body>

<script>
    let btn = document.querySelector('#btn')
    let sidebar = document.querySelector('.sidebar')

    btn.onclick = function(){
        sidebar.classList.toggle('active')
    };

    function addSize() {
        // Clone the size-group div and append it to the size-pricing section
        const sizeGroup = document.querySelector('.size-group');
        const clone = sizeGroup.cloneNode(true);
        document.getElementById('size-pricing').appendChild(clone);
    }

    document.querySelectorAll('.food-row').forEach(row => {
    row.addEventListener('click', function() {
        const foodId = this.getAttribute('data-food-id');
        const detailsRow = document.getElementById(`details-${foodId}`);
        if (detailsRow.style.display === 'none' || !detailsRow.style.display) {
            detailsRow.style.display = 'table-row';
        } else {
            detailsRow.style.display = 'none';
        }
        });
    });

    let formMode = 'add'; // Tracks the current form mode
    const formTitle = document.getElementById('form-title');
    const formSubmit = document.getElementById('form-submit');
    const formFoodId = document.getElementById('food_id');
    const nameInput = document.getElementById('name');
    const descriptionInput = document.getElementById('description');
    const categoryInput = document.getElementById('category');
    const sizePricingDiv = document.getElementById('size-pricing');

    document.querySelectorAll('.food-row').forEach(row => {
        row.addEventListener('click', function() {
            const foodId = this.getAttribute('data-food-id');
            if (formMode === 'add' || formFoodId.value !== foodId) {
                fetchFoodDetails(foodId);
                switchToEditMode(foodId);
            } else {
                resetFormToAddMode();
            }
        });
    });

    function switchToEditMode(foodId) {
        formMode = 'edit';
        formFoodId.value = foodId;
        formTitle.textContent = 'EDIT PRODUCT';
        formSubmit.value = 'Update Item';
    }

    function resetFormToAddMode() {
        formMode = 'add';
        formFoodId.value = '';
        formTitle.textContent = 'ADD PRODUCT';
        formSubmit.value = 'Add Item';
        nameInput.value = '';
        descriptionInput.value = '';
        categoryInput.value = '';
        sizePricingDiv.innerHTML = ''; // Clear dynamic size/price inputs
    }

    function fetchFoodDetails(foodId) {
        fetch(`get_product_details.php?food_id=${foodId}`)
            .then(response => response.json())
            .then(data => {
                nameInput.value = data.name;
                descriptionInput.value = data.description;
                categoryInput.value = data.category;
                sizePricingDiv.innerHTML = ''; // Clear previous sizes and prices
                data.sizes.forEach(size => {
                    const sizeGroup = document.createElement('div');
                    sizeGroup.classList.add('size-group');
                    sizeGroup.innerHTML = `
                        <select name="sizes[]" required>
                            <option value="${size.size_id}" selected>${size.size_name}</option>
                        </select>
                        <input type="text" name="prices[]" value="${size.price}" required>
                    `;
                    sizePricingDiv.appendChild(sizeGroup);
                });
            })
            .catch(error => console.error('Error fetching food details:', error));
    }

    function addSize() {
    const sizeGroup = document.querySelector('.size-group');
    const clone = sizeGroup.cloneNode(true);
    clone.querySelector('input[name="prices[]"]').value = ''; // Clear cloned price input
    document.getElementById('size-pricing').appendChild(clone);
    }

    function removeSize(button) {
        const sizePricing = document.getElementById('size-pricing');
        if (sizePricing.children.length > 2) {
            button.parentElement.remove(); // Remove only if more than one size group exists
        }
    }



</script>

</html>
