<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

header('Content-Type: application/json');

$sql = "SELECT branch_id, name, map_url 
        FROM branch 
        WHERE status = 'Active' 
        ORDER BY name ASC";
$result = $conn->query($sql);

$branches = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $branches[] = [
            "branch_id" => $row["branch_id"],
            "name" => $row["name"],
            "map_url" => $row["map_url"] ?? "#"
        ];
    }
}

echo json_encode($branches);
