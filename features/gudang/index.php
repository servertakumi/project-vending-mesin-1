<?php

if (isset($_POST['cari'])) {

    $keyword = $_POST['keyword'];
    $data = mysqli_query($conn, "SELECT * FROM gudang WHERE nama_produk LIKE '%$keyword%'");
    $gudang = mysqli_fetch_all($data, MYSQLI_ASSOC);
} else {
    if (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $query = "DELETE FROM gudang WHERE `id` = $id ";
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
    $data = mysqli_query($conn, "SELECT * FROM gudang");
    $gudang = mysqli_fetch_all($data, MYSQLI_ASSOC);
}
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
                            welcome to storage
                        </strong>
                    </div>
                    <div class="col-md-2">
                        <div class="d-grid gap-2">
                            <a href="./app?page=gudang&view=add" class="btn btn-primary text-light" type="submit">tambah</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <table class="table align-items-center mb-0 mt-3">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Nama Produk</th>
                                <th>Keterangan Produk</th>
                                <th>Jumlah Stock</th>
                                <th>Lokasi Gudang</th>
                                <th>opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($gudang as $no => $g): ?>
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
                                        <span class=""><strong><?= $g['nama_produk']; ?></strong></span>
                                    </td>
                                    <td class="">
                                        <span class=""><?= $g['keterangan_produk']; ?></span>
                                    </td>
                                    <td class="">
                                        <span class="d"><?= $g['jumlah_stock']; ?></span>
                                    </td>
                                    <td class="">
                                        <span class=""><?= $g['lokasi_gudang']; ?></span>
                                    </td>
                                    <td>
                                    <a href="app?page=gudang&view=edit&id=<?= $g['id'] ?>"
                                        class="btn btn-warning btn-sm"><i
                                            class="fa-regular fa-pen-to-square"></i>edit
                                    </a>

                                    <form action="" method="post" style="display: inline;"
                                        onsubmit="return confirm('anda akan menghapus data gudang?')">
                                        <input type="hidden" name="id" value="<?= $g['id'] ?>">
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