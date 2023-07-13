<?php
session_start();

$result = $pumps->fetchItems();


if ($result) {
    $items = array();

    // Loop through the result set and store each item in an array
    while ($row = mysqli_fetch_assoc($result)) {
        $items[] = $row;
    }
    // Return the items data as JSON
    header('Content-Type: application/json');
    echo json_encode($items);
} else {
    // Handle the case where fetching items data failed
    http_response_code(500);
    echo json_encode(array('error' => 'Failed to fetch items data.'));
}
