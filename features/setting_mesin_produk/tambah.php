<?php
include_once 'config/db.php';

// ambil id mesin dari parameter
$mesin_id = isset($_GET['mesin_id']) ? $_GET['mesin_id'] : '';

if (!$mesin_id) {
    echo "<script>alert('❌ Mesin tidak ditemukan!'); window.location.href='app?page=setting_mesin_produk&view=index';</script>";
    exit;
}

// ambil data produk dan gudang
$produk_gudang = mysqli_fetch_all(mysqli_query($conn, "
    SELECT 
        produk.id AS produk_id,
        gudang.id AS gudang_id,
        gudang.nama_produk,
        produk.harga_produk,
        produk.deskripsi_produk,
        produk.expire,
        gudang.jumlah_stock
    FROM produk
    JOIN gudang ON produk.gudang_id = gudang.id
"), MYSQLI_ASSOC);

// simpan data jika form disubmit
if (isset($_POST['simpan'])) {
    $mesin_id = $_POST['mesin_id'];
    $produk_gudang_data = explode('|', $_POST['produk_gudang']); // pindahkan ke sini
    $produk_id = $produk_gudang_data[0];
    $gudang_id = $produk_gudang_data[1];
    $stock = (int) $_POST['stock'];

    // cek apakah produk sudah ada di mesin ini
    $cek = mysqli_query($conn, "
        SELECT * FROM setting_mesin_produk 
        WHERE mesin_id='$mesin_id' AND produk_id='$produk_id'
    ");

    if (mysqli_num_rows($cek) > 0) {
        // update stok
        $update = mysqli_query($conn, "
            UPDATE setting_mesin_produk 
            SET stock = stock + $stock 
            WHERE mesin_id='$mesin_id' AND produk_id='$produk_id'
        ");

        if ($update) {
            echo "<script>
                alert('✅ Stok produk berhasil diperbarui di mesin ini!');
                window.location.href='app?page=setting_mesin_produk&view=index';
            </script>";
            exit;
        } else {
            echo "<div class='alert alert-danger'>Gagal update stok: " . mysqli_error($conn) . "</div>";
        }
    } else {
        // tambah baru
        $insert = mysqli_query($conn, "
            INSERT INTO setting_mesin_produk (mesin_id, produk_id, stock)
            VALUES ('$mesin_id', '$produk_id', '$stock')
        ");

        if ($insert) {
            echo "<script>
                alert('✅ Produk berhasil ditambahkan ke mesin!');
                window.location.href='app?page=setting_mesin_produk&view=index';
            </script>";
            exit;
        } else {
            echo "<div class='alert alert-danger'>Gagal menambah produk: " . mysqli_error($conn) . "</div>";
        }
    }
}

// ambil nama mesin
$mesin = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM mesin WHERE id='$mesin_id'"));
?>

<div class="container">
    <div class="shadow p-3 mb-5 bg-white rounded pt-4">
        <div class="card-body" style="width: auto;">
            <div class="row">
                <div class="col-md-12">
                    <h6 class="text-center">welcome to storage</h6>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container mt-5">
    <div class="card shadow border-0 rounded-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-light">Tambah Produk ke Mesin: <?= htmlspecialchars($mesin['nama']) ?></h5>
            <a href="app?page=setting_mesin_produk&view=index" class="btn btn-light btn-sm">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <form method="POST">
                <input type="hidden" name="mesin_id" value="<?= $mesin_id ?>">

                <div class="mb-3">
                    <label for="produk_gudang" class="form-label fw-semibold">Pilih Produk</label>
                    <select name="produk_gudang" id="produk_gudang" name="produk_gudang" class="form-select" required>
                        <option value="">-- Pilih Produk --</option>
                        <?php foreach ($produk_gudang as $pg): ?>
                            <option value="<?= $pg['produk_id'] . '|' . $pg['gudang_id'] ?>">
                                <?= htmlspecialchars($pg['nama_produk']) ?> | <?= htmlspecialchars($pg['deskripsi_produk']) ?>
                                - Rp<?= number_format($pg['harga_produk'], 0, ',', '.') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Jumlah Stok</label>
                    <input type="number" name="stock" class="form-control" placeholder="Masukkan stok" required min="1">
                </div>

                <div class="text-end">
                    <button type="submit" name="simpan" class="btn btn-success shadow-sm">
                        <i class="fa-solid fa-plus"></i> Tambah / Update Produk
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>