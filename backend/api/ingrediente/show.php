<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../config/database.php';

$database = new Database();
$db = $database->getConnection();

$id = isset($_GET['id']) ? $_GET['id'] : die();

$query = "SELECT * FROM Ingrediente  WHERE ID_ingrediente = ?";
$stmt = $db->prepare($query);
$stmt->bindParam(1, $id);
$stmt->execute();

$num = $stmt->rowCount();

if($num > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $ingrediente_arr = array(
        "ID_ingrediente" => $row['ID_ingrediente'],
        "Nombre" => $row['Nombre'],
        "Descripcion" => $row['Descripcion'],
        "Fecha_ingreso" => $row['Fecha_ingreso'],
        "Fecha_Vencimiento" => $row['Fecha_Vencimiento']
    );

    http_response_code(200);
    echo json_encode($ingrediente_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Pastel no encontrado."));
}
?>
