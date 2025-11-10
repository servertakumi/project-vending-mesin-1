<?php


// Fungsi untuk membuat kode produk otomatis (A1, A2, A3, dst)
function generateKodeProduk($conn) {
    $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM produk");
    $data = mysqli_fetch_assoc($result);
    $total = (int)$data['total'];

    $huruf = chr(65 + floor($total / 3)); // A, B, C, ...
    $angka = ($total % 3) + 1;            // 1, 2, 3
    return $huruf . $angka;
}

if (isset($_POST['simpan'])) {
    $gambar = trim($_POST['gambar']);
    $gudang_id = $_POST['gudang_id'];
    $harga_produk = $_POST['harga_produk'];
    $deskripsi_produk = $_POST['deskripsi_produk'];
    $expire = $_POST['expire'];

    // Generate kode otomatis
    $code = generateKodeProduk($conn);

    // Simpan ke database
    $query = "INSERT INTO produk (code, gambar, gudang_id, harga_produk, deskripsi_produk, expire)
              VALUES ('$code', '$gambar', '$gudang_id', '$harga_produk', '$deskripsi_produk', '$expire')";
    
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "
        <script>
            alert('✅ Data produk berhasil disimpan! Kode produk: $code');
            window.location.href = 'app?page=produk';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('❌ Data gagal disimpan: " . mysqli_error($conn) . "');
        </script>
        ";
    }
}

// Ambil data gudang untuk dropdown
$data = mysqli_query($conn, "SELECT * FROM gudang");
$gudang = mysqli_fetch_all($data, MYSQLI_ASSOC);
?>

<div class="container">
    <div class="shadow p-3 mb-5 bg-white rounded pt-4">
        <div class="card-body" style="width: auto;">
            <div class="row">
                <div class="col-md-12">
                    <h6 class="text-center">welcome to product</h6>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center mt-5">
    <div class="shadow-lg p-3 mb-5 bg-body-tertiary rounded">
        <div class="card" style="width: 70rem">
            <div class="card-header" style="background-color: #3fc1d8;">
                <h5 style="color:white;">Form Tambah Produk</h5>
            </div>

            <div class="card-body">
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="gambar" class="form-label">Link Gambar Produk</label>
                        <input type="text" class="form-control" id="gambar" name="gambar" placeholder="Masukkan URL gambar">
                    </div>

                    <div class="mb-3">
                        <label for="gudang_id" class="form-label">Pilih Produk Gudang</label>
                        <select class="form-select" id="gudang_id" name="gudang_id" required>
                            <option value="">Pilih produk</option>
                            <?php foreach ($gudang as $g) : ?>
                                <option value="<?= $g['id'] ?>">
                                    <?= $g['nama_produk'] ?> - <?= $g['keterangan_produk'] ?> - stok <?= $g['jumlah_stock'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="harga_produk" class="form-label">Harga Produk</label>
                        <input type="number" class="form-control" name="harga_produk" id="harga_produk" placeholder="Masukkan harga produk">
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi_produk" class="form-label">Deskripsi Produk</label>
                        <input type="text" class="form-control" name="deskripsi_produk" id="deskripsi_produk" placeholder="Masukkan deskripsi singkat">
                    </div>

                    <div class="mb-3">
                        <label for="expire" class="form-label">Tanggal Kadaluarsa</label>
                        <input type="date" class="form-control" name="expire" id="expire">
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="app?page=produk&view=index" class="me-3"><i class="fa-solid fa-left-long"></i> Kembali</a>
                        <button type="submit" name="simpan" class="btn btn-primary"><i class="fa-solid fa-download"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
