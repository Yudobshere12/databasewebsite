<?php
session_start();
// Clear the cart after successful payment
$_SESSION['cart'] = [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Payment Successful</title>
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(135deg, #e0f7fa, #ffffff);
        margin: 0;
        padding: 0;
        display: flex;
        height: 100vh;
        align-items: center;
        justify-content: center;
    }

    .success-box {
        background: #ffffff;
        border: 2px solid #28a745;
        border-radius: 12px;
        padding: 40px 35px;
        text-align: center;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
        animation: fadeIn 1s ease-in-out;
        max-width: 420px;
        margin: 0 auto;
    }

    .success-icon {
        font-size: 70px;
        color: #28a745;
        margin-bottom: 20px;
    }

    h2 {
        color: #28a745;
        font-size: 26px;
        margin-bottom: 12px;
    }

    p {
        color: #555;
        font-size: 16px;
        line-height: 1.6;
        margin-bottom: 30px;
    }

    .btn-container {
        display: flex;
        justify-content: center;
        gap: 15px;
        flex-wrap: wrap;
    }

    .btn {
        padding: 12px 28px;
        background-color: #007bff;
        color: white;
        text-decoration: none;
        font-weight: 600;
        border-radius: 8px;
        display: inline-block;
        transition: background-color 0.3s ease;
        border: none;
        cursor: pointer;
        min-width: 140px;
        text-align: center;
        box-shadow: 0 4px 8px rgba(0,123,255,0.3);
        user-select: none;
    }

    .btn:hover, .btn:focus {
        background-color: #0056b3;
        box-shadow: 0 6px 14px rgba(0,86,179,0.6);
        outline: none;
    }

    .btn-secondary {
        background-color: #6c757d;
        box-shadow: 0 4px 8px rgba(108,117,125,0.3);
    }

    .btn-secondary:hover, .btn-secondary:focus {
        background-color: #5a6268;
        box-shadow: 0 6px 14px rgba(90,98,104,0.6);
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }

    @media (max-width: 420px) {
        .success-icon { font-size: 50px; }
        h2 { font-size: 22px; }
        p { font-size: 14px; }
        .btn-container {
            flex-direction: column;
            gap: 12px;
        }
        .btn {
            min-width: auto;
            width: 100%;
        }
    }
</style>
</head>
<body>

<div class="success-box">
    <div class="success-icon">✅</div>
    <h2>Payment Successful!</h2>
    <p>Thank you for your purchase. Your order has been processed successfully.</p>

    <div class="btn-container">
        <a href="dashboard.php" class="btn">Back to Dashboard</a>
        <a href="products.php" class="btn btn-secondary">Continue Shopping</a>
        <a href="orders.php" class="btn btn-secondary">View Orders</a>
    </div>
</div>

</body>
</html>
