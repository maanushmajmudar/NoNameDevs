<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>NoNameDevs - Product Details</title>
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
            <h1>Product Details</h1>
        </section>
        <div class="container p-3">
            <div class="content">
                <div class="container">
                    <?php
                    $productId = $_GET['id'];

                    if (empty($productId)) {
                        echo "<p>Product ID not found</p>";
                        echo "<a href='shop.php'>Go back</a>";
                        exit();
                    } else {


                        require_once("../controller/shopeController.php");
                        $obj = new shope();
                        $product = $obj->getProductDetails($productId);

                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-6">';
                        echo '      <img height="500px" width="500px" src="../assets/images/' . $product["image"] . '" class="img-fluid img" alt=" ' . $product['brand'] . '" />';
                        echo '  </div>';
                        echo '  <div class="col-md-6"> ';
                        echo '      <h2> ' . htmlspecialchars(strip_tags($product['brand'])) . '</h2>';
                        echo '      <p>' . htmlspecialchars(strip_tags($product['model'])) . '</p>';
                        echo '      <p>' . htmlspecialchars(strip_tags($product['price'])) . '</p>';
                        echo '      <p>' . htmlspecialchars(strip_tags($product['qty']))  . '</p>';
                        echo '      <p>' . htmlspecialchars(strip_tags($product['year']))  . '</p>';

                        echo '      <form action="../controller/cartController.php" method="post">';
                        echo '          <div class="row mb-3">';
                        echo '              <div class="col-md-6">';
                        echo '                  <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" />';
                        echo '              </div>';
                        echo '              <div class="col-md-6">';
                        echo '                   <input type="hidden" name="laptopId" value="' . $product['id'] . '"/ >';
                        echo '                  <input type="hidden" name="laptopName" value="' . $product['brand'] . '" />';
                        echo '                  <input type="hidden" name="laptopPrice" value="' . $product['price'] . '" />';
                        echo '                  <input type="hidden" name="laptopModel" value="' . $product['year'] . '" />';

                        echo '                  <button type="submit" class="btn btn-primary">Add to Cart</button>';
                        echo '              </div>';
                        echo '          </div>';
                        echo '     </form>';
                        echo '<div class="row mt-3">';
                        echo '  <div class="col">';
                        echo '      <a href="checkout.php"><button class="btn btn-outline-success">Go to Checkout</button></a>';
                        echo '  </div>';
                        echo '</div>';

                        echo '</div>';
                        echo '</div>';
                    }
                    ?>

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