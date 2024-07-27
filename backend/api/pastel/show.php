<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../config/database.php';

$database = new Database();
$db = $database->getConnection();

$id = isset($_GET['id']) ? $_GET['id'] : die();

$query = "SELECT * FROM Pastel WHERE ID_pastel = ?";
$stmt = $db->prepare($query);
$stmt->bindParam(1, $id);
$stmt->execute();

$num = $stmt->rowCount();

if($num > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $pastel_arr = array(
        "ID_pastel" => $row['ID_pastel'],
        "Nombre" => $row['Nombre'],
        "Descripcion" => $row['Descripcion'],
        "Preparado_por" => $row['Preparado_por'],
        "Fecha_creacion" => $row['Fecha_creacion'],
        "Fecha_Vencimiento" => $row['Fecha_Vencimiento']
    );

    http_response_code(200);
    echo json_encode($pastel_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Pastel no encontrado."));
}
?>
