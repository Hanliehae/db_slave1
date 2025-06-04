<?php
require_once './config/db.php';
require_once './controllers/PendaftaranController.php';

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if ($uri == '/api/pendaftaran' && $method == 'POST') {
    PendaftaranController::simpan($conn);
} elseif ($uri == '/api/antrian' && $method == 'GET') {
    PendaftaranController::antrian($conn);
} else {
    http_response_code(404);
    echo json_encode(['message' => 'Endpoint tidak ditemukan']);
}
?>
