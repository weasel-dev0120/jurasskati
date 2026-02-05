<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Processing</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: #333;
        }

        .payment-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 400px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .payment-container:hover {
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        h1 {
            color: #4a6baf;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .spinner {
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-radius: 50%;
            border-top: 4px solid #4a6baf;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
            display: none;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .submit-btn {
            background: #4a6baf;
            color: white;
            border: none;
            padding: 12px 25px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 500;
            margin-top: 15px;
        }

        .submit-btn:hover {
            background: #3a5a9f;
            transform: translateY(-2px);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .redirect-info {
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }

        .destination {
            font-weight: bold;
            color: #4a6baf;
        }

        .status-message {
            margin-top: 15px;
            font-weight: 500;
            color: #4a6baf;
            min-height: 24px;
        }
    </style>
</head>
<body>
<div class="payment-container">
    <h1>Payment Processing</h1>
    <div class="status-message" id="statusMessage">Please wait while we process your request...</div>
    <div class="spinner" id="spinner"></div>

    <form id="paymentForm" action="<?php echo $action; ?>" method="post">
        <?php foreach ($fields as $key => $value) { ?>
        <input type="hidden" name="<?php echo $key; ?>" value="<?php echo $value; ?>" />
        <?php } ?>
        <input type="submit" class="submit-btn" id="submitBtn" name="SUBMIT" value="Submit Payment" />
    </form>

    <div class="redirect-info">
     </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('paymentForm');
        const spinner = document.getElementById('spinner');
        const statusMessage = document.getElementById('statusMessage');
        const submitBtn = document.getElementById('submitBtn');

        // Show spinner and update message immediately
        spinner.style.display = 'block';
        submitBtn.style.display = 'none';
        statusMessage.textContent = 'Processing your payment...';

        // Auto-submit the form after a short delay (1 second)
        setTimeout(function() {
            statusMessage.textContent = 'Redirecting to payment gateway...';
            form.submit();
        }, 1000);
    });
</script>
</body>
</html>