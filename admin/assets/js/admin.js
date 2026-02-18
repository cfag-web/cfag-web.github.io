// Admin-specific JavaScript

// Confirm delete actions
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide success messages after 5 seconds
    const successMessages = document.querySelectorAll('.alert.success');
    successMessages.forEach(function(msg) {
        setTimeout(function() {
            msg.style.transition = 'opacity 0.3s';
            msg.style.opacity = '0';
            setTimeout(function() {
                msg.remove();
            }, 300);
        }, 5000);
    });
    
    // Form validation enhancements
    const forms = document.querySelectorAll('form');
    forms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(function(field) {
                if (!field.value.trim()) {
                    isValid = false;
                    field.style.borderColor = '#dc3545';
                } else {
                    field.style.borderColor = '';
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('Please fill in all required fields.');
            }
        });
    });
});

