<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/database.php';

$database = new Database();
$db = $database->getConnection();

$data = json_decode(file_get_contents("php://input"));
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit;
}
if (!empty($data->ID_ingrediente)) {
    $query = "DELETE FROM Ingrediente WHERE ID_ingrediente=:ID_ingrediente";
    $stmt = $db->prepare($query);

    $stmt->bindParam(":ID_ingrediente", $data->ID_ingrediente);

    if ($stmt->execute()) {
        http_response_code(200);
        echo json_encode(array("message" => "Ingrediente fue eliminado."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "No se pudo eliminar el ingrediente."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "ID_ingrediente vacio"));
}
?>
