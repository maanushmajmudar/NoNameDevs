<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <title>No Name Devs</title>
</head>
<script>

    fetch('http://worldtimeapi.org/api/timezone/America/New_York')
        .then(response => response.json())
        .then(data => {
       
            data = data.datetime.split('T');
            date = data[0].split('-');
            time = data[1].split(':');
            document.getElementById('time').innerHTML = date[1] + '-' + date[2] + '-' + date[0] + ' ' + time[0] + ':' + time[1] + ':' + time[2];

        })
        .catch(err => console.log(err));
</script>

<body>
    <main>
        <nav class="navbar bg-body-secondary navbar-expand-lg ">
            <div class="d-flex justify-content-between align-items-center w-100 px-2">
                <div>
                    <a class="navbar-brand" href="index.php">No Name Devs</a>
                </div>
                <div>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                            <li class="nav-item">
                                <a class="nav-link" href="pages/shop.php">Shop</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="pages/about.php">About Us</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="pages/contact.php">Contact Us</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="config/dbinit.php">Init DB</a>
                            </li>
                        </ul>
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    My Account
                                </a>
                                <ul class="dropdown-menu container">
                                    <li><a class="dropdown-item" href="pages/cart.php">Cart</a></li>
                                    <li><a class="dropdown-item" href="pages/checkout.php">Checkout</a></li>
                                    <?php
                                    if (isset($_COOKIE['user_id'])) {
                                        echo '<form method="post" action="controller/userController.php">';
                                        echo '<li><button type="submit" name="logout" style="border:0;background:none;padding:4px 16px;">Logout</button></li>';
                                        echo '</form>';
                                    } else {
                                        echo '<li><a class="dropdown-item" href="pages/login.php">Login</a></li>';
                                    }
                                    ?>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <section class="section">
            <h1>Welcome to No Name Devs</h1>
            <p>Current Time: <span id="time"></span></p>
        </section>
        <div class="container ">
            <div class="text-center mt-4 mb-4">
                <h2>Check out our latest products</h2>
                <a href="pages/shop.php"><button class="btn btn-success mt-3">Shop Now</button></a>
            </div>
            <div class=" text-center m-4 font-monospace">
                <p>
                    Welcome to No Name Devs, your premier destination for cutting-edge laptops and technology solutions.
                    At No Name Devs, we redefine the laptop shopping experience by offering a curated selection of
                    top-tier devices that blend innovation and affordability seamlessly. Discover a world of powerful
                    computing with our handpicked collection, where every laptop is a testament to performance, style,
                    and reliability. Join us on a journey of limitless possibilities, where No Name Devs becomes your
                    trusted partner in unlocking the full potential of your digital endeavors. Elevate your computing
                    experience with us, where quality meets innovation, and every purchase is a step towards a smarter,
                    more connected future.
                </p>
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