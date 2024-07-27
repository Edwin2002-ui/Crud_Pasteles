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
    !empty($data->Nombre) &&
    !empty($data->Descripcion) &&
    !empty($data->Preparado_por) &&
    !empty($data->Fecha_creacion) &&
    !empty($data->Fecha_Vencimiento)
) {
    // Insertar el pastel
    $query = "INSERT INTO Pastel SET Nombre=:Nombre, Descripcion=:Descripcion, Preparado_por=:Preparado_por, Fecha_creacion=:Fecha_creacion, Fecha_Vencimiento=:Fecha_Vencimiento";
    $stmt = $db->prepare($query);

    $stmt->bindParam(":Nombre", $data->Nombre);
    $stmt->bindParam(":Descripcion", $data->Descripcion);
    $stmt->bindParam(":Preparado_por", $data->Preparado_por);
    $stmt->bindParam(":Fecha_creacion", $data->Fecha_creacion);
    $stmt->bindParam(":Fecha_Vencimiento", $data->Fecha_Vencimiento);

    if ($stmt->execute()) {
        $last_id = $db->lastInsertId(); // Obtener el ID del pastel recién creado

        // Insertar los ingredientes
        if (!empty($data->ingredientes)) {
            foreach ($data->ingredientes as $ID_ingrediente) {
                $query = "INSERT INTO Pastel_Ingredientes SET ID_pastel=:ID_pastel, ID_ingrediente=:ID_ingrediente";
                $stmt = $db->prepare($query);

                $stmt->bindParam(":ID_pastel", $last_id);
                $stmt->bindParam(":ID_ingrediente", $ID_ingrediente);

                if (!$stmt->execute()) {
                    http_response_code(503);
                    echo json_encode(array("message" => "No se pudo añadir el ingrediente."));
                    exit();
                }
            }
        }

        http_response_code(201);
        echo json_encode(array("message" => "Pastel creado exitosamente."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "No se pudo crear el pastel."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Datos incompletos."));
}
?>
