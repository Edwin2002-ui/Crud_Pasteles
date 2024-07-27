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

if (
    !empty($data->ID_ingrediente) &&
    !empty($data->Nombre) &&
    !empty($data->Descripcion) &&
    !empty($data->Fecha_ingreso) &&
    !empty($data->Fecha_Vencimiento)
) {
    $query = "UPDATE Ingrediente SET Nombre=:Nombre, Descripcion=:Descripcion, Fecha_ingreso=:Fecha_ingreso, Fecha_Vencimiento=:Fecha_Vencimiento WHERE ID_ingrediente=:ID_ingrediente";
    $stmt = $db->prepare($query);

    $stmt->bindParam(":ID_ingrediente", $data->ID_ingrediente);
    $stmt->bindParam(":Nombre", $data->Nombre);
    $stmt->bindParam(":Descripcion", $data->Descripcion);
    $stmt->bindParam(":Fecha_ingreso", $data->Fecha_ingreso);
    $stmt->bindParam(":Fecha_Vencimiento", $data->Fecha_Vencimiento);

    if ($stmt->execute()) {
        http_response_code(200);
        echo json_encode(array("message" => "Ingrediente fue actualizado."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "No se pudo actualizar el ingrediente."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Datos incompletos."));
}
?>
