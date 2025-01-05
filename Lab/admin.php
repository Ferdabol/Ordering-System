<?php
include('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST["name"];
    $description = $_POST["description"];
    $time = $_POST["time"];
    $image = $_FILES["image"];
    $sizes = $_POST['sizes'];
    $prices = $_POST['prices'];

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
        $sql = "INSERT INTO food (name, description, time, image) VALUES ('$name', '$description', '$time', '$target_file')";
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

            echo "Menu item added successfully with sizes and prices.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>

<!-- HTML Form -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required>

    <label for="description">Description:</label>
    <textarea id="description" name="description" required></textarea>

    <label for="time">Time:</label>
    <input type="text" id="time" name="time" required>

    <label for="image">Image:</label>
    <input type="file" id="image" name="image" required>

    <div id="size-pricing">
        <label>Sizes and Prices:</label>
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
        </div>
    </div>
    <button type="button" onclick="addSize()">Add Another Size</button>

    <input type="submit" value="Add Menu Item">
</form>

<script>
function addSize() {
    // Clone the size-group div and append it to the size-pricing section
    const sizeGroup = document.querySelector('.size-group');
    const clone = sizeGroup.cloneNode(true);
    document.getElementById('size-pricing').appendChild(clone);
}
</script>
