<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/style.css">

    <title>No Name Devs - DB Setup</title>
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
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <div class="container">
            <div class="content">
                <div class="auth-content">
                    <div class="auth-form">
                        <h2 class="text-center">Database Configuration</h2>
                        <hr>
                        <?php
                        define("INITIALIZING_DATABASE", 1);
                        require_once("db_conn.php");
                        $db = new dbConnect();
                        $connection = $db->dbConnect();

                        $sqlQurey = $connection->prepare("drop database if exists laptops");
                        $sqlQurey->execute();

                        $sql = "create database laptops";

                        $sqlQurey = $connection->prepare($sql);
                        $sqlQurey->execute();


                        $sql = "use laptops";
                        $sqlQurey = $connection->prepare($sql);
                        $sqlQurey->execute();
                        $sql = "CREATE TABLE IF NOT EXISTS `user` (
                                    `id` int NOT NULL AUTO_INCREMENT,
                                    `name` varchar(255) NOT NULL,
                                    `mobile` bigint NOT NULL,
                                    `email` varchar(255) NOT NULL,
                                    `password` varchar(255) NOT NULL,
                                    `address` varchar(211) NOT NULL,
                                    `city` varchar(255) NOT NULL,
                                    `pin` varchar(255) NOT NULL,
                                    `is_admin` boolean NOT NULL DEFAULT 0 COMMENT '0 for user, 1 for admin',
                                    PRIMARY KEY (`id`)
                                ) ";
                        $sqlQurey = $connection->prepare($sql);
                        $sqlQurey->execute();

                        $sql = "CREATE TABLE IF NOT EXISTS `cart` (
                                    `id` int NOT NULL AUTO_INCREMENT,
                                    `laptop_id` int NOT NULL,
                                    `user_id` int NOT NULL,
                                    `qty` int NOT NULL,
                                    PRIMARY KEY (`id`)
                                ) Engine=InnoDB auto_increment=2 default charset=utf8mb4";

                        $sqlQurey = $connection->prepare($sql);
                        $sqlQurey->execute();

                        $sql = "CREATE TABLE IF NOT EXISTS `orders` (
                                    `id` int NOT NULL AUTO_INCREMENT,
                                    `laptop_id` int NOT NULL,
                                    `user_id` int NOT NULL,
                                    `order_amount` float NOT NULL,
                                    `order_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                    `status` varchar(255) NOT NULL,
                                    PRIMARY KEY (`id`)
                                ) Engine=InnoDB auto_increment=1 default charset=utf8mb4";
                        $sqlQurey = $connection->prepare($sql);
                        $sqlQurey->execute();

                        $sql = "CREATE TABLE IF NOT EXISTS `laptops` (
                                    `id` int NOT NULL AUTO_INCREMENT,
                                    `brand` varchar(50)  NULL,
                                    `model` varchar(500)  NULL,
                                    `price` int  NULL,
                                    `qty` int  NULL,
                                    `year` int  NULL,
                                    `image` varchar(244)  NULL,
                                    PRIMARY KEY (`id`)
                                ) Engine=InnoDB auto_increment=10 default charset=utf8mb4";
                        echo "<h5 class='text-center'> Please  <a href='../index.php'>Proceed</a> after your database initialization</h5>";
                        $sqlQurey = $connection->prepare($sql);
                        $sqlQurey->execute();

                        $data = [
                            ['brand' => 'SGIN', 'model' => '12GB DDR4 512GB SSD, 15.6 Inch Laptops Computer with Intel Celeron N5095 Processor(Up to 2.9GHz), FHD 1920x1080, Mini HDMI, Webcam, USB 3.0, Bluetooth 4.2, 2.4/5.0G WiFi', 'price' => 800, 'qty' => 10, 'year' => 2022, 'image' => 'image1.jpg'],
                            ['brand' => 'Dell Precision', 'model' => 'Precision 7540 Laptop 15.6 - Intel Core i7 9th Gen - i7-9850H - Six Core 4.6Ghz - 512GB SSD - 32GB RAM - Nvidia Quadro T1000 - 1920x1080 FHD - Windows 10 Pro', 'price' => 1200, 'qty' => 8, 'year' => 2021, 'image' => 'image2.jpg'],
                            ['brand' => 'ALLDOCUBE', 'model' => 'GTBook 15 Laptop 15.6 Inch, 12GB RAM+256GB SSD, Windows 11 System Intel Celeron N5100 Quad-core Chip, FHD IPS 1920x1080 Display, Dual Microphone & Speaker, 2.4G+5G WiFi, 10000mAh Battery', 'price' => 1000, 'qty' => 5, 'year' => 2022, 'image' => 'image3.jpg'],
                            ['brand' => 'ASUS', 'model' => 'Laptop L510 Ultra Thin Laptop, 15.6” HD Display, Intel Celeron N4020 Processor, 4GB RAM, 64GB Storage, Windows 11 Home in S Mode, 1 Year Microsoft 365 Included, Star Black, L510MA-DS09-CA', 'price' => 1500, 'qty' => 12, 'year' => 2020, 'image' => 'image4.jpg'],
                            ['brand' => 'HP', 'model' => '15 inch Laptop, HD Display, Intel Processor N100, 4 GB RAM, 128 GB UFS, Intel UHD Graphics, Windows 11 Home in S Mode, 15-fd0000ca (2023)', 'price' => 900, 'qty' => 7, 'year' => 2023, 'image' => 'image5.jpg'],
                            ['brand' => 'Acer', 'model' => 'Aspire 1 Slim Laptop Intel Processor N4020 4GB RAM 128GB eMMC 15.6inch Full HD LED Windows 11 S Mode (1 yr Manufacturer Warranty)', 'price' => 1300, 'qty' => 9, 'year' => 2020, 'image' => 'image6.jpg'],
                            ['brand' => 'Lenovo', 'model' => 'ThinkPad L380 Business Laptop, 13.3inch FHD (1920x1080) Screen, Intel Celeron 7th Generation Processor 3965U 2.2GHz, 8GB RAM, 256GB SSD, Webcam, WiFi, BT, Windows 10 Pro', 'price' => 1100, 'qty' => 6, 'year' => 2022, 'image' => 'image7.jpg']
                        ];

                        $sqlQurey = $connection->prepare('INSERT INTO laptops (brand, model, price, qty, year, image) VALUES(:brand,:model, :price, :qty, :year, :image)');
                        foreach ($data as $key => $value) {
                            $sqlQurey->bindParam(':brand',  $value['brand'], PDO::PARAM_STR);
                            $sqlQurey->bindParam(':model',  $value['model'], PDO::PARAM_STR);
                            $sqlQurey->bindParam(':price',  $value['price'], PDO::PARAM_INT);
                            $sqlQurey->bindParam(':qty', $value['qty'], PDO::PARAM_INT);
                            $sqlQurey->bindParam(':year', $value['year'], PDO::PARAM_INT);
                            $sqlQurey->bindParam(':image', $value['image'], PDO::PARAM_STR);
                            $sqlQurey->execute();
                        }


                        $hashedPassword = password_hash('admin', PASSWORD_DEFAULT);
                        $sqlQuery =  $connection->prepare("INSERT INTO user (name, password,email,mobile,is_admin) VALUES (:name, :password,:email,:mobile,:is_admin)");
                        $data = [
                            'name' => 'Admin',
                            'mobile' => 1234567890,
                            'password' => $hashedPassword,
                            'email' => 'super.admin@admin.com',
                            'is_admin' => 1
                        ];
                        $sqlQuery->bindParam(':name',  $data['name'], PDO::PARAM_STR);
                        $sqlQuery->bindParam(':email',  $data['email'], PDO::PARAM_STR);
                        $sqlQuery->bindParam(':mobile',  $data['mobile'], PDO::PARAM_INT);
                        $sqlQuery->bindParam(':password', $data['password'], PDO::PARAM_STR);
                        $sqlQuery->bindParam(':is_admin', $data['is_admin'], PDO::PARAM_BOOL);
                        $sqlQuery->execute();

                        ?>

                        <form action="../index.php">
                            <div class="mb-3 text-center">
                                <input type="submit" class="btn btn-large btn-outline-primary" value="Initialize Database" />
                            </div>
                        </form>
                    </div>
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