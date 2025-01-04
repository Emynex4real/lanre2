function showPurchaseModal(status = 'processing') {
    const modal = document.getElementById('purchaseModal');
    const loader = document.getElementById('loader');
    const message = document.getElementById('modalMessage');

    // Show the modal
    modal.style.display = 'flex';

    // Update modal content based on status
    if (status === 'processing') {
        loader.style.display = 'block';
        message.textContent = 'Processing your purchase...';
    } else if (status === 'success') {
        loader.style.display = 'none';
        message.textContent = 'Purchase successful!';
        message.style.color = 'green';
    } else if (status === 'insufficient') {
        loader.style.display = 'none';
        message.textContent = 'Insufficient balance.';
        message.style.color = 'red';
    }

    // Hide the modal after 3 seconds for success or error
    if (status !== 'processing') {
        setTimeout(() => {
            modal.style.display = 'none';
            message.style.color = ''; // Reset message color
        }, 3000);
    }
}

// Example usage:
// Simulate a purchase process
function simulatePurchase() {
    showPurchaseModal('processing');

    // Simulate a server response
    setTimeout(() => {
        const success = Math.random() > 0.5; // Simulate success/failure
        if (success) {
            showPurchaseModal('success');
        } else {
            showPurchaseModal('insufficient');
        }
    }, 2000); // Simulate 2 seconds of processing time
}




document.getElementById("buy-subscription-btn").addEventListener('click', (e) => {
    simulatePurchase();
})
