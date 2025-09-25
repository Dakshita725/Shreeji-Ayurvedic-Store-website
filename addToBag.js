// JavaScript to handle quantity changes and removal
document.addEventListener('DOMContentLoaded', function() {
    const increaseButtons = document.querySelectorAll('.btn-increase');
    const decreaseButtons = document.querySelectorAll('.btn-decrease');
    const removeButtons = document.querySelectorAll('.btn-remove');
    
    increaseButtons.forEach(button => {
        button.addEventListener('click', function() {
            const quantityInput = this.previousElementSibling;
            quantityInput.value = parseInt(quantityInput.value) + 1;
            updateTotals();
        });
    });

    decreaseButtons.forEach(button => {
        button.addEventListener('click', function() {
            const quantityInput = this.nextElementSibling;
            if (parseInt(quantityInput.value) > 1) {
                quantityInput.value = parseInt(quantityInput.value) - 1;
                updateTotals();
            }
        });
    });

    removeButtons.forEach(button => {
        button.addEventListener('click', function() {
            this.closest('.bag-item').remove();
            updateTotals();
        });
    });

    function updateTotals() {
        let totalItems = 0;
        let totalPrice = 0;
        document.querySelectorAll('.bag-item').forEach(item => {
            const quantity = parseInt(item.querySelector('.quantity-input').value);
            const price = parseFloat(item.querySelector('p').innerText.replace('₹', ''));
            totalItems += quantity;
            totalPrice += quantity * price;
        });
        document.getElementById('total-items').innerText = totalItems;
        document.getElementById('total-price').innerText = totalPrice.toFixed(2);
    }
});
