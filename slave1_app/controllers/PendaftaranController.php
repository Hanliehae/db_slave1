<?php
require_once './models/Pendaftaran.php';
require_once './models/Antrian.php';

class PendaftaranController {
    public static function simpan($conn) {
        $data = json_decode(file_get_contents("php://input"), true);

        $pendaftaran = new Pendaftaran($conn);
        $antrian = new Antrian($conn);

        if ($pendaftaran->tambah($data)) {
            $id = $conn->lastInsertId();
            $nomor = $antrian->getNomorHariIni();
            $antrian->tambah($id, $nomor);
            echo json_encode(['message' => 'Pendaftaran berhasil', 'nomor_antrian' => $nomor]);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Gagal mendaftar']);
        }
    }

    public static function antrian($conn) {
        $antrian = new Antrian($conn);
        echo json_encode($antrian->getAll());
    }
}
?>
