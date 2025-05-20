<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Sample product list with images and descriptions
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




// Handle add to cart securely
$message = '';
if (isset($_GET['add'])) {
    $product_id = filter_input(INPUT_GET, 'add', FILTER_VALIDATE_INT);
    if ($product_id !== false && isset($products[$product_id])) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]++;
        } else {
            $_SESSION['cart'][$product_id] = 1;
        }
        header("Location: dashboard.php");
        exit();
    } else {
        $message = "Invalid product ID.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Dashboard - Welcome</title>
    <style>
        /* Reset some default */
        * {
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #eef2f7;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }
        .navbar {
            background-color: #007bff;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgb(0 0 0 / 0.1);
        }
        .navbar h1 {
            margin: 0;
            font-size: 24px;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            font-weight: 600;
            padding: 10px 20px;
            background-color: #dc3545;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .navbar a:hover {
            background-color: #c82333;
        }
        .container {
            max-width: 1100px;
            margin: 30px auto;
            padding: 0 20px 50px;
        }
        h2 {
            color: #333;
            margin-bottom: 10px;
        }
        .message {
            color: #d9534f;
            margin: 15px 0;
            font-weight: 600;
            font-size: 1.1em;
        }
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit,minmax(250px,1fr));
            gap: 20px;
        }
        .product-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgb(0 0 0 / 0.1);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: transform 0.2s ease;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgb(0 0 0 / 0.15);
        }
        .product-image {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }
        .product-info {
            padding: 15px 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .product-name {
            font-size: 18px;
            font-weight: 700;
            margin: 0 0 8px;
            color: #222;
        }
        .product-desc {
            font-size: 14px;
            color: #666;
            margin-bottom: 12px;
            flex-grow: 1;
        }
        .product-price {
            font-weight: 700;
            font-size: 16px;
            color: #007bff;
            margin-bottom: 15px;
        }
        .btn {
            padding: 10px 18px;
            background-color: #28a745;
            color: white;
            text-align: center;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        .btn:hover {
            background-color: #218838;
        }
        .cart-link {
            display: inline-block;
            margin-top: 30px;
            font-weight: 700;
            font-size: 18px;
            color: #007bff;
            text-decoration: none;
            border: 2px solid #007bff;
            padding: 10px 25px;
            border-radius: 8px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .cart-link:hover {
            background-color: #007bff;
            color: white;
        }
        @media (max-width: 600px) {
            .product-image {
                height: 140px;
            }
            .navbar h1 {
                font-size: 20px;
            }
            .btn {
                font-size: 14px;
                padding: 8px 14px;
            }
            .cart-link {
                font-size: 16px;
                padding: 8px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>Dashboard</h1>
        <a href="logout.php">Logout</a>
    </div>

    <div class="container">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>

        <?php if ($message): ?>
            <p class="message"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <h3>Available Products</h3>
        <div class="products-grid">
           <?php foreach ($products as $id => $product): ?>
    <div class="product">
        <img src="images/<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" style="max-width: 150px; border-radius: 8px;">
        <strong><?php echo $product['name']; ?></strong><br>
        Price: $<?php echo number_format($product['price'], 2); ?><br><br>
        <a href="dashboard.php?add=<?php echo $id; ?>" class="btn">Add to Cart</a>
    </div>
<?php endforeach; ?>

        </div>

        <a href="cart.php" class="cart-link">View Cart</a>
    </div>
</body>
</html>
