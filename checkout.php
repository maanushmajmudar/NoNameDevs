<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>NoNameDevs - Checkout</title>
</head>

<body>
    <?php
    require_once '../controller/checkOutController.php';
    $obj = new checkOutController();
    $obj->checkUserAuth();
    ?>
    <main>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="../index.php">No Name Devs</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class=" navbar-collapse collapse " id="navbarSupportedContent">
                    <ul class="navbar-nav mb-2 me-auto  mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" href="../index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="../pages/shop.php">Shop</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../pages/about.php">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../pages/contact.php">Contact Us</a>
                        </li>
                    </ul>
                    <div class="d-flex">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item dropdown container">
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
        <section class="sec-main2">
            <h1>Shop</h1>
        </section>
        <div class="container">
            <div class="content">
                <h2 class="text-center">Checkout</h2>
                <hr>
                <div class="shop-content">
                    <?php
                    require_once '../controller/cartController.php';
                    $cartObj = new cartController();
                    $cartItems = $cartObj->getCartItems();

                    if (session_status() == PHP_SESSION_NONE) {
                        session_start();
                    }

                    if (isset($_SESSION['flash_messages']) && !empty($_SESSION['flash_messages'])) {
                        $errors = $_SESSION['flash_messages'];
                        echo '<div class="error-message">';
                        foreach ($errors as $error) {
                            echo $error . '<br>';
                        }
                        echo '</div>';
                        unset($_SESSION['flash_messages']);
                    }

                    ?>
                    <form action="../controller/checkOutController.php" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="firstName" class="form-label">First Name:</label>
                                        <input type="text" class="form-control" id="firstName" name="firstName" />
                                    </div>
                                    <div class="col-md-6">
                                        <label for="lastName" class="form-label">Last Name:</label>
                                        <input type="text" class="form-control" id="lastName" name="lastName" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="address" class="form-label">Address:</label>
                                        <input type="text" class="form-control" id="address" name="address" />
                                    </div>
                                    <div class="col-md-6">
                                        <label for="city" class="form-label">City:</label>
                                        <input type="text" class="form-control" id="city" name="city" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="state" class="form-label">State:</label>
                                        <input type="text" class="form-control" id="state" name="state" />
                                    </div>
                                    <div class="col-md-6">
                                        <label for="zip" class="form-label">Zip:</label>
                                        <input type="text" class="form-control" id="zip" name="zip" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <h2>Order Summary</h2>
                                    <?php if (!empty($cartItems)) { ?>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Product Name</th>
                                                    <th scope="col">Quantity</th>
                                                    <th scope="col">Price</th>
                                                </tr>
                                            </thead>
                                            <?php
                                            $total = 0;
                                            foreach ($cartItems as $item) {
                                                echo '<tbody>';
                                                echo '<tr>';
                                                // echo '<td>' . (isset($item['name']) ? $item['name'] : (isset($item['brand']) ? $item['brand'] : '')) . '</td>';
                                                // echo '<td>' . (isset($item['quantity']) ? $item['quantity'] : (isset($item['qty']) ? $item['qty'] : '')) . '</td>';
                                                echo '          <td>' . (isset($item['name']) ? htmlspecialchars(strip_tags($item['name'])) : (isset($item['brand']) ? htmlspecialchars(strip_tags($item['brand'])) : '')) . '</td>';
                                                echo '          <td>' . (isset($item['quantity']) ? htmlspecialchars(strip_tags($item['quantity'])) : (isset($item['qty']) ? htmlspecialchars(strip_tags($item['qty'])) : '')) . '</td>';
                                                echo '<td>' . $item['price'] * (isset($item['quantity']) ? $item['quantity'] : (isset($item['qty']) ? $item['qty'] : '')) . '</td>';
                                                echo '</tr>';
                                                echo '</tbody>';
                                                $total += $item['price'] * (isset($item['quantity']) ? $item['quantity'] : (isset($item['qty']) ? $item['qty'] : ''));
                                            }
                                            ?>
                                            <input type="hidden" name="totale" value="<?= $total ?>">
                                        </table>
                                        <div class="col-md-6">
                                            <p>
                                                <strong>Total:</strong> <?php echo '$' . $total; ?>
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="submit" name="placeOrder" class="btn btn-primary">Place Order</button>
                                        </div>
                                    <?php } else { ?>
                                        <div class="col-md-12 text-center">
                                            <p>No items in the cart. Add items to proceed.</p>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </form>
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