document.addEventListener('DOMContentLoaded', function() {
    const decrementButtons = document.querySelectorAll('.decrement');
    const incrementButtons = document.querySelectorAll('.increment');
    const valueSpans = document.querySelectorAll('.value');
    const basketSummary = document.getElementById('basket_summary');

    decrementButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            let itemId = this.getAttribute('data-id');
            let count = parseInt(document.getElementById('quantity_' + itemId).textContent);
            if (count > 1) {
                count--;
                updateValue(itemId, count);
            }
        });
    });

    incrementButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            let itemId = this.getAttribute('data-id');
            let count = parseInt(document.getElementById('quantity_' + itemId).textContent);
            count++;
            updateValue(itemId, count);
        });
    });

    function updateValue(itemId, count) {
        fetch('/basket/update/' + itemId, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ count: count })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('quantity_' + itemId).textContent = count;

                    let price = count * parseFloat(document.getElementById('total_price_' + itemId).getAttribute('data-price'));
                    document.getElementById('total_price_' + itemId).textContent = price + ' ₽';

                    let priceWithout = count * parseFloat(document.getElementById('total_price_without_' + itemId).getAttribute('data-price-without'));
                    document.getElementById('total_price_without_' + itemId).textContent = priceWithout + ' ₽';

                    updateBasketSummary();
                } else {
                    console.error('Failed to update quantity');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    function updateBasketSummary() {
        fetch('/basket/summary', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('item_count').textContent = data.itemCount + ' товар(ов)';
                    document.querySelector('.total_price').textContent = data.totalPrice + ' ₽';
                    document.querySelector('.discount').textContent = data.totalDiscount + ' ₽';
                    document.querySelector('.grand_total').textContent = data.grandTotal + ' ₽';
                } else {
                    console.error('Failed to update basket summary');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
});
