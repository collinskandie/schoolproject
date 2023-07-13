<?php
$pagename = "Admin - Delete";
include('./adminmaster.php');
$id = $_GET['id'];
$result = $pumps->getPumpbyId($id);
$pump = $result['pump_details'];

echo ("<script>alert('Pump $pump will be deleted');</script>");

$results = $pumps->deletePump($id);

if (!$results) {
    echo ("<script>alert('Error deleteing pump');</script>");
} else {
    echo ("<script>alert('Successfully deleted $pump');</script>");
    header("Location: managepumps.php");
}
