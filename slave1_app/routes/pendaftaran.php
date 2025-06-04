<?php
require_once './config/db.php';
require_once './controllers/PendaftaranController.php';

$request_method = $_SERVER["REQUEST_METHOD"];
$request_uri = $_SERVER["REQUEST_URI"];

if (strpos($request_uri, "/api/pendaftaran") !== false && $request_method === "POST") {
    PendaftaranController::simpan($conn);
} elseif (strpos($request_uri, "/api/antrian") !== false && $request_method === "GET") {
    PendaftaranController::daftarAntrian($conn);
} elseif (strpos($request_uri, "/api/sync") !== false && $request_method === "POST") {
    PendaftaranController::sync($conn);
} else {
    http_response_code(404);
    echo json_encode(['message' => 'Endpoint tidak ditemukan']);
}
?>
