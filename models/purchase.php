<?php
class purchase
{
    // dealing with purchase orders
    private $db;
    // Create an instance of the other class

    function __construct($conn)
    {
        $this->db = $conn;
        // $users = new users;
    }
    
    public function saveOrder($supplier, $vehicleType, $driverName, $items, $quantities, $costs, $subtotals, $user)
    {
        try {
            $sql = "INSERT INTO purchase_orders (items_count, total_cost, user, date, time)
          VALUES (:items_count, :total_cost, :user, :date, :time)";

            $date = date('Y-m-d');
            $time = date('H:i:s');
            $itemsCount = count($items);
            $totalCost = $this->calculateTotalCost($costs, $quantities);

            $stmt = $this->db->prepare($sql);
            //bind params            
            $stmt->bindParam(':items_count', $itemsCount);
            $stmt->bindParam(':total_cost', $totalCost);
            $stmt->bindParam(':user', $user);
            $stmt->bindParam(':date', $date);
            $stmt->bindParam(':time', $time);
            $stmt->execute();

            $poNumber = $this->db->lastInsertId();

            //calculate cost

            // insert individual items to order_items table
            $save = $this->saveItem($poNumber, $items, $quantities, $costs, $subtotals, $user);
            //update logs
            
            // 
            if ($save) {
                echo "Success";
            }
            //return non-null value
            return $stmt;
        } catch (PDOException $error) {
            echo $error->getmessage();
            return false;
        }
    }
    public   function calculateTotalCost($costs, $quantities)
    {
        $total = 0;
        for ($i = 0; $i < count($costs); $i++) {
            $total += $costs[$i] * $quantities[$i];
        }
        return $total;
    }
    public function saveItem($PO_number, $items, $quantities, $costs, $subtotals, $user)
    {
        try {
            $sql = "INSERT INTO order_items (PO_number, item_id, quantity, cost, subtotal) VALUES (:po,:item,:quantity,:cost,:subtotal)";
            $stmt = $this->db->prepare($sql);

            $updateInventorySql = "UPDATE inventory SET quantity = quantity + :quantity, cost = :cost, last_received = NOW(), received_by = :received_by WHERE fuel_type = :fuel_id";
            $updateStmt = $this->db->prepare($updateInventorySql);

            $updateTank = "UPDATE tanks SET available_quantity = available_quantity + :quantity WHERE fuel_type = :item_id";
            $updateTstmt = $this->db->prepare($updateTank);

            for ($i = 0; $i < count($items); $i++) {
                // Retrieve the values for the current item
                $item = $items[$i];
                $quantity = $quantities[$i];
                $cost = $costs[$i];
                $subtotal = $subtotals[$i];

                // Bind params for order_items table insertion
                $stmt->bindParam(':po', $PO_number);
                $stmt->bindParam(':item', $item);
                $stmt->bindParam(':quantity', $quantity);
                $stmt->bindParam(':cost', $cost);
                $stmt->bindParam(':subtotal', $subtotal);
                // Execute the statement to insert the item
                $stmt->execute();

                // Bind params for inventory table update
                $updateStmt->bindParam(':quantity', $quantity);
                $updateStmt->bindParam(':cost', $cost);
                $updateStmt->bindParam(':received_by', $user);
                $updateStmt->bindParam(':fuel_id', $item);

                // Execute the statement to update the inventory
                $updateStmt->execute();

                // Update tanks
                $updateTstmt->bindParam(':quantity', $quantity);
                $updateTstmt->bindParam(':item_id', $item);
                $updateTstmt->execute();
            }

            return true;
        } catch (PDOException $error) {
            echo $error->getMessage();
            return false;
        }
    }
}
