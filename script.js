// Data awal petani (digunakan otomatis jika dibuka langsung tanpa server PHP/XAMPP)
let dataPetani = JSON.parse(localStorage.getItem('petani_girimekar')) || [
    { id: 1, id_petani: 'PTN-001', nama_petani: 'Asep Sunandar', alamat: 'Blok Pasir Wangi, Giri Mekar', luas_lahan: 2.50 },
    { id: 2, id_petani: 'PTN-002', nama_petani: 'Siti Aminah', alamat: 'Blok Cikawari, Giri Mekar', luas_lahan: 1.75 },
    { id: 3, id_petani: 'PTN-003', nama_petani: 'Dedi Mulyadi', alamat: 'Blok Batu Kuda, Giri Mekar', luas_lahan: 3.20 }
];

let chartLahanInstance = null;
let chartPanenInstance = null;
let useBackendPHP = false;

// Cek apakah berjalan di server PHP (XAMPP/Laragon)
async function cekKoneksiBackend() {
    try {
        const res = await fetch('api_petani.php');
        if (res.ok) {
            const json = await res.json();
            if (json.status === 'success') {
                useBackendPHP = true;
                dataPetani = json.data;
            }
        }
    } catch (e) {
        useBackendPHP = false; // Fallback ke penyimpanan browser (LocalStorage)
    }
    renderTabel(dataPetani);
    renderGrafik();
}

// Menampilkan pesan alert
function tampilkanPesan(pesan, tipe) {
    const alertBox = document.getElementById('alert-box');
    alertBox.textContent = pesan;
    alertBox.className = `alert ${tipe}`;
    setTimeout(() => {
        alertBox.className = 'alert hidden';
    }, 4000);
}

// Render tabel data petani
function renderTabel(listData) {
    const tbody = document.getElementById('tbody-petani');
    tbody.innerHTML = '';

    if (listData.length === 0) {
        tbody.innerHTML = `<tr><td colspan="6" style="text-align:center;">Data petani tidak ditemukan.</td></tr>`;
        return;
    }

    listData.forEach((item, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${index + 1}</td>
            <td><strong>${item.id_petani}</strong></td>
            <td>${item.nama_petani}</td>
            <td>${item.alamat || '-'}</td>
            <td>${parseFloat(item.luas_lahan || 0).toFixed(2)} Ha</td>
            <td>
                <button class="btn-hapus" onclick="hapusPetani(${item.id}, '${item.id_petani}')">Hapus</button>
            </td>
        `;
        tbody.appendChild(row);
    });
}

// Event Submit Form Tambah Petani
document.getElementById('form-petani').addEventListener('submit', async function (e) {
    e.preventDefault();

    const idPetani = document.getElementById('id_petani').value.trim();
    const namaPetani = document.getElementById('nama_petani').value.trim();
    const alamat = document.getElementById('alamat').value.trim();
    const luasLahan = parseFloat(document.getElementById('luas_lahan').value) || 0;

    // 3a. Validasi input nama petani dan ID petani tidak boleh kosong
    if (idPetani === '' || namaPetani === '') {
        tampilkanPesan('Gagal: NIK/ID Petani dan Nama Petani tidak boleh kosong!', 'error');
        return;
    }

    if (useBackendPHP) {
        // Simpan ke Database MySQL via PHP API
        const res = await fetch('api_petani.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id_petani: idPetani, nama_petani: namaPetani, alamat: alamat, luas_lahan: luasLahan })
        });
        const result = await res.json();
        if (result.status === 'success') {
            tampilkanPesan(result.message, 'success');
            this.reset();
            await cekKoneksiBackend();
        } else {
            tampilkanPesan(result.message, 'error');
        }
    } else {
        // Simpan secara dinamis ke DOM & LocalStorage
        const duplikat = dataPetani.some(p => p.id_petani.toLowerCase() === idPetani.toLowerCase());
        if (duplikat) {
            tampilkanPesan('Gagal: ID Petani sudah terdaftar!', 'error');
            return;
        }

        const petaniBaru = {
            id: Date.now(),
            id_petani: idPetani,
            nama_petani: namaPetani,
            alamat: alamat || 'Giri Mekar',
            luas_lahan: luasLahan
        };

        dataPetani.push(petaniBaru);
        localStorage.setItem('petani_girimekar', JSON.stringify(dataPetani));

        renderTabel(dataPetani);
        renderGrafik();
        tampilkanPesan('Data petani berhasil ditambahkan!', 'success');
        this.reset();
    }
});

// Fitur Pencarian Data Petani berdasarkan Nama
document.getElementById('cari-petani').addEventListener('input', async function () {
    const keyword = this.value.trim().toLowerCase();

    if (useBackendPHP) {
        const res = await fetch(`api_petani.php?search=${encodeURIComponent(keyword)}`);
        const json = await res.json();
        if (json.status === 'success') {
            renderTabel(json.data);
        }
    } else {
        const hasilFilter = dataPetani.filter(petani =>
            petani.nama_petani.toLowerCase().includes(keyword)
        );
        renderTabel(hasilFilter);
    }
});

// Fitur Hapus Data Petani (CRUD Delete)
async function hapusPetani(id, idPetani) {
    if (!confirm(`Hapus data petani ${idPetani}?`)) return;

    if (useBackendPHP) {
        const res = await fetch(`api_petani.php?id=${id}`, { method: 'DELETE' });
        const json = await res.json();
        tampilkanPesan(json.message, 'success');
        await cekKoneksiBackend();
    } else {
        dataPetani = dataPetani.filter(p => p.id !== id);
        localStorage.setItem('petani_girimekar', JSON.stringify(dataPetani));
        renderTabel(dataPetani);
        renderGrafik();
        tampilkanPesan('Data petani berhasil dihapus.', 'success');
    }
}

// Fitur Grafik Luas Lahan & Hasil Panen (Ketentuan 2e)
function renderGrafik() {
    const ctxLahan = document.getElementById('chartLahan').getContext('2d');
    const ctxPanen = document.getElementById('chartPanen').getContext('2d');

    const labelPetani = dataPetani.map(p => p.nama_petani);
    const nilaiLahan = dataPetani.map(p => parseFloat(p.luas_lahan));

    if (chartLahanInstance) chartLahanInstance.destroy();
    chartLahanInstance = new Chart(ctxLahan, {
        type: 'bar',
        data: {
            labels: labelPetani,
            datasets: [{
                label: 'Luas Lahan (Hektare)',
                data: nilaiLahan,
                backgroundColor: '#4a7c44',
                borderColor: '#2d4c2b',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: { y: { beginAtZero: true } }
        }
    });

    if (chartPanenInstance) chartPanenInstance.destroy();
    chartPanenInstance = new Chart(ctxPanen, {
        type: 'line',
        data: {
            labels: ['Juli 2026', 'Agustus 2026', 'September 2026', 'Oktober 2026'],
            datasets: [{
                label: 'Total Panen Kopi (Kg)',
                data: [380, 450.5, 310, 620.75],
                backgroundColor: 'rgba(109, 76, 65, 0.2)',
                borderColor: '#4e342e',
                borderWidth: 2,
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            scales: { y: { beginAtZero: true } }
        }
    });
}

// Jalankan saat halaman dimuat
window.addEventListener('DOMContentLoaded', cekKoneksiBackend);
