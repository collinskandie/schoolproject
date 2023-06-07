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

            $lastInsertedId = $this->db->lastInsertId(); // Retrieve the last inserted ID

            return $lastInsertedId;
        } catch (PDOException $error) {
            echo $error->getmessage();
            return false;
        }
    }
    public function savePayment($receipt_number, $payment_method, $amount_tendered, $change_amount)
    {
        try {
            $sql = "INSERT INTO payments (receipt_number, payment_method, amount_tendered, change_amount) VALUES (:receipt_number, :payment_method, :amount_tendered, :change_amount)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':receipt_number', $receipt_number);
            $stmt->bindparam(':payment_method', $payment_method);
            $stmt->bindparam(':amount_tendered', $amount_tendered);
            $stmt->bindparam(':change_amount', $change_amount);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $error) {
            echo $error->getmessage();
            return false;
        }
    }
}
