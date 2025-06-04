<?php
class Pendaftaran {
    private $conn;
    private $table = "pendaftaran";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function tambah($data) {
        $query = "INSERT INTO {$this->table} (nik, nama, ttl, alamat, jenis_kelamin, tanggal_daftar, poli) 
                  VALUES (:nik, :nama, :ttl, :alamat, :jk, :tgl, :poli)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':nik' => $data['nik'],
            ':nama' => $data['nama'],
            ':ttl' => $data['ttl'],
            ':alamat' => $data['alamat'],
            ':jk' => $data['jenis_kelamin'],
            ':tgl' => date('Y-m-d'),
            ':poli' => $data['poli']
        ]);
    }

    public function getAll() {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} ORDER BY id_pendaftaran DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
