<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Petani Kopi Giri Mekar</title>
    <link rel="stylesheet" href="style.css">
    <!-- Chart.js untuk menampilkan grafik luas lahan dan data panen -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

    <!-- Header -->
    <header>
        <div class="header-container">
            <h1>Sistem Informasi Petani Kopi Giri Mekar</h1>
            <p>Manajemen Data Petani &amp; Hasil Panen Perkebunan Kopi</p>
        </div>
    </header>

    <!-- Menu Navigasi -->
    <nav>
        <ul>
            <li><a href="#beranda">Beranda</a></li>
            <li><a href="#data-petani">Data Petani</a></li>
            <li><a href="#data-panen">Data Panen</a></li>
            <li><a href="#kontak">Kontak</a></li>
        </ul>
    </nav>

    <!-- Konten Utama -->
    <main>
        <!-- Section Beranda & Statistik -->
        <section id="beranda" class="card">
            <h2>Selamat Datang di Portal Kelompok Tani Giri Mekar Senang</h2>
            <p>Sistem ini digunakan untuk mendata anggota petani kopi, luas lahan garapan, serta memantau produktivitas panen kopi di kawasan Giri Mekar.</p>
            
            <!-- Grafik Luas Lahan & Hasil Panen -->
            <div class="charts-grid">
                <div class="chart-box">
                    <h3>Grafik Luas Lahan per Petani (Hektare)</h3>
                    <canvas id="chartLahan"></canvas>
                </div>
                <div class="chart-box">
                    <h3>Grafik Hasil Panen Kopi Bulanan (Kg)</h3>
                    <canvas id="chartPanen"></canvas>
                </div>
            </div>
        </section>

        <!-- Section Data Petani (Form Input & Tabel) -->
        <section id="data-petani" class="card">
            <h2>Manajemen Data Petani</h2>

            <!-- Notifikasi Pesan -->
            <div id="alert-box" class="alert hidden"></div>

            <!-- Form Input Data Petani -->
            <form id="form-petani" class="form-grid">
                <div class="form-group">
                    <label for="id_petani">NIK atau ID Petani *</label>
                    <input type="text" id="id_petani" name="id_petani" placeholder="Contoh: PTN-004">
                </div>
                <div class="form-group">
                    <label for="nama_petani">Nama Petani *</label>
                    <input type="text" id="nama_petani" name="nama_petani" placeholder="Masukkan nama lengkap petani">
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <input type="text" id="alamat" name="alamat" placeholder="Contoh: Blok Pasir Wangi, Giri Mekar">
                </div>
                <div class="form-group">
                    <label for="luas_lahan">Luas Lahan (hektare)</label>
                    <input type="number" id="luas_lahan" name="luas_lahan" step="0.01" min="0" placeholder="Contoh: 1.5">
                </div>
                <div class="form-actions">
                    <button type="submit" id="btn-simpan" class="btn-primary">Simpan</button>
                </div>
            </form>

            <hr class="divider">

            <!-- Fitur Pencarian Data Petani -->
            <div class="search-bar">
                <label for="cari-petani"><strong>Cari Petani:</strong></label>
                <input type="text" id="cari-petani" placeholder="Ketik nama petani untuk mencari...">
            </div>

            <!-- Tabel Data Petani -->
            <div class="table-responsive">
                <table id="tabel-petani">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Petani</th>
                            <th>Nama Petani</th>
                            <th>Alamat</th>
                            <th>Luas Lahan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-petani">
                        <!-- Data diisi secara dinamis oleh JavaScript -->
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Section Data Panen -->
        <section id="data-panen" class="card">
            <h2>Ringkasan Data Hasil Panen</h2>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Petani</th>
                            <th>Nama Petani</th>
                            <th>Jenis Kopi</th>
                            <th>Tanggal Panen</th>
                            <th>Jumlah Panen (Kg)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>PTN-001</td>
                            <td>Asep Sunandar</td>
                            <td>Arabika</td>
                            <td>15 Agustus 2026</td>
                            <td>450.50 Kg</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>PTN-002</td>
                            <td>Siti Aminah</td>
                            <td>Arabika</td>
                            <td>10 September 2026</td>
                            <td>310.00 Kg</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>PTN-003</td>
                            <td>Dedi Mulyadi</td>
                            <td>Robusta</td>
                            <td>05 Oktober 2026</td>
                            <td>620.75 Kg</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <!-- Footer / Kontak -->
    <footer id="kontak">
        <div class="footer-content">
            <h3>Kontak Sekretariat Kelompok Petani Giri Mekar Senang</h3>
            <p>Desa Giri Mekar, Kec. Cilengkrang, Kab. Bandung | Email: info@kopigirimekar.id | Telp: 0812-3456-7890</p>
            <p class="copyright">&copy; 2026 Sistem Informasi Petani Kopi Giri Mekar</p>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html>
