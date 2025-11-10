<?php

if (isset($_POST['cari'])) {

    $keyword = $_POST['keyword'];
    $data = mysqli_query($conn, "SELECT 
    produk.*, 
    gudang.nama_produk AS nama, 
    gudang.jumlah_stock AS stock
    FROM produk 
    JOIN gudang ON produk.gudang_id = gudang.id
    WHERE gudang.nama_produk LIKE '%$keyword%';");

    $produk = mysqli_fetch_all($data, MYSQLI_ASSOC);
} else {
    if (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $query = "DELETE FROM produk WHERE `id` = $id ";
        $result = mysqli_query($conn, $query);
        if ($result) {
            echo "
            <script>
                alert('Apakah anda akan menghapus data produk');
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
    $data = mysqli_query($conn, "SELECT 
    produk.*, 
    gudang.nama_produk AS nama, 
    gudang.jumlah_stock AS stock
    FROM produk 
    JOIN gudang ON produk.gudang_id = gudang.id;");

    $produk = mysqli_fetch_all($data, MYSQLI_ASSOC);
}
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
                            Tabel produk
                        </strong>
                    </div>
                    <div class="col-md-2">
                        <div class="d-grid">
                            <a href="./app?page=produk&view=add" class="btn btn-primary btn-sm" type="submit">
                                Tambah
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <table class="table align-items-center mb-0 mt-3">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>code</th>
                                <th>gambar</th>
                                <th>Nama Produk</th>
                                <th>Harga produk</th>
                                <th>Deslripsi produk</th>
                                <th>Expire</th>
                                <th>opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($produk as $index => $p) {
                                $produk[$index]['code'] = chr(65 + floor($index / 9)) . (($index % 9) + 1);
                            }
                            ?>
                            <?php foreach ($produk as $no => $p): ?>
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
                                        <span class=""><strong><?= $p['code']; ?></strong></span>
                                    </td>
                                    <td class=" text-sm">
                                        <img src="<?= $p['gambar'] ?>" alt="" style="height: 48px;">
                                    </td>
                                    <td class=" text-sm">
                                        <span class=""><strong><?= $p['nama']; ?> - stock <?= $p['stock']; ?></strong></span>
                                    </td>
                                    <td class="">
                                        <span class=""><?= number_format($p['harga_produk']); ?></span>
                                    </td>
                                    <td class="">
                                        <span class=""><?= $p['deskripsi_produk']; ?></span>
                                    </td>
                                    <td class="">
                                        <span class=""><?= $p['expire']; ?></span>
                                    </td>
                                    <td>
                                        <a href="app?page=produk&view=edit&id=<?= $p['id'] ?>"
                                            class="btn btn-warning text-light btn-sm"><i
                                                class="fa-regular fa-pen-to-square"></i>edit
                                        </a>

                                        <form action="" method="post" style="display: inline;"
                                            onsubmit="return confirm('anda akan menghapus data users?')">
                                            <input type="hidden" name="id" value="<?= $p['id'] ?>">
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