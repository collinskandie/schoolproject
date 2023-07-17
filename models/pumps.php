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
    public function inventoryAll()
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
    // add new inventory item
    public function addInventory($name, $cost, $price, $quantity, $received_by, $fuel_type)
    {
        $currentTimestamp = date('Y-m-d H:i:s');
        try {
            $sql = "INSERT INTO inventory (name, cost, price, quantity,last_received, received_by, fuel_type) 
            VAlUES(:name, :cost, :price, :quantity,:last_received,:received_by, :fuel_type)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':cost', $cost);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':quantity', $quantity);
            $stmt->bindParam(':last_received', $currentTimestamp);
            $stmt->bindParam(':received_by', $received_by);
            $stmt->bindParam(':fuel_type', $fuel_type);
            $result = $stmt->execute();
            return $result;
        } catch (PDOException $error) {
            echo $error->getmessage();
            return false;
        }
    }
    // get inventory item by id 
    public function getInventory($id)
    {
        try {
            //
            $sql = "SELECT * FROM inventory where id=:id";
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
    //edit inventory

    public function editInventory($id, $name, $cost, $price, $quantity)
    {
        try {
            $sql = "UPDATE inventory SET name = :name, cost = :cost, price = :price, quantity = :quantity WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':cost', $cost);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':quantity', $quantity);
            $stmt->bindParam(':id', $id);
            $result = $stmt->execute();
            return $result;
        } catch (PDOException $error) {
            echo $error->getMessage();
            return false;
        }
    }
    public function deleteInventory($id)
    {
        try {
            // Remove the association between sales and the user being deleted
            $sql = "UPDATE sales SET item_id = NULL WHERE item_id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $sql = "DELETE FROM inventory where id=:id";
            $smt = $this->db->prepare($sql);
            $smt->bindparam(':id', $id);
            $result = $smt->execute();
            return $result;
        } catch (PDOException $error) {
            echo $error->getmessage();
            return false;
        }
    }
    //create stock take entries
    public function takeStock($ids, $names, $quantities, $counted, $user, $delta, $date, $time)
    {
        try {
            // arrays ids, names,quantities, counted,delta
            $sql = "INSERT INTO stock_take (date, time, user) 
            VAlUES(:date, :time, :user)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':date', $date);
            $stmt->bindParam(':time', $time);
            $stmt->bindParam(':user', $user);
            $stmt->execute();

            $lastInsertedId = $this->db->lastInsertId();

            //create entries for each stock take item
            if (!empty($ids) && !empty($counted) && count($ids) === count($counted)) {

                for ($i = 0; $i < count($ids); $i++) {
                    $sql = "INSERT INTO stock_take_items (item_id, stock_take_id, actual_quantity, counted, delta) 
                    VALUES(:id, :stockTakeId, :acqualQuantity, :counted, :delta)";
                    $stmt = $this->db->prepare($sql);
                    $stmt->bindParam(':id', $ids[$i]);
                    $stmt->bindParam(':stockTakeId', $lastInsertedId);
                    $stmt->bindParam(':acqualQuantity', $quantities[$i]);
                    $stmt->bindParam(':counted', $counted[$i]);
                    $stmt->bindParam(':delta', $delta[$i]);
                    $stmt->execute();

                    $quantity = $quantities[$i];
                    $id = $ids[$i];

                    //update stock
                    $this->updateStockLevel($quantity, $id);
                }
            }
            return true;
        } catch (PDOException $error) {
            echo $error->getmessage();
            return false;
        }
    }
    public function updateStockLevel($quantity, $id)
    {
        try {
            $updateStock = "UPDATE inventory SET quantity = :actualQuantity WHERE id = :id";
            $smt = $this->db->prepare($updateStock);
            $smt->bindParam(':actualQuantity', $quantity);
            $smt->bindParam(':id', $id);
            $result = $smt->execute();
            if ($result) {                            
                echo "Quantity updated for ID: " . $id;
            } else {
                // Update failed
                echo "Failed to update quantity for ID: " . $id;
            }
        } catch (PDOException $error) {
            echo $error->getMessage();
            return false;
        }
    }
    }
