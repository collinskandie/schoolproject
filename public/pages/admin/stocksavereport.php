<?php
$pagename = "Admin - Feedback";
include('./adminmaster.php');
$role = $_SESSION['role'];
$id = $_SESSION['id'];
$ids = $_POST['id'];
$names = $_POST['name'];
$quantities = $_POST['quantities'];
$counted = $_POST['counted'];
$delta = $_POST['delta'];

//logs
$action = "stock take";
$date = date('Y-m-d');
$time = date('H:i:s');
$category = "inventory";
$actionTable = "inventory";
$users->logAction($action, $id, $date, $time, $category, $actionTable, $role);

$results = $pumps->takeStock($ids, $names, $quantities, $counted, $id, $delta, $date, $time);
if ($results) {
    echo ("<script>
    alert(' added successfully');
    
</script>");
    echo ('added successfully');
} else {
    echo ("<script>
    alert('error');
</script>");
}
