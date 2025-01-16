document.addEventListener('DOMContentLoaded', function () {
    var subtotal = 0;
    var taxRate = 0.10;
    var deliveryFee = 50.00;

    // Load existing order items on page load
    var orderItems = JSON.parse(localStorage.getItem('orderItems')) || {};
    updateOrderList(orderItems);

    document.querySelectorAll('.menu-item').forEach(item => {
        item.addEventListener('click', function () {
            var name = this.dataset.name;
            var price = parseFloat(this.dataset.price);
            var image = this.dataset.image;
            var description = this.dataset.description;
            const foodId = this.dataset.foodId;

            document.querySelector('#foodModal .modal-image').src = image;
            document.querySelector('#foodModal .modal-name').textContent = name;
            document.querySelector('#foodModal .modal-description').textContent = description;
            document.querySelector('#foodModal .modal-price').textContent = '$' + price.toFixed(2);
            document.querySelector('#foodModal').setAttribute('data-food-id', foodId);

            fetch(`get-size.php?food_id=${foodId}`)
                .then(response => response.json())
                .then(data => {
                    const sizeOptionsHtml = data.sizes?.length > 0
                        ? data.sizes.map(size => `<label><input type="radio" name="size" data-pricing-id="${size.id}" value="${size.id}"> ${size.name}</label><br>`).join('')
                        : '<p>No sizes available.</p>';
                    document.querySelector('#foodModal .size-options').innerHTML = sizeOptionsHtml;
                })
                .catch(() => {
                    document.querySelector('#foodModal .size-options').innerHTML = '<p>Error loading sizes.</p>';
                });

            document.querySelector('#foodModal').style.display = 'block';
        });
    });

    document.addEventListener('change', function (event) {
        if (event.target.matches('#foodModal .size-options input[type="radio"]')) {
            const sizeId = event.target.value;
            const foodId = document.querySelector('#foodModal').getAttribute('data-food-id');

            fetch(`get-size.php?food_id=${foodId}&size_id=${sizeId}`)
                .then(response => response.json())
                .then(data => {
                    document.querySelector('#foodModal .modal-price').textContent = data.size_name
                        ? `${data.size_name}: $${parseFloat(data.price).toFixed(2)}`
                        : 'Error loading price.';
                })
                .catch(() => {
                    document.querySelector('#foodModal .modal-price').textContent = 'Error loading price.';
                });
        }
    });

    document.querySelector('.close').addEventListener('click', function () {
        document.querySelector('#foodModal').style.display = 'none';
    });

    document.querySelector('#addToCartBtn').addEventListener('click', function () {
        var name = document.querySelector('#foodModal .modal-name').textContent;
        var price = parseFloat(document.querySelector('#foodModal .modal-price').textContent.replace(/[^\d.]/g, ''));
        var image = document.querySelector('#foodModal .modal-image').src;
        var pricingId = document.querySelector('input[name="size"]:checked')?.dataset.pricingId;
        var sizeName = document.querySelector('input[name="size"]:checked')?.parentNode.textContent.trim();

        if (!pricingId) {
            alert('Please select a size.');
            return;
        }

        var itemKey = `${name} (${sizeName})`;

        if (orderItems[itemKey]) {
            orderItems[itemKey].quantity++;
        } else {
            orderItems[itemKey] = {
                pricing_id: pricingId,
                name: itemKey,
                price: price,
                image: image,
                quantity: 1
            };
        }

        console.log('Adding to Cart:', {
            foodId: document.querySelector('#foodModal').getAttribute('data-food-id'),
            pricingId: pricingId,
            sizeName: sizeName,
            price: price
        });

        updateOrderList(orderItems);
        document.querySelector('#foodModal').style.display = 'none';
    });

    document.addEventListener('click', function (event) {
        if (event.target.matches('.remove-item')) {
            var card = event.target.closest('.order-card');
            var name = card.querySelector('.order-detail p').textContent.trim();

            if (orderItems[name]) {
                delete orderItems[name];
            }

            updateOrderList(orderItems);
        }
    });

    document.querySelector('#checkout-btn').addEventListener('click', function () {
        if (Object.keys(orderItems).length === 0) {
            alert('Your cart is empty!');
            return;
        }

        fetch('checkout.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                action: 'checkout',
                order_items: orderItems
            })
        })
        .then(response => response.json())
        .then(response => {
            console.log('Parsed Response:', response);
            if (response.success) {
                alert('Order placed successfully!');
                localStorage.removeItem('orderItems');
                updateOrderList({});
            } else if (response.message) {
                alert('Checkout failed: ' + response.message);
            } else {
                alert('Checkout failed');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Checkout failed due to a network or server error.');
        });
    });

    function updateOrderList(orderItems) {
        var html = '';
        var subtotal = 0;

        if (Object.keys(orderItems).length === 0) {
            html = '<p>Your cart is empty.</p>';
        } else {
            for (let [index, item] of Object.entries(orderItems)) {
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
            }
        }

        localStorage.setItem('orderItems', JSON.stringify(orderItems));

        document.querySelector('#order-items').innerHTML = html;
        document.querySelector('#subtotal').textContent = '$' + subtotal.toFixed(2);
        document.querySelector('#tax').textContent = '$' + (subtotal * taxRate).toFixed(2);
        document.querySelector('#total').textContent = '$' + (subtotal + deliveryFee).toFixed(2);
    }
});
