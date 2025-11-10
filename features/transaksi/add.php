<?php
include 'config/db.php';

// Ambil data mesin, gudang, produk
$mesin = mysqli_fetch_all(mysqli_query($conn, "SELECT * FROM mesin"), MYSQLI_ASSOC);
$gudang = mysqli_fetch_all(mysqli_query($conn, "SELECT * FROM gudang"), MYSQLI_ASSOC);
$produk = mysqli_fetch_all(mysqli_query($conn, "SELECT * FROM produk"), MYSQLI_ASSOC);

// Simpan transaksi
if (isset($_POST['simpan'])) {
    $mesin_id = $_POST['mesin_id'];
    $produk_id = $_POST['produk_id'];
    $qty = $_POST['qty'];
    $updated_at = date('Y-m-d H:i:s');

    // Ambil data produk dan stok
    $produk_data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM produk WHERE id = '$produk_id'"));
    if (!$produk_data) {
        echo "<script>alert('Produk tidak ditemukan!');</script>";
        exit;
    }

    $harga = $produk_data['harga_produk'];
    $stok = $produk_data['stok'] ?? 0; // pastikan kolom stok ada di tabel produk
    $total_harga = $harga * $qty;

    if ($qty > $stok) {
        echo "<script>alert('Stok tidak cukup!');</script>";
        exit;
    }

    // Insert transaksi
    $query = "INSERT INTO transaksi (mesin_id, produk_id, qty, total_harga, status, updated_at)
              VALUES ('$mesin_id', '$produk_id', '$qty', '$total_harga', 'berhasil', '$updated_at')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Kurangi stok produk
        $new_stok = $stok - $qty;
        mysqli_query($conn, "UPDATE produk SET stok='$new_stok' WHERE id='$produk_id'");
        echo "<script>alert('Transaksi tersimpan dengan sukses');window.location.href='app?page=transaksi';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan transaksi: " . mysqli_error($conn) . "');</script>";
    }
}

// Ambil semua transaksi terbaru
$transaksi = mysqli_query($conn, "
    SELECT t.*, m.nama AS nama_mesin, p.nama_produk, p.harga_produk
    FROM transaksi t
    JOIN mesin m ON t.mesin_id = m.id
    JOIN produk p ON t.produk_id = p.id
    ORDER BY t.updated_at DESC
");

?>

<div class="container mt-4">
    <div class="shadow p-3 mb-5 bg-white rounded">
        <h6 class="text-center">Welcome to Payment</h6>
    </div>

    <!-- Form Transaksi -->
    <div class="d-flex justify-content-center mt-5">
        <div class="shadow-lg p-3 mb-5 bg-body-tertiary rounded w-100">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5>Transaksi</h5>
                </div>

                <div class="card-body">
                    <form action="" method="POST" id="formTransaksi">

                        <label class="input-group-text mt-2">Nama Mesin</label>
                        <select class="form-select" id="mesin_id" name="mesin_id" required>
                            <option selected disabled>Pilih mesin</option>
                            <?php foreach ($mesin as $m) : ?>
                                <option value="<?= $m['id'] ?>"><?= $m['nama'] ?></option>
                            <?php endforeach; ?>
                        </select>

                        <label class="input-group-text mt-3">Nama Produk</label>
                        <select class="form-select" id="produk_id" name="produk_id" required>
                            <option selected disabled>Pilih produk</option>
                            <?php foreach ($produk as $p) : ?>
                                <option value="<?= $p['id'] ?>" data-harga="<?= $p['harga_produk'] ?>" data-stok="<?= $p['stok'] ?>">
                                    <?= $p['nama_produk'] ?> - Rp <?= number_format($p['harga_produk']) ?> (Stok: <?= $p['stok'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <div class="mb-3 mt-3">
                            <label for="qty" class="form-label">Qty</label>
                            <input class="form-control" type="number" name="qty" id="qty" min="1" required placeholder="Masukkan jumlah pembelian">
                        </div>

                        <div class="mb-3">
                            <label for="total_harga" class="form-label">Total Harga</label>
                            <input class="form-control" type="number" name="total_harga" id="total_harga" readonly placeholder="Total harga otomatis">
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="app?page=transaksi&view=index" class="me-3"><i class="fa-solid fa-left-long"></i> Kembali</a>
                            <button type="submit" name="simpan" class="btn btn-primary">
                                <i class="fa-solid fa-download"></i> Simpan
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Transaksi Terbaru -->
    <div class="shadow p-3 mb-5 bg-white rounded">
        <h5>Daftar Transaksi Terbaru</h5>
        <table class="table table-bordered mt-3">
            <thead class="table-light">
                <tr>
                    <th>Tanggal</th>
                    <th>Mesin</th>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Qty</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transaksi as $t) : ?>
                    <tr>
                        <td><?= $t['updated_at'] ?></td>
                        <td><?= $t['nama_mesin'] ?></td>
                        <td><?= $t['nama_produk'] ?></td>
                        <td>Rp <?= number_format($t['harga_produk']) ?></td>
                        <td><?= $t['qty'] ?></td>
                        <td>Rp <?= number_format($t['total_harga']) ?></td>
                        <td><?= $t['status'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    // Hitung total harga otomatis dan validasi stok
    const produkSelect = document.getElementById('produk_id');
    const qtyInput = document.getElementById('qty');
    const totalHargaInput = document.getElementById('total_harga');

    function updateTotal() {
        const harga = parseInt(produkSelect.selectedOptions[0]?.dataset.harga || 0);
        const stok = parseInt(produkSelect.selectedOptions[0]?.dataset.stok || 0);
        const qty = parseInt(qtyInput.value || 0);

        if (qty > stok) {
            alert('Qty melebihi stok!');
            qtyInput.value = stok;
        }

        totalHargaInput.value = harga * qty;
    }

    produkSelect.addEventListener('change', updateTotal);
    qtyInput.addEventListener('input', updateTotal);
</script>