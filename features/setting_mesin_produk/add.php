<?php
if (isset($_POST['simpan'])) {
    $mesin_id = $_POST['mesin_id'];
    $produk_gudang = explode('|', $_POST['produk_gudang']); // Format: "produk_id|gudang_id"
    $produk_id = $produk_gudang[0];
    $gudang_id = $produk_gudang[1];
    $stock = $_POST['stock'];

    $query = "INSERT INTO setting_mesin_produk (mesin_id, gudang_id, produk_id, stock)
              VALUES ('$mesin_id', '$gudang_id', '$produk_id', '$stock')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script>alert('✅ Data berhasil disimpan.'); window.location.href='app?page=setting_mesin_produk';</script>";
    } else {
        echo "<script>alert('❌ Data gagal disimpan: " . mysqli_error($conn) . "');</script>";
    }
    }

// Ambil data mesin
$mesin = mysqli_fetch_all(mysqli_query($conn, "SELECT * FROM mesin"), MYSQLI_ASSOC);

// Ambil produk + gudang (gabung)
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
?>

<div class="container py-4">
    <div class="card shadow-sm border-0 rounded-4 mx-auto" style="max-width: 70rem;">
        <div class="card-header text-white" style="background-color: #3fc1d8;">
            <h5 class="mb-0"><i class="fa-solid fa-gears me-2"></i>Setting Mesin Produk</h5>
        </div>

        <div class="card-body bg-light">
            <form action="" method="POST">
                <!-- PILIH MESIN -->
                <div class="mb-3">
                    <label for="mesin_id" class="form-label">Nama Mesin</label>
                    <select class="form-select shadow-sm" id="mesin_id" name="mesin_id" required>
                        <option value="">Pilih mesin</option>
                        <?php foreach ($mesin as $m) : ?>
                            <option value="<?= $m['id'] ?>"><?= htmlspecialchars($m['nama']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- PILIH PRODUK + GUDANG -->
                <div class="mb-3">
                    <label for="produk_gudang" class="form-label">Produk (dari Gudang)</label>
                    <select class="form-select shadow-sm" id="produk_gudang" name="produk_gudang" required>
                        <option value="">Pilih produk</option>
                        <?php foreach ($produk_gudang as $pg) : ?>
                            <option value="<?= $pg['produk_id'] . '|' . $pg['gudang_id'] ?>">
                                <?= htmlspecialchars($pg['nama_produk']) ?> |
                                Rp<?= number_format($pg['harga_produk'], 0, ',', '.') ?> |
                                Stok: <?= $pg['jumlah_stock'] ?> |
                                Exp: <?= $pg['expire'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- INPUT STOCK -->
                <div class="mb-3">
                    <label for="stock" class="form-label">Jumlah Stock</label>
                    <input type="number" class="form-control shadow-sm" name="stock" id="stock" placeholder="Masukkan jumlah stock" min="1" required>
                </div>

                <!-- BUTTON -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <a href="app?page=setting_mesin_produk&view=index" class="btn btn-outline-secondary shadow-sm">
                        <i class="fa-solid fa-left-long me-1"></i> Kembali
                    </a>
                    <button type="submit" name="simpan" class="btn btn-primary shadow-sm" style="box-shadow: 0 2px 4px rgba(0, 123, 255, 0.4);">
                        <i class="fa-solid fa-download me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
