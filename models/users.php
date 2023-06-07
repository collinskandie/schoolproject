<?php
class users
{
    private $db;
    function __construct($conn)
    {
        $this->db = $conn;
    }
    public function logAction($action, $actionby, $actionDate, $actionTime, $category, $actionTable, $user_role)
    {
        try {
            $sql = "INSERT INTO logs (actions, actionby, actiondate, actiontime, category, actiontable, user_role) VALUES (:actions, :actionby, :actiondate, :actiontime, :category, :actiontable, :user_role)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':actions', $action);
            $stmt->bindparam(':actionby', $actionby);
            $stmt->bindparam(':actiondate', $actionDate);
            $stmt->bindparam(':actiontime', $actionTime);
            $stmt->bindparam(':category', $category);
            $stmt->bindparam(':actiontable', $actionTable);
            $stmt->bindparam(':user_role', $user_role);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $error) {
            echo $error->getmessage();
            return false;
        }
    }
    public function insertUser($email, $password, $username, $phone, $role)
    {
        try {
            // /check if user with email exhist
            $result = $this->getUserByEmail($email);
            if ($result > 0) {
                echo ("user exhist");
                return false;
            } else {
                $new_password = md5($password . $email);
                $sql = "INSERT INTO users (username, email, phone, password, role) VALUES (:username, :email, :phone, :password, :role)";
                $stmt = $this->db->prepare($sql);
                //bind params
                $stmt->bindparam(':username', $username);
                $stmt->bindparam(':email', $email);
                $stmt->bindparam(':phone', $phone);
                $stmt->bindparam(':password', $new_password);
                $stmt->bindparam(':role', $role);
                $stmt->execute();
                return $stmt;
            }
        } catch (PDOException $error) {
            echo $error->getmessage();
            return false;
        }
    }
    public function getUserByEmail($email)
    {
        try {
            $sql = "SELECT * FROM users where email=:email";
            $smt = $this->db->prepare($sql);
            $smt->bindparam(':email', $email);
            $smt->execute();
            $result = $smt->fetch();
            return $result;
        } catch (PDOException $error) {
            echo $error->getmessage();
            return false;
        }
    }
    public function userLogin($email, $password)
    {
        try {
            $sql = "SELECT * FROM `users` WHERE email=:email AND password=:password";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result;
        } catch (PDOException $error) {
            echo $error->getMessage();
            return false;
        }
    }
    public function getAllUsers()
    {
        try {
            // select all users
            $sql = "SELECT * FROM users";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all rows
            return $result;
        } catch (PDOException $error) {
            echo $error->getMessage();
            return false;
        }
    }
}
