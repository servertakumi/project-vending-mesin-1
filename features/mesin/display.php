<?php
// ======================
// AMBIL ID MESIN DARI URL
// ======================
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Ambil data mesin
$mesin_data = mysqli_query($conn, "SELECT * FROM mesin WHERE id = $id");
$mesin = mysqli_fetch_assoc($mesin_data);

// Jika mesin tidak ditemukan
if (!$mesin) {
    echo "<script>
            alert('Mesin tidak ditemukan!');
            window.location='app?page=mesin';
          </script>";
    exit;
}

// ======================
// DEFAULT: AMBIL PRODUK DI MESIN INI
// ======================
$queryProdukMesin = "
    SELECT 
        smp.id AS setting_id,
        smp.stock,
        g.nama_produk,
        p.code,
        p.deskripsi_produk,
        p.harga_produk,
        p.expire
    FROM setting_mesin_produk smp
    LEFT JOIN produk p ON smp.produk_id = p.id
    LEFT JOIN gudang g ON p.gudang_id = g.id
    WHERE smp.mesin_id = $id
";

$resultProdukMesin = mysqli_query($conn, $queryProdukMesin);
$produk_list = mysqli_fetch_all($resultProdukMesin, MYSQLI_ASSOC);

// ======================
// FITUR CARI PRODUK
// ======================
if (isset($_POST['cari'])) {

    $keyword = mysqli_real_escape_string($conn, $_POST['keyword']);

    $queryCari = "
        SELECT 
            smp.id AS setting_id,
            smp.stock,
            g.nama_produk,
            p.code,
            p.deskripsi_produk,
            p.harga_produk,
            p.expire
        FROM setting_mesin_produk smp
        LEFT JOIN produk p ON smp.produk_id = p.id
        LEFT JOIN gudang g ON p.gudang_id = g.id
        WHERE smp.mesin_id = $id
        AND g.nama_produk LIKE '%$keyword%'
    ";

    $resultCari = mysqli_query($conn, $queryCari);
    $produk_list = mysqli_fetch_all($resultCari, MYSQLI_ASSOC);
}

// ======================
// FITUR DELETE PRODUK MESIN
// ======================
if (isset($_POST['delete'])) {

    if (!isset($_POST['id']) || $_POST['id'] === "") {
        echo "<script>alert('ID tidak ditemukan');</script>";
        exit;
    }

    $setting_id = intval($_POST['id']); // ID SETTING, BUKAN ID MESIN

    $query = "DELETE FROM setting_mesin_produk WHERE id = $setting_id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "
        <script>
            alert('Data berhasil dihapus');
            window.location='app?page=mesin&view=display&id=$id';
        </script>";
    } else {
        echo "
        <script>
            alert('Data gagal dihapus: " . mysqli_error($conn) . "');
        </script>";
    }
}
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
<div class="d-flex justify-content-center mt-5">
    <div class="shadow-lg p-3 mb-5 bg-body-tertiary rounded">
        <div class="card" style="width: 70rem">
            <div class="card-header" style="background-color: #3fc1d8ff ;">
                <div class="row">
                    <div class="col-md-9">
                        <h5 style="color:white;"><?= htmlspecialchars($mesin['nama']) ?></h5>
                    </div>
                    <div class="col-md-3">
                        <a class="btn btn-success" href="app?page=mesin&view=addproduk&id=<?= $mesin['id'] ?>">
                            <i class="fa-solid fa-plus"></i> Tambahkan produk
                        </a>
                    </div>
                </div>
            </div>
            <table class="table table-borderless align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Produk</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>

                    <?php if (!empty($produk_list)): ?>
                        <?php foreach ($produk_list as $no => $p): ?>
                            <tr>
                                <td><?= $no + 1 ?></td>
                                <td>
                                    <strong><?= htmlspecialchars($p['nama_produk']) ?></strong><br>
                                    Kode: <?= htmlspecialchars($p['code']) ?><br>
                                    Deskripsi: <?= htmlspecialchars($p['deskripsi_produk']) ?><br>
                                    Harga: Rp<?= number_format($p['harga_produk'], 0, ',', '.') ?><br>
                                    Exp: <?= htmlspecialchars($p['expire']) ?>
                                </td>
                                <td class="text-center">
                                    <a href="app?page=setting_mesin_produk&view=edit&id=<?= $p['setting_id'] ?>"
                                        class="btn btn-warning btn-sm">
                                        <i class="fa-regular fa-pen-to-square"></i> edit
                                    </a>
                                    <form action="" method="post" style="display: inline;"
                                        onsubmit="return confirm('anda akan menghapus data gudang?')">
                                        <input type="hidden" name="id" value="<?= $p['setting_id'] ?>">
                                        <button class="btn btn-danger btn-sm ms-2" type="submit" name="delete">
                                            <i class="fa-solid fa-trash-can"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">Belum ada produk di mesin ini</td>
                        </tr>
                    <?php endif; ?>

                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-between align-items-center mt-4">
            <a href="app?page=mesin " class="btn btn-outline-secondary shadow-sm">
                <i class="fa-solid fa-left-long me-1"></i> Kembali
            </a>
        </div>
    </div>
</div>