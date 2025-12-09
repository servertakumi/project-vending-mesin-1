<?php
ob_start(); // mencegah header error

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Ambil data mesin yang dipilih
$mesin_data = mysqli_query($conn, "SELECT * FROM mesin WHERE id = $id");
$mesin = mysqli_fetch_assoc($mesin_data);

if (!$mesin) {
    header("Location: app?page=mesin");
    exit;
}

if (isset($_POST['simpan'])) {

    if (!isset($_POST['mesin_id']) || $_POST['mesin_id'] == "") {
        echo "<script>alert('Mesin tidak ditemukan');</script>";
        exit;
    }

    $mesin_id = intval($_POST['mesin_id']);
    $produk_gudang = explode('|', $_POST['produk_gudang']);
    $produk_id = $produk_gudang[0];
    $gudang_id = $produk_gudang[1];
    $stock = intval($_POST['stock']);

    $query = "INSERT INTO setting_mesin_produk (mesin_id, gudang_id, produk_id, stock)
              VALUES ('$mesin_id', '$gudang_id', '$produk_id', '$stock')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script>
                alert('Data berhasil disimpan');
                window.location.href='app?page=mesin&view=display&id=$mesin_id';
              </script>";
        exit;
    } else {
        echo "<script>alert('Data gagal disimpan: " . mysqli_error($conn) . "');</script>";
    }
}

// Ambil produk + gudang
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

<div class="container">
    <div class="shadow p-3 mb-5 bg-white rounded pt-4">
        <div class="card-body" style="width: auto;">
            <div class="row">
                <div class="col-md-12">
                    <h6 class="text-center">welcome to machine</h6>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container py-4">
    <div class="card shadow-sm border-0 rounded-4 mx-auto" style="max-width: 70rem;">
        <div class="card-header text-white" style="background-color: #3fc1d8;">
            <h5 style="color:white;"><?= htmlspecialchars($mesin['nama']) ?></h5>
        </div>

        <div class="card-body bg-light">
            <form action="" method="POST">

                <!-- HIDDEN MESIN ID (WAJIB ADA) -->
                <input type="hidden" name="mesin_id" value="<?= $mesin['id'] ?>">

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

                <div class="mb-3">
                    <label for="stock" class="form-label">Jumlah Stock</label>
                    <input type="number" class="form-control shadow-sm" name="stock" id="stock" min="1" required>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="app?page=mesin&view=display&id=<?= $mesin['id'] ?>" class="btn btn-outline-secondary">
                        <i class="fa-solid fa-left-long"></i> Kembali
                    </a>
                    <button type="submit" name="simpan" class="btn btn-primary">
                        <i class="fa-solid fa-download"></i> Simpan
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>