document.getElementById('cancelLoanBtn').addEventListener('click', function() {
    if (confirm('Are you sure you want to cancel your loan application? This action cannot be undone.')) {
        // Redirect to a PHP script to handle loan cancellation
        window.location.href = 'cancel_loan.php';
    }
});
