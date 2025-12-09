<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM produk WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    $produk = mysqli_fetch_assoc($result);

    if (!$produk) {
        header("Location: app?page=produk");
        exit;
    }

    if (isset($_POST['update'])) {
        $gambar = $_POST['gambar'];
        $gudang_id = $_POST['gudang_id'];
        $harga_produk = $_POST['harga_produk'];
        $deskripsi_produk = $_POST['deskripsi_produk'];

        $expire = $_POST['expire'];


        $query = "UPDATE produk SET 
            gambar = '$gambar',
            gudang_id = '$gudang_id',
            harga_produk = '$harga_produk',
            deskripsi_produk = '$deskripsi_produk',
            expire = '$expire',
            updated_at = NOW()
            WHERE id = '$id'";

        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "
            <script>
                alert('Data berhasil diubah.');
                window.location.href = 'app?page=produk';
            </script>
            ";
        } else {
            echo "
            <script>
                alert('Data gagal diubah.');
            </script>
            ";
        }
    }
}

$data = mysqli_query($conn, "SELECT * FROM gudang");
$gudangs = mysqli_fetch_all($data, MYSQLI_ASSOC);
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
<div class="d-flex justify-content-center mt-5">
    <div class="shadow-lg p-3 mb-5 bg-body-tertiary rounded">
        <div class="card" style="width: 70rem">
            <div class="card-header" style="background-color: #3fc1d8ff;">
                <h5 style="color:white;">Edit Produk</h5>
            </div>

            <div class="card-header">
                <form action="" method="POST">

                    <div class="mb-3">
                        <label for="harga_produk" class="form-label">Harga Produk</label>
                        <input type="number" class="form-control" name="harga_produk" id="harga_produk"
                            value="<?= $produk['harga_produk'] ?>" placeholder="Masukkan Harga Produk">
                    </div>

                    <div class="mb-3">
                        <label for="gambar" class="form-label">edit gambar</label>
                        <input type="text" class="form-control" name="gambar" id="gambar"
                            value="<?= $produk['gambar'] ?>" placeholder="Masukkan Harga Produk">
                    </div>
                    <div class="input-group mb-3">
                        <label class="input-group-text" for="inputGroupSelect01">kategori</label>
                        <select class="form-select" id="gudang_id" name="gudang_id">
                            <option selected>pilih kategori</option>
                            <?php foreach ($gudangs as $g) : ?>
                                <option value="<?= $g['id'] ?>" <?php if ($g['id'] == $produk['gudang_id']) {
                                                                    echo "selected";
                                                                } ?>><?= $g['nama_produk'] ?> - stock <?= $g['jumlah_stock'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>


                    <div class="mb-3">
                        <label for="deskripsi_produk" class="form-label">Keterangan Produk</label>
                        <input class="form-control" name="deskripsi_produk" id="deskripsi_produk"
                            placeholder="Masukkan keterangan produk" value="<?= $produk['deskripsi_produk'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="expire" class="form-label">Expire</label>
                        <input class="form-control" name="expire" type="date" id="expire"
                            placeholder="Masukkan Lokasi Produk" value="<?= $produk['expire'] ?>">
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="app?page=produk&view=index" class="me-3"><i class="fa-solid fa-left-long"></i>Kembali</a>
                        <button type="submit" name="update" class="btn btn-primary"><i class="fa-solid fa-download"></i>Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>