<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$products = [
    1 => ['name' => 'Running Shoes', 'price' => 59.99, 'image' => 'running-shoes.webp'],
    2 => ['name' => 'Fitness Watch', 'price' => 129.99, 'image' => 'fitness-watch.webp'],
    3 => ['name' => 'Sports T-Shirt', 'price' => 19.99, 'image' => 'sportstshirt.jpg'],
    4 => ['name' => 'Water Bottle', 'price' => 9.99, 'image' => 'bottle.jpg'],
    5 => ['name' => 'Gym Bag', 'price' => 39.99, 'image' => 'gymbag.jpg'],
    6 => ['name' => 'Yoga Mat', 'price' => 24.99, 'image' => 'yogamat.jpg'],
    7 => ['name' => 'Bluetooth Earbuds', 'price' => 49.99, 'image' => 'earbuds.jpg'],
    8 => ['name' => 'Smart Scale', 'price' => 79.99, 'image' => 'smartscale.jpg'],
    9 => ['name' => 'Protein Powder', 'price' => 44.99, 'image' => 'proteinpowder.jpg'],
    10 => ['name' => 'Adjustable Dumbbells', 'price' => 199.99, 'image' => 'dumbbells.jpg'],
    11 => ['name' => 'Compression Socks', 'price' => 14.99, 'image' => 'socks.jpg'],
    12 => ['name' => 'Jump Rope', 'price' => 12.99, 'image' => 'jumprope.jpg'],
    13 => ['name' => 'Workout Hoodie', 'price' => 34.99, 'image' => 'hoodie.jpg'],
    14 => ['name' => 'Foam Roller', 'price' => 17.99, 'image' => 'foamroller.jpg'],
    15 => ['name' => 'Cycling Gloves', 'price' => 15.99, 'image' => 'gloves.jpg'],
    16 => ['name' => 'Pre-Workout Drink', 'price' => 29.99, 'image' => 'preworkout.jpg'],
];

$message = '';

if (isset($_POST['update_quantity'])) {
    $product_id = (int) $_POST['product_id'];
    $quantity = (int) $_POST['quantity'];
    $user_id = $_SESSION['user_id'];

    if ($quantity > 0) {
        $stmt = $conn->prepare("UPDATE cart_items SET quantity = ? WHERE user_id = ? AND product_id = ?");
        $stmt->bind_param("iii", $quantity, $user_id, $product_id);
        $stmt->execute();
    } else {
        // Delete if quantity is zero or less
        $stmt = $conn->prepare("DELETE FROM cart_items WHERE user_id = ? AND product_id = ?");
        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();
    }

    header("Location: cart.php");
    exit();
}


$cart = $_SESSION['cart'] ?? [];
$total = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Your Cart</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f9fafb; padding: 30px; }
        .container { max-width: 700px; margin: auto; background: white; padding: 25px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);}
        h2 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { padding: 12px; border-bottom: 1px solid #ddd; text-align: center; }
        th { background: #007bff; color: white; }
        .btn {
            background-color: #28a745; color: white; border: none; padding: 10px 18px; border-radius: 5px; cursor: pointer;
            font-weight: bold; margin-right: 10px;
        }
        .btn-clear { background-color: #dc3545; }
        .btn-remove { background-color: #ff6600; }
        .btn-remove:hover { background-color: #e65c00; }
        .message {
            background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 15px; border-radius: 6px;
            margin-bottom: 20px;
        }
        a { text-decoration: none; color: #007bff; font-weight: 600;}
        form.inline { display: inline; }
    </style>
</head>
<body>
    <div class="container">
        <h2><?php echo htmlspecialchars($_SESSION['username']); ?>'s Shopping Cart</h2>
        <a href="dashboard.php">&larr; Back to Dashboard</a>

        <?php if ($message): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>

        <?php if (empty($cart)): ?>
            <p>Your cart is empty.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Product</th><th>Quantity</th><th>Price</th><th>Subtotal</th><th>Remove</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($cart as $prod_id => $qty):
                        $price = $products[$prod_id]['price'];
                        $subtotal = $price * $qty;
                        $total += $subtotal;
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($products[$prod_id]['name']); ?></td>
                        <td><?php echo $qty; ?></td>
                        <td>$<?php echo number_format($price, 2); ?></td>
                        <td>$<?php echo number_format($subtotal, 2); ?></td>
                        <td>
                            <form method="POST" class="inline">
                                <input type="hidden" name="action" value="remove" />
                                <input type="hidden" name="product_id" value="<?php echo $prod_id; ?>" />
                                <button class="btn btn-remove" type="submit">Remove</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" style="text-align:right;">Total:</th>
                        <th>$<?php echo number_format($total, 2); ?></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>

            <form method="POST" style="display:inline;">
                <input type="hidden" name="action" value="pay" />
                <button class="btn" type="submit">Pay Now</button>
            </form>
            <form method="POST" style="display:inline;">
                <input type="hidden" name="action" value="clear" />
                <button class="btn btn-clear" type="submit">Clear Cart</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
