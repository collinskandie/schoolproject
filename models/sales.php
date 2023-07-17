<?php
class sales
{
    private $db;
    function __construct($conn)
    {
        $this->db = $conn;
    }
    public function makeSale($item_id, $item_quantity, $price, $total, $pump_id, $salesperson_id, $time_sold, $date_sold)
    {
        try {
            $sql = "INSERT INTO sales (item_id, item_quantity, price, total, pump_id, salesperson_id, time_sold,date_sold) VALUES (:item_id, :item_quantity, :price, :total, :pump_id, :salesperson_id, :time_sold,:date_sold)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':item_id', $item_id);
            $stmt->bindparam(':item_quantity', $item_quantity);
            $stmt->bindparam(':price', $price);
            $stmt->bindparam(':total', $total);
            $stmt->bindparam(':pump_id', $pump_id);
            $stmt->bindparam(':salesperson_id', $salesperson_id);
            $stmt->bindparam(':time_sold', $time_sold);
            $stmt->bindparam(':date_sold', $date_sold);
            $stmt->execute();

            $lastInsertedId = $this->db->lastInsertId();

            //update inventory
            $updateInventorySql = "UPDATE inventory SET quantity = quantity - :quantity, last_sold = NOW() WHERE fuel_type = :fuel_id";
            $updateStmt = $this->db->prepare($updateInventorySql);
            $updateTank = "UPDATE tanks SET available_quantity = available_quantity - :quantity WHERE fuel_type = :item_id";
            $updateTstmt = $this->db->prepare($updateTank);

            // Bind params for inventory table update
            $updateStmt->bindParam(':quantity', $item_quantity);
            $updateStmt->bindParam(':fuel_id', $item_id);
            // Execute the statement to update the inventory
            $updateStmt->execute();
            // Update tanks
            $updateTstmt->bindParam(':quantity', $item_quantity);
            $updateTstmt->bindParam(':item_id', $item_id);
            $updateTstmt->execute();

            // Retrieve the last inserted ID

            //update tanks and inventory

            return $lastInsertedId;
        } catch (PDOException $error) {
            echo $error->getmessage();
            return false;
        }
    }
    public function updateStock($item, $quantity)
    {
        try {
            $updateInventorySql = "UPDATE inventory SET quantity = quantity - :quantity, last_sold = NOW(), WHERE fuel_type = :fuel_id";
            $updateStmt = $this->db->prepare($updateInventorySql);
            $updateTank = "UPDATE tanks SET available_quantity = available_quantity - :quantity WHERE fuel_type = :item_id";
            $updateTstmt = $this->db->prepare($updateTank);

            // Bind params for inventory table update
            $updateStmt->bindParam(':quantity', $quantity);
            $updateStmt->bindParam(':fuel_id', $item);
            // Execute the statement to update the inventory
            $updateStmt->execute();
            // Update tanks
            $updateTstmt->bindParam(':quantity', $quantity);
            $updateTstmt->bindParam(':item_id', $item);
            $updateTstmt->execute();

            return $updateStmt;
        } catch (PDOException $error) {
            echo $error->getmessage();
            return false;
        }
    }
    public function savePayment($receipt_number, $payment_method, $amount_tendered, $change_amount, $user)
    {
        try {
            // $cleared= "Pending";
            $sql = "INSERT INTO payments (receipt_number, payment_method, amount_tendered, change_amount, user) VALUES (:receipt_number, :payment_method, :amount_tendered, :change_amount,:user)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':receipt_number', $receipt_number);
            $stmt->bindparam(':payment_method', $payment_method);
            $stmt->bindparam(':amount_tendered', $amount_tendered);
            $stmt->bindparam(':change_amount', $change_amount);
            // $stmt->bindparam(':cleared', $cleared);
            $stmt->bindparam(':user', $user);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $error) {
            echo $error->getmessage();
            return false;
        }
    }
    public function unCleared($user)
    {
        try {
            $state = "Pending";
            $sql = "SELECT p.id as pid, p.*, s.*, i.* FROM payments p JOIN sales s ON p.receipt_number = s.id JOIN inventory i ON s.item_id = i.id WHERE p.cleared = :cleared AND p.user = :user";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':cleared', $state);
            $stmt->bindParam(':user', $user);
            $stmt->execute(); // Execute the query
            $result = $stmt->fetchAll(); // Fetch all rows as an array
            return $result;
        } catch (PDOException $error) {
            echo $error->getMessage();
            return false;
        }
    }
    public function clearSale($receipts_id, $cleared_time, $total_expected, $total_cleared, $variance, $userid)
    {
        try {
            //change sale status to cleared first.
            //records transaction.
            $sql = "INSERT INTO sales_clearance (receipts_id, cleared_time, total_expected, total_cleared, variance, userid) VALUES(:receipts_id, :cleared_time, :total_expected, :total_cleared, :variance, :userid)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':receipts_id', $receipts_id);
            $stmt->bindparam(':cleared_time', $cleared_time);
            $stmt->bindparam(':total_expected', $total_expected);
            $stmt->bindparam(':total_cleared', $total_cleared);
            $stmt->bindparam(':variance', $variance);
            $stmt->bindparam(':userid', $userid);
            $stmt->execute();
            $lastInsertedId = $this->db->lastInsertId();

            // $this->ClearEntry($selectedReceiptIds);

            return $lastInsertedId;
        } catch (PDOException $error) {
            echo $error->getMessage();
            return false;
        }
    }
    public function ClearEntry($selectedReceiptIds)
    {
        try {
            foreach ($selectedReceiptIds as $receiptId) {
                $sql = "UPDATE payments SET cleared = 'Cleared' WHERE receipt_number = :receiptId";
                // Prepare and execute the SQL statement
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':receiptId', $receiptId);
                $stmt->execute();
            }

            return true; // Moved outside the foreach loop
        } catch (PDOException $error) {
            echo $error->getMessage();
            return false;
        }
    }
    //select payments to display to the user
    public function salesperPerson($userid, $date)
    {
        try {
            $sql = "SELECT * FROM sales where salesperson_id= :user AND date_sold = :date_sold ";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':user', $userid);
            $stmt->bindParam(':date_sold', $date);
            $stmt->execute(); // Execute the query
            $result = $stmt->fetchAll();
            // var_dump($result);
            return $result;
        } catch (PDOException $error) {
            echo $error->getMessage();
            return false;
        }
    }
    public function getSettings()
    {
        try {
            $sql = "SELECT * FROM settings";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(); // Execute the query
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOException $error) {
            echo $error->getMessage();
            return false;
        }
    }
    public function updateSettings($id, $new_value)
    {
        try {
            $sql = "UPDATE settings SET value =:new_value WHERE settings_id=:id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':new_value', $new_value);
            $stmt->bindParam(':id', $id);
            $result = $stmt->execute(); // Execute the query
            return $result;
        } catch (PDOException $error) {
            echo $error->getMessage();
            return false;
        }
    }
}
