<?php
include 'config/db.php';

// Ambil semua mesin
$mesin_result = mysqli_query($conn, "SELECT * FROM mesin");
if (!$mesin_result) die("Query mesin gagal: " . mysqli_error($conn));
$mesins = mysqli_fetch_all($mesin_result, MYSQLI_ASSOC);
if (count($mesins) == 0) die("Belum ada mesin tersedia");

// Pilih mesin default
$selected_mesin_id = intval($_GET['mesin_id'] ?? $mesins[0]['id']);

// Ambil produk sesuai mesin terpilih
$produk_sql = "
    SELECT 
        smp.id AS smp_id,
        smp.stock,
        p.id AS produk_id,
        p.gudang_id,
        p.gambar,
        p.harga_produk,
        g.nama_produk,
        m.id AS mesin_id,
        m.nama AS nama_mesin
    FROM setting_mesin_produk smp
    JOIN produk p ON smp.produk_id = p.id
    JOIN gudang g ON p.gudang_id = g.id
    JOIN mesin m ON smp.mesin_id = m.id
    WHERE smp.mesin_id = '$selected_mesin_id'
";

$produk_result = mysqli_query($conn, $produk_sql);
if (!$produk_result) die("Query produk gagal: " . mysqli_error($conn));
$produk_tersedia = mysqli_fetch_all($produk_result, MYSQLI_ASSOC);

// Generate kode produk otomatis (A1, A2, A3, dst)
foreach ($produk_tersedia as $index => $p) {
    $produk_tersedia[$index]['code'] = chr(65 + floor($index / 3)) . (($index % 3) + 1);
}

