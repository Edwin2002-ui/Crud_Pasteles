<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../config/database.php';

$database = new Database();
$db = $database->getConnection();

$query = "SELECT * FROM Ingrediente";
$stmt = $db->prepare($query);
$stmt->execute();

$num = $stmt->rowCount();

if ($num > 0) {
    $ingredientes_arr = array();
    $ingredientes_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $ingrediente_item = array(
            "ID_ingrediente" => $ID_ingrediente,
            "Nombre" => $Nombre,
            "Descripcion" => $Descripcion,
            "Fecha_ingreso" => $Fecha_ingreso,
            "Fecha_Vencimiento" => $Fecha_Vencimiento
        );
        array_push($ingredientes_arr["records"], $ingrediente_item);
    }

    http_response_code(200);
    echo json_encode($ingredientes_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "No se encontraron ingredientes."));
}
?>
