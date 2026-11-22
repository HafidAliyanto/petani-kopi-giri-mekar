<?php
header("Content-Type: application/json");
include 'koneksi.php';

$method = $_SERVER['REQUEST_METHOD'];

// READ & SEARCH
if ($method === 'GET') {
    $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
    if ($search !== '') {
        $sql = "SELECT * FROM petani WHERE nama_petani LIKE '%$search%' ORDER BY id DESC";
    } else {
        $sql = "SELECT * FROM petani ORDER BY id DESC";
    }
    $result = mysqli_query($conn, $sql);
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    echo json_encode(["status" => "success", "data" => $data]);
}

// CREATE
elseif ($method === 'POST') {
    $input = json_decode(file_get_contents("php://input"), true);
    $id_petani   = mysqli_real_escape_string($conn, trim($input['id_petani'] ?? ''));
    $nama_petani = mysqli_real_escape_string($conn, trim($input['nama_petani'] ?? ''));
    $alamat      = mysqli_real_escape_string($conn, trim($input['alamat'] ?? ''));
    $luas_lahan  = floatval($input['luas_lahan'] ?? 0);

    if (empty($id_petani) || empty($nama_petani)) {
        echo json_encode(["status" => "error", "message" => "ID Petani dan Nama Petani wajib diisi!"]);
        exit;
    }

    $sql = "INSERT INTO petani (id_petani, nama_petani, alamat, luas_lahan) 
            VALUES ('$id_petani', '$nama_petani', '$alamat', '$luas_lahan')";
    
    if (mysqli_query($conn, $sql)) {
        echo json_encode(["status" => "success", "message" => "Data petani berhasil ditambahkan ke database!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Gagal menyimpan: " . mysqli_error($conn)]);
    }
}

// DELETE
elseif ($method === 'DELETE') {
    $id = intval($_GET['id'] ?? 0);
    if ($id > 0) {
        $sql = "DELETE FROM petani WHERE id = $id";
        if (mysqli_query($conn, $sql)) {
            echo json_encode(["status" => "success", "message" => "Data berhasil dihapus!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Gagal menghapus data."]);
        }
    }
}
?>
