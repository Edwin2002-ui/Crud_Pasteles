<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../config/database.php';

$database = new Database();
$db = $database->getConnection();

$query = "SELECT * FROM Pastel";
$stmt = $db->prepare($query);
$stmt->execute();

$num = $stmt->rowCount();

if ($num > 0) {
    $pasteles_arr = array();
    $pasteles_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $pastel_item = array(
            "ID_pastel" => $ID_pastel,
            "Nombre" => $Nombre,
            "Descripcion" => $Descripcion,
            "Preparado_por" => $Preparado_por,
            "Fecha_creacion" => $Fecha_creacion,
            "Fecha_Vencimiento" => $Fecha_Vencimiento
        );
        array_push($pasteles_arr["records"], $pastel_item);
    }

    http_response_code(200);
    echo json_encode($pasteles_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "No se encontraron pasteles."));
}
?>
