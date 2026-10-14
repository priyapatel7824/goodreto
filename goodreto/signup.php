<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Registration Form</title>
    <!-- Latest Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .form-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.2);
            max-width: 500px;
            width: 100%;
            padding: 40px;
        }
        .form-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .form-header h2 {
            background: linear-gradient(45deg, #4ecdc4, #44a08d);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
            font-size: 2rem;
        }
        .btn-custom {
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }
        .btn-submit {
            background: linear-gradient(45deg, #4ecdc4, #44a08d);
            border: none;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(78, 205, 196, 0.4);
        }
        .btn-cancel {
            background: linear-gradient(45deg, #ff6b6b, #ee5a52);
            border: none;
        }
        .btn-cancel:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 107, 107, 0.4);
        }
        .is-invalid {
            border-color: #ff6b6b !important;
        }
        .error-message {
            color: #ff6b6b;
            font-size: 0.875rem;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="form-card">
        <div class="form-header">
            <h2>Customer Registration</h2>
        </div>
        <form id="customerForm">
            <div class="mb-4">
                <label for="customerName" class="form-label">Customer Name</label>
                <input type="text" class="form-control" id="customerName" name="customerName" required>
                <div class="error-message" id="nameError"></div>
            </div>

            <div class="mb-4">
                <label for="customerAddress" class="form-label">Customer Address</label>
                <input type="text" class="form-control" id="customerAddress" name="customerAddress" required>
                <div class="error-message" id="addressError"></div>
            </div>

            <div class="mb-4">
                <label for="customerEmail" class="form-label">Email ID</label>
                <input type="email" class="form-control" id="customerEmail" name="customerEmail" required>
                <div class="error-message" id="emailError"></div>
            </div>

            <div class="mb-4">
                <label for="customerPhone" class="form-label">Contact Number</label>
                <input type="tel" class="form-control" id="customerPhone" name="customerPhone" required>
                <div class="error-message" id="phoneError"></div>
            </div>

            <div class="d-flex gap-3">
                <button type="submit" class="btn btn-success btn-custom flex-fill btn-submit">Submit</button>
                <button type="button" class="btn btn-danger btn-custom flex-fill btn-cancel" id="cancelBtn">Cancel</button>
            </div>
        </form>
        <div id="messageAlert" class="alert mt-4" role="alert" style="display: none;"></div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const form = document.getElementById('customerForm');
        const messageAlert = document.getElementById('messageAlert');
        const cancelBtn = document.getElementById('cancelBtn');

        const inputs = {
            name: document.getElementById('customerName'),
            address: document.getElementById('customerAddress'),
            email: document.getElementById('customerEmail'),
            phone: document.getElementById('customerPhone')
        };

        const errors = {
            name: document.getElementById('nameError'),
            address: document.getElementById('addressError'),
            email: document.getElementById('emailError'),
            phone: document.getElementById('phoneError')
        };

        // Validation functions
        function validateName(value) { return value.trim().length >= 2; }
        function validateAddress(value) { return value.trim().length >= 5; }
        function validateEmail(value) { 
            return /^[^s@]+@[^s@]+.[^s@]+$/.test(value); 
        }
        function validatePhone(value) { 
            const clean = value.replace(/s/g, '');
            return /^[+]?[1-9][d]{9,15}$/.test(clean); 
        }

        // Real-time validation
        Object.keys(inputs).forEach(key => {
            inputs[key].addEventListener('input', function() {
                const value = this.value;
                let isValid = false;
                
                switch(key) {
                    case 'name': isValid = validateName(value); break;
                    case 'address': isValid = validateAddress(value); break;
                    case 'email': isValid = validateEmail(value); break;
                    case 'phone': isValid = validatePhone(value); break;
                }
                
                if (isValid) {
                    this.classList.remove('is-invalid');
                    errors[key].style.display = 'none';
                } else if (this.value) {
                    this.classList.add('is-invalid');
                    errors[key].style.display = 'block';
                    errors[key].textContent = getErrorMessage(key);
                }
            });
        });

        function getErrorMessage(field) {
            return {
                name: 'Name must be at least 2 characters',
                address: 'Address must be at least 5 characters',
                email: 'Enter valid email address',
                phone: 'Enter valid phone number (10+ digits)'
            }[field];
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            let isValid = true;

            Object.keys(inputs).forEach(key => {
                const value = inputs[key].value;
                let valid = false;
                
                switch(key) {
                    case 'name': valid = validateName(value); break;
                    case 'address': valid = validateAddress(value); break;
                    case 'email': valid = validateEmail(value); break;
                    case 'phone': valid = validatePhone(value); break;
                }
                
                if (!valid) {
                    isValid = false;
                    inputs[key].classList.add('is-invalid');
                    errors[key].style.display = 'block';
                    errors[key].textContent = getErrorMessage(key);
                }
            });

            if (isValid) {
                const data = Object.fromEntries(Object.entries(inputs).map(([k,v]) => [k, v.value.trim()]));
                showMessage(`✅ Customer registered successfully!<br><strong>${data.name}</strong><br>📧 ${data.email}<br>📱 ${data.phone}`, 'success');
                form.reset();
                clearErrors();
            } else {
                showMessage('❌ Please fix all errors before submitting.', 'danger');
            }
        });

        cancelBtn.addEventListener('click', function() {
            form.reset();
            clearErrors();
            messageAlert.style.display = 'none';
        });

        function clearErrors() {
            Object.values(inputs).forEach(input => input.classList.remove('is-invalid'));
            Object.values(errors).forEach(error => error.style.display = 'none');
        }

        function showMessage(text, type) {
            messageAlert.innerHTML = text;
            messageAlert.className = `alert alert-${type} mt-4`;
            messageAlert.style.display = 'block';
        }
    </script>
</body>
</html>