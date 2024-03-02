<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>NoNameDevs - Cart</title>
</head>

<body>
    <main>
        <nav class="navbar bg-body-secondary navbar-expand-lg ">
            <div class="d-flex justify-content-between align-items-center w-100 px-2">
                <div>
                    <a class="navbar-brand" href="../index.php">No Name Devs</a>
                </div>
                <div>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                            <li class="nav-item">
                                <a class="nav-link" href="../pages/shop.php">Shop</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../pages/about.php">About Us</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../pages/contact.php">Contact Us</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../config/dbinit.php">Init DB</a>
                            </li>
                        </ul>
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    My Account
                                </a>
                                <ul class="dropdown-menu container">
                                    <li><a class="dropdown-item" href="../pages/cart.php">Cart</a></li>
                                    <li><a class="dropdown-item" href="../pages/checkout.php">Checkout</a></li>
                                    <?php
                                    if (isset($_COOKIE['user_id'])) {
                                        echo '<form method="post" action="../controller/userController.php">';
                                        echo '<li><button type="submit" name="logout" style="border:0;background:none;padding:4px 16px;">Logout</button></li>';
                                        echo '</form>';
                                    } else {
                                        echo '<li><a class="dropdown-item" href="../pages/login.php">Login</a></li>';
                                    }
                                    ?>
                                    <?php
                                    if (isset($_COOKIE['user_id'])) {
                                        if ($_COOKIE['is_admin']) {
                                            echo '<li><a class="dropdown-item" href="../pages/admin.php">Admin</a></li>';
                                        }
                                    }
                                    ?>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <section class="section text-white">
            <h1>Cart</h1>
        </section>
        <div class="container p-3">
            <div class="content">

                <div class="shop-content">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Product Name</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Price</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <?php
                        require_once '../controller/cartController.php';
                        $cartObj = new cartController();
                        $cartItems = $cartObj->getCartItems();

                        foreach ($cartItems as $item) {
                            echo '<form method="post" action="../controller/cartController.php">';
                            echo '  <tbody>';
                            echo '      <tr>';
                            echo '          <td>' . (isset($item['name']) ? htmlspecialchars(strip_tags($item['name'])) : (isset($item['brand']) ? htmlspecialchars(strip_tags($item['brand'])) : '')) . '</td>';
                            echo '          <td>' . (isset($item['quantity']) ? htmlspecialchars(strip_tags($item['quantity'])) : (isset($item['qty']) ? htmlspecialchars(strip_tags($item['qty'])) : '')) . '</td>';
                            echo '          <td>' . $item['price'] * (isset($item['quantity']) ? $item['quantity'] : (isset($item['qty']) ? $item['qty'] : '')) . '</td>';
                            echo '          <input type="hidden" name="id" value="' . $item['id'] . '">';
                            echo '          <td><button class="btn btn-danger" name="deleteItemFromCart">Remove</button></td>';
                            echo '      </tr>';
                            echo '  </tbody>';
                            echo '</form>';
                        }
                        ?>
                    </table>
                    <div class="row mt-3 container text-center mt-4 mb-4">
                        <div class="col mt-4 mb-4"><br>
                            <?php

                            if (!empty($cartItems)) {
                                echo '<a href="checkout.php"><button class="btn btn-primary m-2">Proceed to Checkout</button></a>';
                                echo '<a href="shop.php"><button class="btn btn-primary ml-3">Continue Shopping</button></a>';
                            } else {
                                echo '<button class="btn btn-primary m-2    " disabled>Proceed to Checkout</button>';
                                echo '<a href="shop.php"><button class="btn btn-primary ml-3">Continue Shopping</button></a>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <div class="footer-wrapper p-3">
            All Rights Reserved by &copy;NoNameDevs
        </div>
    </footer>
</body>

</html>