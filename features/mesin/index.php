<?php

if (isset($_POST['cari'])) {

    $keyword = $_POST['keyword'];
    $data = mysqli_query($conn, "SELECT * FROM mesin WHERE nama LIKE '%$keyword%'");
    $mesin = mysqli_fetch_all($data, MYSQLI_ASSOC);
} else {
    if (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $query = "DELETE FROM mesin WHERE `id` = $id ";
        $result = mysqli_query($conn, $query);
        if ($result) {
            echo "
                alert('Apakah anda akan menghapus data mesin');
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
    $data = mysqli_query($conn, "SELECT * FROM mesin");
    $mesin = mysqli_fetch_all($data, MYSQLI_ASSOC);
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
                            Tabel Mesin
                        </strong>
                    </div>
                    <div class="col-md-2">
                        <div class="d-grid gap-2">
                            <a href="./app?page=mesin&view=add" class="btn btn-primary text-light" type="submit">tambah</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <table class="table align-items-center mb-0 mt-3">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Nama</th>
                                <th>Keterangan</th>
                                <th>Lokasi</th>
                                <th>Status</th>
                                <th>Kapasitas</th>
                                <th>Jumlah Roll</th>
                                <th>opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($mesin as $no => $m): ?>
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
                                        <span class=""><strong><?= $m['nama']; ?></strong></span>
                                    </td>
                                    <td class="">
                                        <span class=""><?= $m['keterangan']; ?></span>
                                    </td>
                                    <td class="">
                                        <span class="d"><?= $m['lokasi']; ?></span>
                                    </td>
                                    <td class="">
                                        <span class=""><?= $m['status']; ?></span>
                                    </td>
                                    <td class="">
                                        <span class=""><?= $m['kapasitas']; ?></span>
                                    </td>
                                    <td class="">
                                        <span class=""><?= $m['jumlah_roll']; ?></span>
                                    </td>
                                    <td>
                                    <a href="app?page=mesin&view=edit&id=<?= $m['id'] ?>"
                                        class="btn btn-warning btn-sm"><i
                                            class="fa-regular fa-pen-to-square"></i>edit
                                    </a>

                                    <form action="" method="post" style="display: inline;"
                                        onsubmit="return confirm('anda akan menghapus data mesin?')">
                                        <input type="hidden" name="id" value="<?= $m['id'] ?>">
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