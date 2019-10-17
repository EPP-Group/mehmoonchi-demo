<?php
include_once '../config/database.php';
include_once '../object/request.php';

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
if ($_SERVER['REQUEST_METHOD'] != 'GET') {
    header("HTTP/1.0 403 Forbidden");
    exit;
  }

$database = new Database();
$db = $database->getConnection();
$product = new Request($db);
$stmt = $product->read();

$products_arr = array();
$products_arr["records"] = array();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);

    $product_item = array(
        "pk_id" => $pk_id,
        "full_name" => $full_name,
        "description" => html_entity_decode($description),
        "type" => $type,
        "date" => $date,
        "phone" => $phone
    );

    array_push($products_arr["records"], $product_item);
}
http_response_code(200);
echo json_encode($products_arr);
