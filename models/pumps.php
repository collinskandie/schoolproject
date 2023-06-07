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
            $sql = "SELECT f.*, i.price FROM fuel_types f INNER JOIN inventory i ON f.id = i.fuel_type";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all rows
            return $result;
        } catch (PDOException $error) {
            echo $error->getmessage();
            return false;
        }
    }
    public function fuelPrices($fuel)
    {
        $sql = "SELECT * FROM inventory WHERE fuel_type=:fuel_type";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':fuel_type', $fuel);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result;
    }
}
