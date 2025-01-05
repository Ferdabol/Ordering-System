$(document).ready(function () {
    var subtotal = 0;
    var taxRate = 0.10;
    var deliveryFee = 50.00;

    // Load existing order items on page load
    var orderItems = JSON.parse(localStorage.getItem('orderItems')) || {};
    updateOrderList(orderItems);

    // Show Modal on Food Item Click
    $('.menu-item').on('click', function () {
        var name = $(this).data('name');
        var price = parseFloat($(this).data('price'));
        var image = $(this).data('image');
        var description = $(this).data('description');
        const foodId = $(this).data('food-id');
        console.log('foodId:', foodId);
        console.log($(this).data());

        // Populate modal with food details
        $('#foodModal .modal-image').attr('src', image);
        $('#foodModal .modal-name').text(name);
        $('#foodModal .modal-description').text(description);
        $('#foodModal .modal-price').text('$' + price.toFixed(2));
        $('#foodModal').attr('data-food-id', foodId);
        console.log('Setting foodId:', foodId);

        // Fetch size options dynamically
        fetch(`get-size.php?food_id=${foodId}`)
            .then(response => response.json())
            .then(data => {
                console.log('Size Options Response:', data); // Debugging
                if (data.sizes && data.sizes.length > 0) {
                    const sizeOptionsHtml = data.sizes.map(size => `
                        <label>
                            <input type="radio" name="size" value="${size.id}"> ${size.name}
                        </label><br>
                    `).join('');
                    $('#foodModal .size-options').html(sizeOptionsHtml);
                } else {
                    console.error('No sizes available for food item with ID', foodId);
                    $('#foodModal .size-options').html('<p>No sizes available.</p>');
                }
            })
            .catch(error => {
                console.error('Error fetching sizes:', error);
                $('#foodModal .size-options').html('<p>Error loading sizes.</p>');
            });

        $('#foodModal').fadeIn(); // Show the modal
    });

    // Update modal price on size selection
    $(document).on('change', '#foodModal .size-options input[type="radio"]', function () {
        const sizeId = $(this).val(); // Get selected size ID
        const foodId = $('#foodModal').attr('data-food-id'); // Get food ID from modal
        console.log(`Fetching: get-size.php?food_id=${foodId}&size_id=${sizeId}`);

        console.log(`Selected Size ID: ${sizeId}, Food ID: ${foodId}`); // Debugging

        fetch(`get-size.php?food_id=${foodId}&size_id=${sizeId}`)
            .then(response => response.json())
            .then(data => {
                if (data.size_name && data.price) {
                    $('#foodModal .modal-price').text(`${data.size_name}: $${parseFloat(data.price).toFixed(2)}`);
                } else {
                    console.error('Invalid response:', data);
                    $('#foodModal .modal-price').text('Error loading price.');
                }
            })
            .catch(error => {
                console.error('Error fetching size price:', error);
                $('#foodModal .modal-price').text('Error loading price.');
            });
    });

    // Close Modal
    $('.close').on('click', function () {
        $('#foodModal').fadeOut();
    });

    // Add to Cart from Modal
    $('#addToCartBtn').on('click', function () {
        var name = $('#foodModal .modal-name').text();
        var price = parseFloat($('#foodModal .modal-price').text().replace(/[^\d.]/g, ''));
        var image = $('#foodModal .modal-image').attr('src');
        var size = $('input[name="size"]:checked').val();
        var sizeName = $('input[name="size"]:checked').parent().text().trim();

        if (!size) {
            alert('Please select a size.');
            return;
        }

        // Combine name with size for uniqueness
        var itemKey = `${name} (${sizeName})`;

        if (orderItems[itemKey]) {
            orderItems[itemKey].quantity++;
        } else {
            orderItems[itemKey] = {
                name: itemKey,
                price: price,
                image: image,
                quantity: 1
            };
        }

        updateOrderList(orderItems);
        $('#foodModal').fadeOut(); // Close the modal after adding
    });

    // Remove Item from Cart
    $(document).on('click', '.remove-item', function () {
        var card = $(this).closest('.order-card');
        var name = card.find('.order-detail p').text().trim();

        if (orderItems[name]) {
            delete orderItems[name];
        }

        updateOrderList(orderItems);
    });

    // Checkout Process
    $('#checkout-btn').on('click', function () {
        var orderItems = JSON.parse(localStorage.getItem('orderItems')) || {};

        if ($.isEmptyObject(orderItems)) {
            alert('Your cart is empty!');
            return;
        }

        $.ajax({
            type: 'POST',
            url: 'checkout.php',
            data: {
                action: 'checkout',
                order_items: JSON.stringify(orderItems)
            },
            success: function (response) {
                console.log('Raw Response:', response);
                if (response.success) {
                    alert('Order placed successfully!');
                    localStorage.removeItem('orderItems');
                    updateOrderList({});
                } else {
                    alert('Checkout failed: ' + response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', status, error);
                alert('An error occurred during checkout: ' + error);
            }
        });
    });

    // Update Order List
    function updateOrderList(orderItems) {
        var html = '';
        var subtotal = 0;

        if ($.isEmptyObject(orderItems)) {
            html = '<p>Your cart is empty.</p>';
        } else {
            $.each(orderItems, function (index, item) {
                subtotal += item.price * item.quantity;
                html += '<div class="order-card">';
                html += '<img class="order-image" src="' + item.image + '">';
                html += '<div class="order-detail">';
                html += '<p>' + item.name + '</p>';
                html += '<i class="fa fa-times remove-item"></i>';
                html += '<input type="text" value="' + item.quantity + '" readonly>';
                html += '</div>';
                html += '<h4 class="order-price">$' + (item.price * item.quantity).toFixed(2) + '</h4>';
                html += '</div>';
            });

            
        }

        localStorage.setItem('orderItems', JSON.stringify(orderItems));

        // Update Cart Details
        $('#order-items').html(html);
        $('#subtotal').text('$' + subtotal.toFixed(2));
        $('#tax').text('$' + (subtotal * taxRate).toFixed(2));
        $('#total').text('$' + (subtotal + deliveryFee).toFixed(2));
    }
});
