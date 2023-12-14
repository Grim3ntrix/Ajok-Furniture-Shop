function removeItem(productId) {
    // Show the confirmation modal
    $('#removeConfirmationModal' + productId).modal('show');
}


function updateQuantity(productId, quantityChange) {
    var quantityElement = document.getElementById('quantity-' + productId);
    var currentQuantity = parseInt(quantityElement.value);
    var maxQuantity = parseInt(quantityElement.getAttribute('data-max-quantity'));

    var newQuantity = currentQuantity + quantityChange;

    if (newQuantity < 1 || newQuantity > maxQuantity) {
        return;
    }

    quantityElement.value = newQuantity;

    updateQuantityAJAX(productId, newQuantity);

    calculateSubtotal();
}



function calculateSubtotal() {
    let subtotal = 0;
    const checkboxes = document.querySelectorAll('.product-checkbox:checked');

    checkboxes.forEach(function(checkbox) {
        const price = parseFloat(checkbox.getAttribute('data-price'));
        const quantityElement = checkbox.closest('tr').querySelector('.quantity-input');
        const quantity = parseInt(quantityElement.value);
        subtotal += price * quantity;
    });

    const subtotalAmount = document.querySelector('.subtotal-amount');
    subtotalAmount.textContent = '₱' + subtotal.toFixed(2);
}


const checkboxes = document.querySelectorAll('.product-checkbox');
checkboxes.forEach(function(checkbox) {
    checkbox.addEventListener('change', calculateSubtotal);
});

// Add this function to update the quantity in the session using AJAX
function updateQuantityAJAX(productId, newQuantity) {
    // Send an AJAX request to update the quantity
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'update_quantity.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Parse the JSON response
            var response = JSON.parse(xhr.responseText);

            // Check if the quantity update was successful
            if (response.success) {
                // Update the subtotal after successful quantity update
                calculateSubtotal();
            } else {
                // Handle the error case if needed
                console.error('Quantity update failed');
            }
        }
    };
    xhr.send('product_id=' + productId + '&quantity=' + newQuantity);
}
