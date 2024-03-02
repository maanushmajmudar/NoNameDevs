<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>NoNameDevs - Shop</title>
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
            <h1>Shop</h1>
        </section>
        <form method="get" class="text-center">
            <div class="pt-5 pb-3">
                <button type="submit" class="btn btn-warning text-white " name="sort" value="highToLow">Sort by Price
                    (High to
                    Low)</button>
                <button type="submit" class="btn btn-warning text-white " name="sort" value="lowToHigh">Sort by Price
                    (Low to
                    High)</button>
            </div>
        </form>

        <div class="container">
            <div>
                <h2 class="text-center mb-5">Check out our latest products</h2>


                <div class=" text-center m-4">
                    <a href="../pages/cart.php" class="btn btn-info">Proceed to Cart</a>
                </div>

            </div>
            <?php
            require_once("../controller/shopeController.php");
            $shopObj = new shope();
            $sortOrder = isset($_GET['sort']) ? $_GET['sort'] : '';

            $laptops = $shopObj->getProductList($sortOrder);
            ?>
            <div class="d-flex justify-content-between flex-wrap">
                <?php foreach ($laptops as $laptop) : ?>
                    <div class="card-wrpper">
                        <div class="card ">
                            <a href="../pages/product-details.php?id=<?= $laptop['id'] ?>">
                                <img height="200px" width="100%" style="object-fit:contain" src="../assets/images/<?= $laptop['image'] ?>" class="p-2 card-img-top" alt="<?= $laptop['brand'] ?>">
                            </a>
                            <div class="card-body ">
                                <h5 class="card-title">
                                    <?= htmlspecialchars(strip_tags($laptop['brand'])) ?>
                                </h5>
                                <div class="d-flex justify-content-between">
                                    <p class="card-text">$
                                        <?= htmlspecialchars(strip_tags($laptop['price'])) ?>
                                    </p>

                                    <p class="card-text mb-1">
                                        <?= htmlspecialchars(strip_tags($laptop['year'])) ?>
                                    </p>
                                </div>
                                <p class="card-text desc text-justify">
                                    <?= htmlspecialchars(strip_tags($laptop['model'])) ?>
                                </p>

                                <form method="post" action="../controller/cartController.php">
                                    <input type="hidden" name="laptopId" value="<?= $laptop['id'] ?>">
                                    <input type="hidden" name="laptopName" value="<?= $laptop['brand'] ?>">
                                    <input type="hidden" name="laptopPrice" value="<?= $laptop['price'] ?>">
                                    <input type="hidden" name="laptopModel" value="<?= $laptop['model'] ?>">
                                    <div class="input-group mb-3">
                                        <input type="number" name="quantity" class="form-control" value="1" min="1" max="<?= $laptop['qty'] ?>">
                                        <button type="submit" class="btn btn-outline-secondary">Add to
                                            Cart</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        </div>
        </div>

        <div class=" text-center m-4">
            <a href="../pages/cart.php" class="btn btn-info">Proceed to Cart</a>
        </div>

    </main>
    <footer>
        <div class="footer-wrapper p-3">
            All Rights Reserved by &copy;NoNameDevs
        </div>
    </footer>
</body>

</html>