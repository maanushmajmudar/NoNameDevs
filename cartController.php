<?php
require_once("../config/db_conn.php");

require_once("SessionController.php");

$cartController = new cartController();
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['laptopId']) && isset($_POST['quantity'])) {
    $cartController->addLaptopToCart($_POST['laptopId'], $_POST['quantity'], $_POST['laptopName'], $_POST['laptopPrice']);
}
if (isset($_POST['deleteItemFromCart'])) {
    $cartController->removeItemFromCart($_POST['id']);
}

class cartController
{
    private $db, $conn, $response, $session;

    public function __construct()
    {
        $this->db = new dbConnect();
        $this->conn = $this->db->dbConnect();
        $this->session = new SessionController();
    }
    public function addLaptopToCart($laptopId, $quantity, $laptopName, $laptopPrice)
    {
        $this->session->startSession();
        if (isset($_COOKIE['user_id']))
            $userId = $_COOKIE['user_id'];
        if (isset($_SESSION['cart'][$laptopId])) {

            if ($userId) {
                $this->updateItemToCartWithDB($laptopId, $quantity);
            }
            $_SESSION['cart'][$laptopId]['quantity'] += $quantity;
            header('Location: ../pages/shop.php');
            exit;
        } else {
            if ($userId) {
                $this->addItemToCartWithDB($laptopId, $quantity);
            }
            $_SESSION['cart'][$laptopId] = [
                'id' => $laptopId,
                'quantity' => $quantity,
                'name' => $laptopName,
                'price' => $laptopPrice,
            ];
            header('Location: ../pages/shop.php');
            exit;
        }
    }

    public function addItemToCartWithDB($laptopId, $quantity)
    {
        if (isset($_COOKIE['user_id']))
            $userId = $_COOKIE['user_id'];
        $sqlQuery =  $this->conn->prepare("INSERT INTO cart (laptop_id, user_id,qty) VALUES (:laptop_id, :user_id,:qty)");

        $sqlQuery->bindParam(':laptop_id', $laptopId, PDO::PARAM_INT);
        $sqlQuery->bindParam(':user_id',  $userId, PDO::PARAM_INT);
        $sqlQuery->bindParam(':qty',  $quantity, PDO::PARAM_INT);
        $sqlQuery->execute();
    }

    public function updateItemToCartWithDB($laptopId, $quantity)
    {
        if (isset($_COOKIE['user_id']))
            $userId = $_COOKIE['user_id'];
        $stmt = $this->conn->prepare("SELECT * FROM cart WHERE user_id = :userId AND laptop_id = :laptopId");
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':laptopId', $laptopId, PDO::PARAM_INT);
        $stmt->execute();
        $userCartData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($userCartData) {
            $quantity += $userCartData['qty'];

            $sqlQuery = $this->conn->prepare("UPDATE cart SET qty = :newQuantity WHERE user_id = :userId AND laptop_id = :laptopId");
            $sqlQuery->bindParam(':newQuantity', $quantity, PDO::PARAM_INT);
            $sqlQuery->bindParam(':userId', $userId, PDO::PARAM_INT);
            $sqlQuery->bindParam(':laptopId', $laptopId, PDO::PARAM_INT);
            $sqlQuery->execute();
        }
    }
    public function getCartItems()
    {
        $this->session->startSession();
        $userId = '';
        if (isset($_COOKIE['user_id']))
            $userId = $_COOKIE['user_id'];
        if ($userId) {
            return $this->retriveItemCartFromDB($userId);
        }
        if (isset($_SESSION['cart'])) {
            return $_SESSION['cart'];
        } else {
            return [];
        }
    }
    public function retriveItemCartFromDB($user_id)
    {
        $sqlQuery = $this->conn->prepare("
            SELECT laptops.id, laptops.brand, laptops.model, laptops.price, cart.qty
            FROM laptops
            JOIN cart ON laptops.id = cart.laptop_id
            WHERE cart.user_id = :user_id
        ");

        $sqlQuery->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $sqlQuery->execute();

        $cartData = $sqlQuery->fetchAll(PDO::FETCH_ASSOC);
        return $cartData;
    }
    public function removeItemFromCart($laptopId)
    {
        $this->session->startSession();
        if (isset($_COOKIE['user_id'])) {
            $this->removeItemFromCartWithDB($laptopId);
        }

        if (isset($_SESSION['cart'][$laptopId])) {
            unset($_SESSION['cart'][$laptopId]);
        }
        header('Location: ../pages/cart.php');
        exit;
    }

    public function removeItemFromCartWithDB($laptopId)
    {
        $id = ($_COOKIE['user_id']);
        $stmt = $this->conn->prepare("DELETE FROM cart WHERE user_id = :userId AND laptop_id = :laptopId");
        $stmt->bindParam(':userId', $id, PDO::PARAM_INT);
        $stmt->bindParam(':laptopId', $laptopId, PDO::PARAM_INT);
        $stmt->execute();
    }
}
