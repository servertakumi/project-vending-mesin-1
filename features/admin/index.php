<?php
if (isset($_POST['cari'])) {

    $keyword = $_POST['keyword'];
    $data = mysqli_query($conn, "SELECT * FROM admin WHERE nama LIKE '%$keyword%'");
    $admin = mysqli_fetch_all($data, MYSQLI_ASSOC);
} else {
    if (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $query = "DELETE FROM admin WHERE `id` = $id ";
        $result = mysqli_query($conn, $query);
        if ($result) {
            echo "
            <script>
                alert('Apakah anda akan menghapus data kategori');
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
    $data = mysqli_query($conn, "SELECT * FROM admin");
    $admin = mysqli_fetch_all($data, MYSQLI_ASSOC);
}
?>


<div class="container">
    <div class="shadow p-3 mb-5 bg-white rounded pt-4">
        <div class="card-body" style="width: auto;">
            <div class="row">
                <div class="col-md-12">
                    <h6 class="text-center">welcome to admin</h6>
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
                            Tabel admin
                        </strong>
                    </div>
                    <div class="col-md-2">
                        <div class="d-grid">
                            <a href="./app?page=admin&view=add" class="btn btn-primary btn-sm" type="submit">tambah</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <table class="table align-items-center mb-0 mt-3">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>name</th>
                                <th>username</th>
                                <th>email</th>
                                <th>opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($admin as $no => $a): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                <i class="fa-solid fa-user-tie"></i>
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <p class="text-xs text-secondary mb-0"><?= $no + 1 ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="">
                                        <span class=""><strong><?= $a['nama']; ?></strong></span>
                                    </td>
                                    <td>
                                        <span class=""><?= $a['username']; ?></span>
                                    </td>
                                    <td class="">
                                        <span class=""><?= $a['email']; ?></span>
                                    </td>
                                    <td>
                                        <form action="" method="post" style="display: inline;"
                                            onsubmit="return confirm('anda akan menghapus data admin?')">
                                            <input type="hidden" name="id" value="<?= $a['id'] ?>">
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