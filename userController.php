<?php
require_once("../config/db_conn.php");
require_once("authController.php");
require_once("tosterResponse.php");
require_once("SessionController.php");
require_once("cookiesController.php");


class User extends authController
{
    private $db, $conn, $response, $session, $cookie;

    public function __construct()
    {
        $this->db = new dbConnect();
        $this->conn = $this->db->dbConnect();
        $this->response = new tostMsg();
        $this->session = new SessionController();
        $this->cookie = new cookiesController();
    }
    public function checkUserAuth()
    {
        $this->session->startSession();

        if (isset($_COOKIE['user_id'])) {
            header('Location: ../pages/shop.php');
            exit;
        }
    }
    public function register($postData)
    {
        $validationResult = $this->validatedRegisterData($postData);
        if (!$validationResult) {
            $this->response->errorMessagesGroup();
            return false;
        }
        $resposeStatus = $this->registerqurey($postData);
        $this->session->setSessionValue('registerSucess', true);

      
        return  true;
    }

    public function login($postData)
    {
        $validationResult = $this->ValidatedLoginData($postData);
        if (!$validationResult) {
            $this->response->errorMessagesGroup();
            return false;
        }

        $userdata = $this->loginCheck($postData);
        if ($userdata) {

            $this->response->successMessage("User Login Successfull!");
            $this->session->startSession();

            $this->cookie->setCookie('user_id', $userdata['id']);
            $this->cookie->setCookie('is_admin', $userdata['is_admin']);
          

            return $userdata;
        }
        $this->response->errorMessages("No user found!!");
        return false;
    }
    public function getUser()
    {
        return $this->getUserList();
    }

    public function deleteUser($id)
    {
        if ($id == '1') {
            $this->response->errorMessages("You can not delete Super Admin User");
            return false;
        }
        $this->removeUser($id);
        $this->response->successMessage("User Delete Successfull!");
        return true;
    }
    public function ValidatedLoginData($postData)
    {
        $errors = [];
        $email = $postData['email'];
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email format.';
        }
        if (empty($postData['email'])) {
            $errors['email'] = 'Email is mandatory.';
        }

        if (empty($postData['password'])) {
            $errors['password'] = 'Password is mandatory.';
        }
        if (!empty($errors)) {
            $_SESSION['flash_messages'] = $errors;
            return false;
        }
        return true;
    }
    public function validatedRegisterData($postData)
    {
        $errors = [];

    
        $username = htmlspecialchars($postData['name']);
        if (empty($username)) {
            $errors['name'] = 'Name is mandatory.';
        }

        if (empty($postData['email'])) {
            $errors['email'] = 'Email is mandatory.';
        }
        $email = $postData['email'];
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid user email format.';
        }

        if (empty($postData['mobile']) || !preg_match("/^\d{10}$/", $postData['mobile'])) {
            $errors['mobile'] = 'Mobile is mandatory.';
        }

        $confirmPassword = $postData['c_password'];
        if ($postData['password'] !== $confirmPassword) {
            $errors['c_password'] = 'Passwords isnt same.';
        }

        $email = $postData['email'];
        $sqlQurey = $this->conn->prepare("SELECT email FROM user WHERE email = :email");
        $sqlQurey->bindParam(':email', $email, PDO::PARAM_STR);
        if ($sqlQurey->execute()) {
            $data  = $sqlQurey->fetchAll();
            if ($data) {
                $errors['emailCheck'] = 'User Email id is in use';
            }
        }
        if (!empty($errors)) {
            $_SESSION['flash_messages'] = $errors;
            return false;
        }
        return true;
    }

    public function userLogout()
    {
        if (isset($_COOKIE['user_id'])) {
            $userId = $_COOKIE['user_id'];
            $this->cookie->deleteCookie('user_id');
            $this->cookie->deleteCookie('is_admin');
            header('Location: ../pages/login.php');
            exit;
        }
    }
}
$obj = new User();
if (isset($_POST['logout'])) {
    $obj->userLogout();
}
if (isset($_POST['deleteUser'])) {
    $obj->deleteUser($_POST['id']);
}

session_start();
