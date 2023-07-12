<?php
class reports
{
    private $db;
    function __construct($conn)
    {
        $this->db = $conn;
    }
    //active pump
    public function activePump()
    {
        try {
            $sql = "SELECT p.id, p.pump_details, COUNT(*) AS entries_count FROM sales s
                    JOIN pumps p ON s.pump_id = p.id WHERE s.date_sold = CURDATE() GROUP BY p.id, p.pump_details
                    ORDER BY entries_count DESC LIMIT 1;";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result;
        } catch (PDOException $error) {
            echo $error->getmessage();
            return false;
        }
    }
    public function topAttendant()
    {
        try {
            // id, username, email, phone, password, role, last_login, updated_at
            $sql = "SELECT u.id, u.username, COUNT(*) AS entries_count FROM sales s
                    JOIN users u ON s.salesperson_id = u.id WHERE s.date_sold = CURDATE() GROUP BY u.id, u.username
                    ORDER BY entries_count DESC LIMIT 1;";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result;
        } catch (PDOException $error) {
            echo $error->getmessage();
            return false;
        }
    }
    public function totalSales()
    {
        try {
            $sql = "SELECT COUNT(*) AS total_entries, SUM(s.total) AS total_sales
                    FROM sales s
                    WHERE s.date_sold = CURDATE()";

            $stmt = $this->db->query($sql);
            $result = $stmt->fetch();

            if ($result !== false) {
                $totalEntries = $result['total_entries'];
                $totalSales = $result['total_sales'];

                echo "Total Entries: $totalEntries<br>";
                echo "Total Sales: $totalSales<br>";
            } else {
                echo "No data found.";
            }

            return $result;
        } catch (PDOException $error) {
            echo $error->getMessage();
            return false;
        }
    }
}
