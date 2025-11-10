<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM transaksi WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    $transaksi = mysqli_fetch_assoc($result);

    if (!$transaksi) {
        header("Location: app?page=transaksi");
        exit;
    }

    if (isset($_POST['update'])) {
        $gudang_id = $_POST['gudang_id'];
        $mesin_id = $_POST['mesin_id'];
        $produk_id = $_POST['produk_id'];
        $qty = $_POST['qty'];
        $total_harga = $_POST['total_harga'];
        $status = $_POST['status'];


        $query = "UPDATE transaksi SET 
            gudang_id = '$gudang_id',
            mesin_id = '$mesin_id',
            produk_id = '$produk_id',
            qty = '$qty',
            total_harga = '$total_harga',
            status = '$status',
            updated_at = NOW()
            WHERE id = '$id'";
        var_dump($query);

        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "
            <script>
                alert('Data berhasil diubah.');
                window.location.href = 'app?page=transaksi';
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

$data = mysqli_query($conn, "SELECT * FROM mesin");
$mesin = mysqli_fetch_all($data, MYSQLI_ASSOC);

$data = mysqli_query($conn, "SELECT * FROM gudang");
$gudang = mysqli_fetch_all($data, MYSQLI_ASSOC);

$data = mysqli_query($conn, "SELECT * FROM produk");
$produk = mysqli_fetch_all($data, MYSQLI_ASSOC);
?>
<div class="container">
    <div class="shadow p-3 mb-5 bg-white rounded pt-4">
        <div class="card-body" style="width: auto;">
            <div class="row">
                <div class="col-md-12">
                    <h6 class="text-center">Eat My Shit</h6>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="d-flex justify-content-center mt-5">
    <div class="shadow-lg p-3 mb-5 bg-body-tertiary rounded">
        <div class="card" style="width: 70rem">
            <div class="card-header" style="background-color: #3fc1d8ff;">
                <h5 style="color:white;">Edit transaksi</h5>
            </div>

            <div class="card-header">
                <form action="" method="POST">
                    <div class="input-group mb-3">
                        <label class="input-group-text" for="inputGroupSelect01">gudang</label>
                        <select class="form-select" id="mesin_id" name="mesin_id">
                            <option selected>pilih kategori</option>
                            <?php foreach ($mesin as $m) : ?>
                                <option value="<?= $m['id'] ?>" <?php if ($m['id'] == $transaksi['mesin_id']) {
                                                                    echo "selected";
                                                                } ?>><?= $m['nama'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="input-group mb-3">
                        <label class="input-group-text" for="inputGroupSelect01">kategori</label>
                        <select class="form-select" id="gudang_id" name="gudang_id">
                            <option selected>pilih kategori</option>
                            <?php foreach ($gudang as $g) : ?>
                                <option value="<?= $g['id'] ?>" <?php if ($g['id'] == $transaksi['gudang_id']) {
                                                                    echo "selected";
                                                                } ?>><?= $g['nama_produk'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="input-group mb-3">
                        <label class="input-group-text" for="inputGroupSelect01">kategori</label>
                        <select class="form-select" id="produk_id" name="produk_id">
                            <option selected>pilih kategori</option>
                            <?php foreach ($produk as $p) : ?>
                                <option value="<?= $p['id'] ?>" <?php if ($p['id'] == $transaksi['produk_id']) {
                                                                    echo "selected";
                                                                } ?>><?= $p['harga_produk'] ?><?= $p['deskripsi_produk'] ?><?= $p['expire'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="qty" class="form-label">qty</label>
                        <input type="number" class="form-control" name="qty" id="qty"
                            value="<?= $transaksi['qty'] ?>" placeholder="Masukkan Harga transaksi">
                    </div>
                    <div class="mb-3">
                        <label for="total_harga" class="form-label">total harga</label>
                        <input type="number" class="form-control" name="total_harga" id="total_harga"
                            value="<?= $transaksi['total_harga'] ?>" placeholder="Masukkan Harga transaksi">
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">status</label>
                        <select class="form-select" name="status" id="status" aria-label="Default select example">
                            <option value="berhasil" <?= ($transaksi['status'] == 'berhasil') ? 'selected' : '' ?>>berhasil</option>
                            <option value="gagal" <?= ($transaksi['status'] == 'Gagal') ? 'selected' : '' ?>>Gagal</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="app?page=transaksi&view=index" class="me-3"><i class="fa-solid fa-left-long"></i>Kembali</a>
                        <button type="submit" name="update" class="btn btn-primary"><i class="fa-solid fa-download"></i>Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>