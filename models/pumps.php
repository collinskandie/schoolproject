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
    public function addPump($details)
    {
        //create pump
        try {
            $sql = "INSERT INTO pumps (pump_details) VALUES (:details)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':details', $details);
            $stmt->execute();
            return $stmt;
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
    //fetch fuel stocks here
    public function fetchItems()
    {
        try {
            $sql = "SELECT * FROM inventory";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all rows
            return $result;
        } catch (PDOException $error) {
            echo $error->getmessage();
            return false;
        }
    }
    public function fetchAllItems()
    {
        try {
            $sql = "SELECT i.*, u.username FROM inventory i
            JOIN users u ON i.received_by = u.id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all rows
            return $result;
        } catch (PDOException $error) {
            echo $error->getmessage();
            return false;
        }
    }
    //select pum by id
    public function getPumpbyId($id)
    {
        try {
            $sql = "SELECT * FROM pumps where id=:id";
            $smt = $this->db->prepare($sql);
            $smt->bindparam(':id', $id);
            $smt->execute();
            $result = $smt->fetch();
            return $result;
        } catch (PDOException $error) {
            echo $error->getmessage();
            return false;
        }
    }
    public function deletePump($id)
    {
        try {
            // Remove the association between sales and the user being deleted
            $sql = "UPDATE sales SET pump_id = NULL WHERE pump_id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $sql = "DELETE FROM pumps where id=:id";
            $smt = $this->db->prepare($sql);
            $smt->bindparam(':id', $id);
            $result = $smt->execute();
            return $result;
        } catch (PDOException $error) {
            echo $error->getmessage();
            return false;
        }
    }
    public function editPump($id, $details)
    {
        try {
            $sql = "UPDATE pumps SET pump_details = :details WHERE id=:id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':details', $details);
            $stmt->bindParam(':id', $id);
            $result = $stmt->execute();
            return $result;
        } catch (PDOException $error) {
            echo $error->getmessage();
            return false;
        }
    }
    // manage fuel types
    public function fuelTypeslist()
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
