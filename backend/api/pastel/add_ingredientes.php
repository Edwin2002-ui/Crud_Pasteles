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

if (
    !empty($data->ID_pastel) &&
    !empty($data->ID_ingredientes)
) {
    foreach ($data->ID_ingredientes as $ID_ingrediente) {
        $query = "INSERT INTO Pastel_Ingredientes SET ID_pastel=:ID_pastel, ID_ingrediente=:ID_ingrediente";
        $stmt = $db->prepare($query);

        $stmt->bindParam(":ID_pastel", $data->ID_pastel);
        $stmt->bindParam(":ID_ingrediente", $ID_ingrediente);

        if (!$stmt->execute()) {
            http_response_code(503);
            echo json_encode(array("message" => "No se pudo añadir el ingrediente."));
            exit();
        }
    }
    http_response_code(201);
    echo json_encode(array("message" => "Ingredientes fueron añadidos."));
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Datos incompletos."));
}
?>
