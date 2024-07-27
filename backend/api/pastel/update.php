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
    !empty($data->ID_pastel) &&
    !empty($data->Nombre) &&
    !empty($data->Descripcion) &&
    !empty($data->Preparado_por) &&
    !empty($data->Fecha_creacion) &&
    !empty($data->Fecha_Vencimiento)
) {
    $query = "UPDATE Pastel SET Nombre=:Nombre, Descripcion=:Descripcion, Preparado_por=:Preparado_por, Fecha_creacion=:Fecha_creacion, Fecha_Vencimiento=:Fecha_Vencimiento WHERE ID_pastel=:ID_pastel";
    $stmt = $db->prepare($query);

    $stmt->bindParam(":ID_pastel", $data->ID_pastel);
    $stmt->bindParam(":Nombre", $data->Nombre);
    $stmt->bindParam(":Descripcion", $data->Descripcion);
    $stmt->bindParam(":Preparado_por", $data->Preparado_por);
    $stmt->bindParam(":Fecha_creacion", $data->Fecha_creacion);
    $stmt->bindParam(":Fecha_Vencimiento", $data->Fecha_Vencimiento);

    if ($stmt->execute()) {
        // Limpiar ingredientes anteriores
        $query = "DELETE FROM Pastel_Ingredientes WHERE ID_pastel=:ID_pastel";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":ID_pastel", $data->ID_pastel);
        $stmt->execute();

        // Insertar ingredientes nuevos
        if (!empty($data->ingredientes)) {
            foreach ($data->ingredientes as $ingrediente) {
                $query = "INSERT INTO Pastel_Ingredientes SET ID_pastel=:ID_pastel, ID_ingrediente=:ID_ingrediente";
                $stmt = $db->prepare($query);

                $stmt->bindParam(":ID_pastel", $data->ID_pastel);
                $stmt->bindParam(":ID_ingrediente", $ingrediente);

                if (!$stmt->execute()) {
                    http_response_code(503);
                    echo json_encode(array("message" => "No se pudo añadir el ingrediente."));
                    exit();
                }
            }
        }

        http_response_code(200);
        echo json_encode(array("message" => "Pastel actualizado."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "No se pudo actualizar el pastel."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Datos incompletos."));
}
?>
