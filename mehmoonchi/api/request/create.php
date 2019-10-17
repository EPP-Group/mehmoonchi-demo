<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("HTTP/1.0 403 Forbidden");
    exit;
}

include_once '../config/database.php';
include_once '../object/request.php';

$database = new Database();
$db = $database->getConnection();

$product = new Request($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if (
    !empty($data->full_name) &&
    !empty($data->phone) &&
    !empty($data->type)
) {

    $product->full_name = $data->full_name;
    $product->phone = $data->phone;
    if (property_exists($data,'description')) {
        $product->description = $data->description;
    } else {
        $product->description = "";
    }
    $product->type = $data->type;
    $product->date = date('Y-m-d H:i:s');

    if ($product->create()) {
        http_response_code(201);
        echo json_encode($product);
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create product."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create product. Data is incomplete."));
}
