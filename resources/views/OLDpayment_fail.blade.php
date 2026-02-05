<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>
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
            color: #4CAF50;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .success-icon {
            color: #4CAF50;
            font-size: 60px;
            margin: 20px 0;
        }

        .status-message {
            margin: 20px 0;
            font-size: 18px;
            color: #555;
        }

        .details {
            background: #f8f9fa;
            border-radius: 5px;
            padding: 15px;
            margin: 20px 0;
            text-align: left;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .detail-label {
            font-weight: 500;
            color: #666;
        }

        .detail-value {
            font-weight: 600;
            color: #333;
        }

        .return-btn {
            background: #4CAF50;
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
            background: #3e8e41;
            transform: translateY(-2px);
        }

        .return-btn:active {
            transform: translateY(0);
        }
    </style>
</head>
<body>
<div class="payment-container">
    <div class="success-icon">✓</div>
    <h1>Payment Successful</h1>
    <div class="status-message">Your transaction has been Failed. Try after sometime.</div>

    <a href="/" class="return-btn">Return to Homepage</a>
</div>
</body>
</html>
