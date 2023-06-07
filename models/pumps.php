<?php
class pumps
{
    private $db;
    function __construct($conn)
    {
        $this->db = $conn;
    }
    public function allPumps()
    {
        try {
            $sql = "SELECT * FROM pumps";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all rows
            return $result;
        } catch (PDOException $error) {
            echo $error->getmessage();
            return false;
        }
    }
    public function pumpDetails($id)
    {
        try {
            $sql = "SELECT * FROM pumps WHERE id=:id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result;
        } catch (PDOException $error) {
            echo $error->getmessage();
            return false;
        }
    }
    public function fuelTypes()
    {
        try {
            $sql = "SELECT * FROM fuel_types";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all rows
            return $result;
        } catch (PDOException $error) {
            echo $error->getmessage();
            return false;
        }
    }
}
