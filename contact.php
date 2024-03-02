<?php
$validationerrors = [];
$confirmation = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    if (empty($_POST['name'])) {
        $validationerrors['name'] = 'Name is mandatory';
    }

    
    if (empty($_POST['email'])) {
        $validationerrors['email'] = 'Email is mandatory';
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $validationerrors['email'] = 'Invalid email format';
    }


    if (empty($_POST['message'])) {
        $validationerrors['message'] = 'Message is mandatory';
    }
    if (empty($validationerrors)) {
        $confirmation = 'Thank you! We will contact you soon.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/style.css">

    <title>No Name Devs - Contact Us</title>
</head>

<body>
    <header>
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
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <section class="section text-white">
            <h1>Contact us</h1>
        </section>

        <div class="container">
            <div class="content p-3">
                <?php if (!empty($confirmation)) : ?>
                    <div class="alert alert-success text-center" role="alert">
                        <?= $confirmation ?>
                    </div>
                <?php else : ?>
                    <form action="contact.php" method="post">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter your Name" >
                            <?php if (!empty($validationerrors['name'])) : ?>
                                <div class="text-danger"><?= $validationerrors['name'] ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter your Email" >
                            <?php if (!empty($validationerrors['email'])) : ?>
                                <div class="text-danger"><?= $validationerrors['email'] ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea name="message" id="message" class="form-control" placeholder="Enter your Message" rows="5" ></textarea>
                            <?php if (!empty($validationerrors['message'])) : ?>
                                <div class="text-danger"><?= $validationerrors['message'] ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3 text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer-wrapper p-3">
            All Rights Reserved by &copy;NoNameDevs
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
