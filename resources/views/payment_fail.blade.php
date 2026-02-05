<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #fceabb 0%, #f8b500 100%);
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
            color: #d32f2f;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .fail-icon {
            color: #d32f2f;
            font-size: 60px;
            margin: 20px 0;
        }

        .status-message {
            margin: 20px 0;
            font-size: 18px;
            color: #555;
        }

        .return-btn {
            background: #d32f2f;
            color: white;
            border: none;
            padding: 12px 25px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 500;
            margin-top: 15px;
            text-decoration: none;
            display: inline-block;
        }

        .return-btn:hover {
            background: #b71c1c;
            transform: translateY(-2px);
        }

        .return-btn:active {
            transform: translateY(0);
        }
    </style>
</head>
<body>
<div class="payment-container">
    <div class="fail-icon">✗</div>
    <h1>Payment Failed</h1>
    <div class="status-message">Unfortunately, your transaction could not be processed.</div>
    <div class="status-message">Please try again or use a different payment method.</div>
    <div class="details">
        <div class="detail-row">
            <span class="detail-label">Reason:</span>
            <span class="detail-value">{{ $data->Auth->Description }}</span>
        </div>
    </div>

    <a href="/" class="return-btn">Return to Homepage</a>
</div>
</body>
</html>