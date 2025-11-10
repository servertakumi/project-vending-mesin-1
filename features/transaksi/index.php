<?php

if (isset($_POST['cari'])) {
    $keyword = $_POST['keyword'];
    $data = mysqli_query($conn, "SELECT 
        transaksi.*, 
        gudang.nama_produk AS nama, 
        produk.harga_produk AS harga,
        mesin.nama AS nama_mesin,
        mesin.lokasi
    FROM transaksi
    JOIN mesin ON transaksi.mesin_id = mesin.id
    JOIN gudang ON transaksi.gudang_id = gudang.id
    JOIN produk ON transaksi.produk_id = produk.id
    WHERE gudang.nama_produk LIKE '%$keyword%' 
       OR mesin.nama LIKE '%$keyword%' 
       OR produk.harga_produk LIKE '%$keyword%'
    ORDER BY transaksi.updated_at DESC;");  // <-- urut terbaru ke atas

    $transaksi = mysqli_fetch_all($data, MYSQLI_ASSOC);
} else {
    if (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $query = "DELETE FROM transaksi WHERE `id` = $id ";
        $result = mysqli_query($conn, $query);
        if ($result) {
            echo "<script>alert('Data transaksi berhasil dihapus');</script>";
        } else {
            echo "<script>alert('Data gagal dihapus.');</script>";
        }
    }

    $data = mysqli_query($conn, "SELECT 
        transaksi.*, 
        gudang.nama_produk AS nama, 
        produk.harga_produk AS harga,
        mesin.nama AS nama_mesin,
        mesin.lokasi
    FROM transaksi
    JOIN mesin ON transaksi.mesin_id = mesin.id
    JOIN gudang ON transaksi.gudang_id = gudang.id
    JOIN produk ON transaksi.produk_id = produk.id
    ORDER BY transaksi.updated_at DESC;"); // <-- urut terbaru ke atas

    $transaksi = mysqli_fetch_all($data, MYSQLI_ASSOC);
}
?>



<div class="container">
    <div class="shadow p-3 mb-5 bg-white rounded pt-4">
        <div class="card-body" style="width: auto;">
            <div class="row">
                <div class="col-md-12">
                    <h6 class="text-center">welcome to payment</h6>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="shadow p-3 mb-5 bg-white rounded pt-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="">
                        <form class="" action="" method="post">
                            <div class="row">
                                <div class="col-md-11">
                                    <input type="search" name="keyword" class="form-control text-center" placeholder="Search" aria-label="Search" />
                                </div>
                                <div class="col-md-1">
                                    <button type="submit" name="cari" class="btn btn-primary text-end"><i class="fa-solid fa-magnifying-glass"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container ">
        <div class="shadow p-3 mb-5 bg-white rounded pt-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-10">
                        <strong>
                            Tabel Transaksi
                        </strong>
                    </div>
                    <div class="col-md-2">
                        <div class="d-grid">
                            <a href="mesin?page" class="btn btn-primary text-light" type="submit">vending mesin</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <table class="table align-items-center mb-0 mt-3">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Nama Produk</th>
                                <th>Harga</th>
                                <th>Nama Mesin</th>
                                <th>Lokasi</th>
                                <th>Qty</th>
                                <th>Total Harga</th>
                                <th>Status</th>
                                <th>tanggal pembelian</th>
                                <th>opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($transaksi as $no => $t): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>

                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <p class=""><?= $no + 1 ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class=" text-sm">
                                        <span class=""><strong><?= $t['nama']; ?></strong></span>
                                    </td>
                                    <td class=" text-sm">
                                        <span class=""><strong><?= $t['harga']; ?></strong></span>
                                    </td>
                                    <td class=" text-sm">
                                        <span class=""><strong><?= $t['nama_mesin']; ?></strong></span>
                                    </td>
                                    <td class=" text-sm">
                                        <span class=""><strong><?= $t['lokasi']; ?></strong></span>
                                    </td>
                                    <td class="">
                                        <span class=""><strong><?= number_format($t['qty']); ?><strong></span>
                                    </td>
                                    <td class=" text-sm">
                                        <span class=""><strong><?= number_format($t['total_harga']); ?></strong></span>
                                    </td>
                                    <td class=" text-sm">
                                        <span class=""><strong><?= $t['status']; ?></strong></span>
                                    </td>
                                    <td class=" text-sm">
                                        <span class="" type="date"><strong><?= $t['updated_at']; ?></strong></span>
                                    </td>
                                    <td>
                                        <form action="" method="post" style="display: inline;"
                                            onsubmit="return confirm('anda akan menghapus data transaksi?')">
                                            <input type="hidden" name="id" value="<?= $t['id'] ?>">
                                            <button class="btn btn-danger btn-sm ms-2" type="submit" name="delete"><i
                                                    class="fa-solid fa-trash-can"></i>Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>