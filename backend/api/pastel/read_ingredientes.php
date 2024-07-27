<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../config/database.php';

$database = new Database();
$db = $database->getConnection();

// Obtener el ID del pastel desde la URL
$id_pastel = isset($_GET['id']) ? $_GET['id'] : die();

if (!empty($id_pastel)) {
    $query = "SELECT i.* FROM Ingrediente i INNER JOIN Pastel_Ingredientes pi ON i.ID_ingrediente = pi.ID_ingrediente WHERE pi.ID_pastel = :ID_pastel";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":ID_pastel", $id_pastel);
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
} else {
    http_response_code(400);
    echo json_encode(array("message" => "ID_pastel está vacío."));
}
?>
