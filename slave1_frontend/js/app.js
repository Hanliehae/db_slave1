const form = document.getElementById('formPendaftaran');
const tabelBody = document.querySelector('#tabelAntrian tbody');
const btnSync = document.getElementById('btnSync');

const API_BASE = "http://localhost/slave1_app";

function fetchAntrian() {
    fetch(`${API_BASE}/api/antrian`)
    .then(res => res.json())
    .then(data => {
        tabelBody.innerHTML = '';
        data.forEach(item => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${item.nomor_antrian}</td>
                <td>${item.nama}</td>
                <td>${item.poli}</td>
                <td>${item.status}</td>
            `;
            tabelBody.appendChild(tr);
        });
    });
}

form.addEventListener('submit', function(e) {
    e.preventDefault();

    const data = {
        nik: form.nik.value,
        nama: form.nama.value,
        ttl: form.ttl.value,
        alamat: form.alamat.value,
        jenis_kelamin: form.jenis_kelamin.value,
        poli: form.poli.value
    };

    fetch(`${API_BASE}/api/pendaftaran`, {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(resp => {
        alert(resp.message + (resp.nomor_antrian ? " Nomor antrian Anda: " + resp.nomor_antrian : ""));
        form.reset();
        fetchAntrian();
    })
    .catch(() => alert("Gagal mendaftar"));
});

btnSync.addEventListener('click', function() {
    fetch(`${API_BASE}/api/sync`, {
        method: 'POST'
    })
    .then(res => res.json())
    .then(resp => alert(resp.message))
    .catch(() => alert("Sinkron gagal"));
});

// Load antrian saat halaman pertama dibuka
fetchAntrian();
