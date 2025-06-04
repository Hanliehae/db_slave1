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

    public static function daftarAntrian($conn) {
        $antrian = new Antrian($conn);
        $data = $antrian->getAll();
        echo json_encode($data);
    }

    public static function sync($conn) {
        // Ambil data antrian hari ini
        $antrian = new Antrian($conn);
        $data = $antrian->getAll();

        // Kirim data ke server master menggunakan cURL
        $curl = curl_init('http://localhost/master_app/api/receive.php');
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($httpCode == 200) {
            echo json_encode(['message' => 'Sinkronisasi berhasil']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Gagal sinkron ke master']);
        }
    }
}
?>

