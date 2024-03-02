<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/style.css">

    <title>No Name Devs - Login</title>
</head>

<body>
    <nav class="navbar bg-body-secondary navbar-expand-lg ">
        <div class="d-flex justify-content-between align-items-center w-100 px-2">
            <div>
                <a class="navbar-brand" href="../index.php">No Name Devs</a>
            </div>
            <div>
                <button class="navbar-toggler" type="button"
                    data-bs-target="#navbarSupportedContent"  data-bs-toggle="collapse" aria-controls="navbarSupportedContent"
                    aria-label="Toggle navigation" aria-expanded="false" >
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-lg-0 mb-2 ">

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
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
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
                                        echo '<li><a class="dropdown-item" href="../pages/signup.php">Register</a></li>';
                                    }
                                    ?>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <?php
    require_once '../controller/userController.php';
    if (isset($_SESSION['registerSucess']) && $_SESSION['registerSucess']) {
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                var toast = document.getElementById("registrationToast");
                var toastBody = toast.querySelector(".toast-body");
                toastBody.textContent = "Rregisteration successful! Please try to log in.";

                toast.classList.add("show");

                setTimeout(function() {
                    toast.classList.remove("show");
                }, 3000); 
            });

            function showToast(message) {
                
            }
          </script>';
    }
    unset($_SESSION['registerSucess']);

    $user = new User();
    $user->checkUserAuth();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $userData = $user->login($_POST);

        if ($userData) {
            header('Location: shop.php');
        }
    }
    ?>
    <main>
        <div class="container">
            <div class="content">
                <div id="registrationToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-body">
                    </div>
                </div>
                <div class="auth-content">
                    <div class="auth-form">
                        <h2 class="text-center">Login</h2>
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" name="email" id="email" class="form-control"
                                    placeholder="Enter your Email">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="text" name="password" id="password" class="form-control"
                                    placeholder="Enter your password">
                            </div>
                            <div class="mb-3 text-center">
                                <button type="submit" class="btn btn-success">
                                    Login
                                </button>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col text-center">
                                <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>