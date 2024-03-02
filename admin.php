<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/style.css">

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
    </header>
    <main>
        <section class="section text-white">
            <h1>Admin Control</h1>
        </section>
        <?php
        require_once("../controller/userController.php");

        $userObj = new User();
        $userArr = $userObj->getUser();
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['deleteUser']) {

            $res = $user->deleteUser($_POST['id']);
        }
        ?>
        <div class="container mt-5">
            <h2 class="text-center mt-4 mb-4">User Data</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>

                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($userArr as $key => $value) {
                        echo '<tr>';
                        echo ' <td>' . $value['name'] . '</td> ';
                        echo ' <td>' . $value['email'] . '</td>';
                        echo ' <td>' . $value['mobile'] . '</td>';
                        echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '">';
                        echo '          <input type="hidden" name="id" value="' . $value['id'] . '">';
                        echo '          <td><button class="btn btn-danger" name="deleteUser">Delete</button></td>';
                        echo '</form>';
                        echo '<tr>';
                    }
                    ?>

                </tbody>
            </table>
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