// Proses beli
$message = "";
if (isset($_POST['buy'])) {
    $code = strtoupper(trim($_POST['code']));
    $produk_dipilih = null;

    foreach ($produk_tersedia as $p) {
        if ($p['code'] === $code) {
            $produk_dipilih = $p;
            break;
        }
    }

    if ($produk_dipilih) {
        $smp_id = $produk_dipilih['smp_id'];
        $produk_id = $produk_dipilih['produk_id'];
        $gudang_id = $produk_dipilih['gudang_id'];
        $mesin_id = $produk_dipilih['mesin_id'];
        $harga = $produk_dipilih['harga_produk'];
        $qty = 1;
        $total = $harga * $qty;

        if ($produk_dipilih['stock'] <= 0) {
            $status = "Gagal: Produk Habis";
            $message = "❌ Stok untuk <strong>{$produk_dipilih['nama_produk']}</strong> sudah habis.";

            mysqli_query($conn, "
                INSERT INTO transaksi (produk_id, gudang_id, mesin_id, qty, total_harga, status, created_at)
                VALUES ('$produk_id', '$gudang_id', '$mesin_id', '$qty', '$total', '$status', NOW())
            ");
        } else {
            $status = "Sukses";

            mysqli_query($conn, "
                INSERT INTO transaksi (produk_id, gudang_id, mesin_id, qty, total_harga, status, created_at)
                VALUES ('$produk_id', '$gudang_id', '$mesin_id', '$qty', '$total', '$status', NOW())
            ");

            // Kurangi stok di setting_mesin_produk
            mysqli_query($conn, "
                UPDATE setting_mesin_produk 
                SET stock = stock - 1 
                WHERE id = '$smp_id' AND mesin_id = '$mesin_id'
            ");

            $message = "🎉 Anda membeli <strong>{$produk_dipilih['nama_produk']}</strong> seharga Rp " . number_format($harga, 0, ',', '.') . "<br><span class='text-success'>Transaksi berhasil!</span>";
        }
    } else {
        $status = "Gagal: Produk Tidak Ditemukan";
        $message = "❌ Kode produk tidak ditemukan.";

        // Simpan transaksi gagal tapi tetap menyertakan mesin
        mysqli_query($conn, "
            INSERT INTO transaksi (produk_id, gudang_id, mesin_id, qty, total_harga, status, created_at)
            VALUES (NULL, NULL, '$selected_mesin_id', 0, 0, '$status', NOW())
        ");
    }

    // Refresh produk setelah beli supaya stok update
    $produk_result = mysqli_query($conn, $produk_sql);
    if ($produk_result) {
        $produk_tersedia = mysqli_fetch_all($produk_result, MYSQLI_ASSOC);
        foreach ($produk_tersedia as $index => $p) {
            $produk_tersedia[$index]['code'] = chr(65 + floor($index / 3)) . (($index % 3) + 1);
        }
    } else {
        $produk_tersedia = [];
    }
}



?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Vending Machine Multi-Mesin & Laporan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-light text-dark py-5">
<div class="container bg-white shadow-lg rounded-4 p-4" style="max-width: 1000px;">

    <!-- PILIH MESIN -->
    <form method="GET" class="mb-4 text-center">
        <label for="mesin" class="fw-semibold me-2">Pilih Mesin:</label>
        <select name="mesin_id" id="mesin" class="form-select w-auto d-inline-block" onchange="this.form.submit()">
            <?php foreach ($mesins as $mesin): ?>
                <option value="<?= $mesin['id'] ?>" <?= $mesin['id'] == $selected_mesin_id ? 'selected' : '' ?>>
                    <?= htmlspecialchars($mesin['nama']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <div class="row g-4">
        <!-- PRODUK -->
        <div class="col-md-8 border-end">
            <div class="text-center mb-4">
                <h2 class="fw-bold text-primary mb-0">Mesin: <?= htmlspecialchars($mesins[array_search($selected_mesin_id, array_column($mesins, 'id'))]['nama']) ?></h2>
                <p class="text-muted">Pilih produk favoritmu</p>
            </div>
            <div class="row g-3">
                <?php if (!empty($produk_tersedia)): ?>
                    <?php foreach ($produk_tersedia as $p): ?>
                        <div class="col-6">
                            <div class="card border-0 shadow-sm h-100">
                                <img src="<?= htmlspecialchars($p['gambar']) ?>" class="card-img-top rounded-top" style="height:150px;object-fit:cover;" alt="<?= htmlspecialchars($p['nama_produk']) ?>">
                                <div class="card-body text-center">
                                    <h6 class="fw-semibold text-primary mb-1"><?= htmlspecialchars($p['nama_produk']) ?></h6>
                                    <p class="small text-secondary mb-1">Kode: <strong><?= htmlspecialchars($p['code']) ?></strong></p>
                                    <p class="mb-0 text-dark fw-bold">Rp <?= number_format($p['harga_produk'], 0, ',', '.') ?></p>
                                    <?php if ($p['stock'] > 0): ?>
                                        <p class="small text-secondary mb-1">Stock: <strong><?= htmlspecialchars($p['stock']) ?></strong></p>
                                    <?php else: ?>
                                        <p class="small text-danger fw-bold mb-1">Stock Habis</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center text-muted">Belum ada produk di mesin ini</div>
                <?php endif; ?>
            </div>
        </div>

        <!-- PANEL KONTROL -->
        <div class="col-md-4 d-flex flex-column justify-content-between">
            <div class="bg-primary bg-opacity-10 border border-primary rounded-3 text-center p-3 mb-3">
                <?= $message ?: '<div class="text-primary fw-semibold">Masukkan kode produk (contoh: A1)</div>' ?>
            </div>

            <form action="?mesin_id=<?= $selected_mesin_id ?>" method="POST" class="mb-4">
                <div class="input-group">
                    <input type="text" name="code" class="form-control text-center border-primary" maxlength="2" placeholder="Kode..." required>
                    <button type="submit" name="buy" class="btn btn-primary fw-bold">Beli</button>
                </div>
            </form>

            <div class="text-center">
                <div class="row g-2">
                    <?php foreach (["A", "B", "C", "1", "2", "3"] as $btn): ?>
                        <div class="col-4">
                            <button type="button" class="btn btn-outline-primary w-100 fw-bold py-2"><?= $btn ?></button>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    

</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const buttons = document.querySelectorAll(".btn-outline-primary");
    const input = document.querySelector("input[name='code']");
    
    buttons.forEach(btn => {
        btn.addEventListener("click", () => {
            const value = btn.textContent.trim();

            if (/[A-Z]/.test(value)) {
                input.value = value;
            } else if (/[0-9]/.test(value) && input.value.length === 1) {
                input.value += value;
            }
        });
    });
});
</script>

</body>
</html>
