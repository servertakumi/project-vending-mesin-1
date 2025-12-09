<?php
include_once 'config/db.php';

if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $query = "DELETE FROM setting_mesin_produk WHERE `id` = $id ";
    $result = mysqli_query($conn, $query);
    if ($result) {
        echo "
            <script>
                alert('Apakah anda akan menghapus data gudang');
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Data gagal dihapus.');
            </script>
        ";
    }
}
 

$mesin = mysqli_query($conn, "SELECT * FROM mesin");
if (!$mesin) die("Query mesin gagal: " . mysqli_error($conn));
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
<div class="container mt-4">
    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">Daftar Mesin & Produk</h5>
            </div>
        </div>
    </div>

    <?php while ($m = mysqli_fetch_assoc($mesin)) : ?>
        <?php
        $queryProduk = "
    SELECT 
        smp.id,
        smp.stock,
        code,
        p.id AS produk_id,
        p.deskripsi_produk,
        p.harga_produk,
        p.expire,
        g.nama_produk
    FROM setting_mesin_produk smp
    LEFT JOIN produk p ON smp.produk_id = p.id
    LEFT JOIN gudang g ON p.gudang_id = g.id
    WHERE smp.mesin_id = '{$m['id']}'
";


        $produk = mysqli_query($conn, $queryProduk);
        ?>
        <div class="card mt-4 shadow-sm border-0 rounded-4">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold"><?= htmlspecialchars($m['nama']) ?></h6>
                <a href="app?page=setting_mesin_produk&view=tambah&mesin_id=<?= $m['id'] ?>"
                    class="btn btn-success btn-sm shadow-sm">
                    <i class="fa-solid fa-plus"></i> Tambah Produk
                </a>
            </div>
            <div class="card-body">
                <table class="table table-borderless align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Produk</th>
                            <th>Stock</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($produk && mysqli_num_rows($produk) > 0): ?>
                            <?php $no = 1;
                            while ($p = mysqli_fetch_assoc($produk)) : ?>
                                <tr class="bg-body-secondary">
                                    <td><?= $no++ ?></td>
                                    <td>
                                        <strong><?= htmlspecialchars($p['nama_produk']) ?></strong><br>
                                        Kode: <?= htmlspecialchars($p['code']) ?><br>
                                        Deskripsi: <?= htmlspecialchars($p['deskripsi_produk']) ?><br>
                                        Harga: Rp<?= number_format($p['harga_produk'], 0, ',', '.') ?><br>
                                        Exp: <?= htmlspecialchars($p['expire']) ?>
                                    </td>
                                    <td class="text-center"><span class="badge bg-success"><?= $p['stock'] ?></span></td>
                                    <td class="text-center">
                                        <a href="app?page=setting_mesin_produk&view=edit&id=<?= $p['id'] ?>"
                                            class="btn btn-warning btn-sm"><i
                                                class="fa-regular fa-pen-to-square"></i>edit
                                        </a>

                                        <form action="" method="post" style="display: inline;"
                                            onsubmit="return confirm('anda akan menghapus data gudang?')">
                                            <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                            <button class="btn btn-danger btn-sm ms-2" type="submit" name="delete"><i
                                                    class="fa-solid fa-trash-can"></i>Hapus</button>
                                        </form>

                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted">Belum ada produk di mesin ini</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endwhile; ?>
</div>