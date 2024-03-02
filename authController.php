<?php
require_once("../config/db_conn.php");
require_once("SessionController.php");

class authController
{
    private $db, $conn, $session;

    public function connection()
    {
        $this->db = new dbConnect();
        $this->conn = $this->db->dbConnect();
        $this->session = new SessionController();
    }
    public function getUserList()
    {
        $this->connection();
        $sqlQurey = $this->conn->prepare("SELECT * FROM user");

        if ($sqlQurey->execute()) {
            $data  = $sqlQurey->fetchAll();
            if ($data) {
                return $data;
            }
            return false;
        }
    }

    public function removeUser($id)
    {
        $this->connection();
        $sqlQuery = $this->conn->prepare("DELETE FROM user WHERE id = :id");
        $sqlQuery->bindParam(':id', $id, PDO::PARAM_STR);
        $sqlQuery->execute();
        return true;
    }
    public function registerqurey($postData)
    {
        $this->connection();
        $hashedPassword = password_hash($postData['password'], PASSWORD_DEFAULT);
        $sqlQuery =  $this->conn->prepare("INSERT INTO user (name, password,email,mobile) VALUES (:name, :password,:email,:mobile)");

        $sqlQuery->bindParam(':name',  $postData['name'], PDO::PARAM_STR);
        $sqlQuery->bindParam(':email',  $postData['email'], PDO::PARAM_STR);
        $sqlQuery->bindParam(':mobile',  $postData['mobile'], PDO::PARAM_INT);
        $sqlQuery->bindParam(':password', $hashedPassword, PDO::PARAM_STR);


        $sqlQuery->execute();
    }



    public function loginCheck($postData)
    {
        $this->connection();
        $email = $postData['email'];
        $sqlQurey = $this->conn->prepare("SELECT * FROM user WHERE email = :email");

        $sqlQurey->bindParam(':email', $email, PDO::PARAM_STR);
        if ($sqlQurey->execute()) {
            $data  = $sqlQurey->fetch();
            if ($data) {

                if (password_verify($postData['password'], $data['password'])) {
                    $this->addedDataToDb($data['id']);
                    return $data;
                }
                return false;
            }
            return false;
        }
        return false;
    }

    public function addedDataToDb($userId)
    {
        $this->session->startSession();
        $this->connection();

        $cartArray = $this->session->getSessionValue('cart');

        foreach ($cartArray as $laptopId => $quantity) {
            $stmt = $this->conn->prepare("SELECT * FROM cart WHERE user_id = :userId AND laptop_id = :laptopId");
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':laptopId', $laptopId, PDO::PARAM_INT);
            $stmt->execute();
            $cartDbData = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($cartDbData) {
                $newQuantity = $cartDbData['qty'] + $quantity['quantity'];

                $sqlQuery = $this->conn->prepare("UPDATE cart SET qty = :newQuantity WHERE user_id = :userId AND laptop_id = :laptopId");
                $sqlQuery->bindParam(':newQuantity', $newQuantity, PDO::PARAM_INT);
                $sqlQuery->bindParam(':userId', $userId, PDO::PARAM_INT);
                $sqlQuery->bindParam(':laptopId', $laptopId, PDO::PARAM_INT);
                $sqlQuery->execute();
            } else {
                $sqlQuery = $this->conn->prepare("INSERT INTO cart (user_id, laptop_id, qty) VALUES (:userId, :laptopId, :quantity)");
                $sqlQuery->bindParam(':userId', $userId, PDO::PARAM_INT);
                $sqlQuery->bindParam(':laptopId', $laptopId, PDO::PARAM_INT);
                $sqlQuery->bindParam(':quantity', $quantity['quantity'], PDO::PARAM_INT);
                $sqlQuery->execute();
            }
        }
    }
}
