<?php
class Antrian {
    private $conn;
    private $table = "antrian";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function tambah($id_pendaftaran, $nomor) {
        $query = "INSERT INTO {$this->table} (id_pendaftaran, nomor_antrian, tanggal_antrian, status)
                  VALUES (:id_pendaftaran, :nomor, CURDATE(), 'menunggu')";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':id_pendaftaran' => $id_pendaftaran,
            ':nomor' => $nomor
        ]);
    }

    public function getNomorHariIni() {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM {$this->table} WHERE tanggal_antrian = CURDATE()");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] + 1;
    }

    public function getAll() {
        $stmt = $this->conn->prepare("SELECT a.*, p.nama, p.poli FROM antrian a JOIN pendaftaran p ON a.id_pendaftaran = p.id_pendaftaran ORDER BY a.id_antrian DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
