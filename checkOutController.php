<?php
require_once("../config/db_conn.php");
require_once("authController.php");
require_once("tosterResponse.php");
require_once("SessionController.php");
require_once("cartController.php");
require('fpdf186/fpdf.php');


class checkOutController extends cartController
{
    private $db, $conn, $response, $session, $cart, $cartObj;

    public function __construct()
    {
        $this->db = new dbConnect();
        $this->conn = $this->db->dbConnect();
        $this->response = new tostMsg();
        $this->session = new SessionController();
        $this->cart = new cartController();
        $this->cartObj = new cartController();
    }

    public function checkUserAuth()
    {
        $this->session->startSession();

        if (!isset($_COOKIE['user_id'])) {
            header('Location: ../pages/login.php');
            exit;
        }
    }
    public function invoice($data)
    {

        $pdf = new FPDF();
        $pdf->AddPage();



        $pdf->SetFont('Arial', 'B', 18);

        $pdf->Cell(190, 10, 'NoNameDevs', 0, 1, 'C');
        $pdf->Cell(190, 10, 'Customer Invoice', 0, 1, 'C');


        $pdf->Ln(10);

        $pdf->SetFont('Arial', '', 12);

        $pdf->Cell(50, 10, 'Date: ' . $data['date'], 0, 1);
        $pdf->Cell(50, 10, 'Invoice #: 9864', 0, 1);

        $pdf->Cell(50, 10, 'Customer: ' . $data['customerName'], 0, 1);
        $pdf->Cell(50, 10, 'Phone: ' . $data['phone'], 0, 1);
        $pdf->Cell(50, 10, 'Address: ' . $data['address'], 0, 1);

        $pdf->Ln(10);

        $pdf->Cell(50, 10, 'Product Name', 1);
        $pdf->Cell(30, 10, 'Quantity', 1);
        $pdf->Cell(30, 10, 'Unit Price', 1);
        $pdf->Cell(40, 10, 'Total', 1);
        $pdf->Ln();

        foreach ($data['products'] as $product) {
            $pdf->Cell(50, 10, $product['brand'], 1);
            $pdf->Cell(30, 10, $product['qty'], 1);
            $pdf->Cell(30, 10, $product['price'], 1);
            $pdf->Cell(40, 10, ($product['price'] * $product['qty']), 1);
            $pdf->Ln();
        }

        $pdf->Ln(10);


        $pdf->Cell(110, 10, 'Subtotal', 1);
        $pdf->Cell(40, 10, $data['subtotal'], 1);
        $pdf->Ln();


        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(50, 10, '* This invoice is mandatory for any returns/refunds/exchange', 0, 1);

        $pdf->Output();
    }
    public function orderStore($productData)
    {
        if (isset($_COOKIE['user_id']))
            $id = $_COOKIE['user_id'];
        $stmt = $this->conn->prepare("INSERT INTO orders (laptop_id, user_id, status, order_amount) 
            VALUES(:laptop_id,:user_id,:status,:order_amount)");
        $status = "In-Proccess";

        foreach ($productData as $product) {
            $total = $product['price'] * $product['qty'];
            $stmt->bindParam(':laptop_id', $product['id']);
            $stmt->bindParam(':user_id', $id);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':order_amount', $total);
            $stmt->execute();

            $this->removeItemFromCart($product['id']);
        }
        return;
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
        return;
    }

    public function removeItemFromCartWithDB($laptopId)
    {
        $id = ($_COOKIE['user_id']);
        $stmt = $this->conn->prepare("DELETE FROM cart WHERE user_id = :userId AND laptop_id = :laptopId");
        $stmt->bindParam(':userId', $id, PDO::PARAM_INT);
        $stmt->bindParam(':laptopId', $laptopId, PDO::PARAM_INT);
        $stmt->execute();
    }
    public function invoiceData($postData)
    {
        $this->session->startSession();

        $this->placeOrderValidation($postData);
        $id = $_COOKIE['user_id'];
        $sqlQurey = $this->conn->prepare("SELECT * FROM user WHERE id = :id");

        $sqlQurey->bindParam(':id', $id, PDO::PARAM_STR);
        if ($sqlQurey->execute()) {
            $userData  = $sqlQurey->fetch();
        }
        $productData = $this->cart->getCartItems();
        $this->orderStore($productData);

        

        $invoiceData = [
            'date' => date('Y-m-d'),
            'invoiceNumber' => '9864',
            'customerName' => $postData['firstName'] . ' ' . $postData['lastName'],
            'phone' => $userData['mobile'],
            'address' => $postData['address'],
            'products' => $productData,
            'subtotal' => $postData['totale'],
            'total' => $postData['totale'] + 9,
        ];
        $this->invoice($invoiceData);
    }

    public function placeOrderValidation($postData)
    {
        $errors = [];

        $firstName = htmlspecialchars($postData['firstName']);
        if (empty($firstName)) {
            $errors['firstName'] = 'First Name is mandatory.';
        }

        if (empty($postData['lastName'])) {
            $errors['lastName'] = 'Last Name is mandatory.';
        }

        if (empty($postData['lastName'])) {
            $errors['lastName'] = 'Last Name is mandatory.';
        }

        if (empty($postData['address'])) {
            $errors['address'] = 'Last Name is mandatory.';
        }

        if (empty($postData['city'])) {
            $errors['city'] = 'City is mandatory.';
        }
        if (empty($postData['zip'])) {
            $errors['zip'] = 'Zip Code Require is mandatory.';
        }
        if (!empty($errors)) {
            $_SESSION['flash_messages'] = $errors;
            header('Location: ../pages/checkout.php');
            exit;
            return false;
        }
        return true;
    }
}
$checkOutController = new checkOutController();

if (isset($_POST['placeOrder'])) {
    $checkOutController->invoiceData($_POST);
}
