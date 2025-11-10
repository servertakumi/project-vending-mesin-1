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

<div class="container-fluid py-4">
    <div class="shadow-lg p-3 mb-5 bg-body-tertiary rounded">
        <div class="row">
            <div class="col-12">
                <div class="card mb-0">
                    <div class="container">
                        <div class="row">
                            <!-- Judul -->
                            <div class="col-md-6">
                                <div class="card-header pb-0">
                                    <h6>Table Admin</h6>
                                </div>
                            </div>

                            <!-- Tombol Tambah -->
                            <div class="col-md-6 text-end">
                                <div class="card-body px-0 pt-0 pb-2 mt-3">
                                    <div class="">
                                        <a href="./app?page=admin&view=add" class="btn btn-primary " id="Tambah">
                                            <i class="fa-solid fa-plus"></i> Tambah
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Pencarian -->
                        <div class="row">
                            <div class="col-6">
                                <form class="d-flex" action="" method="post">
                                    <input type="search" name="keyword" class="form-control me-2" placeholder="Search" aria-label="Search" />
                            </div>
                            <div class="col-6">
                                <button type="submit" name="cari" class="btn btn-primary">Search</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Tempat untuk tabel -->
                    <div class="row mt-3">
                        <div class="col-12">
                            <!-- Tabel bisa diletakkan di sini -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<div class="container-fluid py-4">
    <div class="row">
        <div class="shadow-lg p-3 mb-5 bg-body-tertiary rounded">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">

                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">id</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">username</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">name</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">password</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">email</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">opsi</th>
                                        <th class="text-secondary opacity-7"></th>
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
                                            <td>
                                                <p class="text-xs text-secondary mb-0"><?= $a['username']; ?></p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="text-secondary text-xs font-weight-bold"><?= $a['nama']; ?></span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold"><?= $a['password']; ?></span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="badge badge-sm bg-gradient-success"><?= $a['email']; ?></span>
                                            </td>
                                            <td class="align-middle">
                                                <a href="./index.php?page=admin&view=edit&id=<?= $a['id'] ?>"
                                                    class="btn btn-warning btn-sm"><i
                                                        class="fa-regular fa-pen-to-square"></i>edit
                                                </a>

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
        </div>
    </div>

    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>

        </td>
    </tr>