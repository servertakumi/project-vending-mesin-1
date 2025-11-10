<?php
if ($_GET['id']) {
    $id = $_GET['id'];
    $query = "SELECT * FROM mesin WHERE id = '$id' ";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
    if (!$data) {
        header("Location: app?page=mesin");
    }

    if (isset($_POST['update'])) {
        $nama = $_POST['nama'];
        $keterangan = $_POST['keterangan'];
        $lokasi = $_POST['lokasi'];
        $status = $_POST['status'];
        $kapasitas = $_POST['kapasitas'];
        $jumlah_roll = $_POST['jumlah_roll'];
        $query = "UPDATE `mesin` SET `nama`='$nama',`keterangan`='$keterangan',`lokasi`='$lokasi',`kapasitas`='$kapasitas',`status`='$status',`jumlah_roll`='$jumlah_roll',`updated_at` = NOW() WHERE `id` = '$id' ";
        var_dump($query);
        $result = mysqli_query($conn, $query);
        if ($result) {
            echo "
            <script>
                alert('Data berhasil diubah.');
                window.location.href = 'app?page=mesin';
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
                <h5 style="color:white;">Edit mesin</h5>
            </div>

            <div class="card-header">
                <form action="" method="POST">

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama mesin</label>
                        <input type="text" class="form-control" name="nama" id="nama" placeholder="Masukkan Nama mesin"
                            value="<?= $data['nama'] ?>">
                    </div>

                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan mesin</label>
                        <input class="form-control" name="keterangan" id="keterangan" rows="3"
                            placeholder="Masukkan keterangan mesin" value="<?= $data['keterangan'] ?>">
                        </input>
                    </div>
                    <div class="mb-3">
                        <label for="lokasi" class="form-label">lokasi</label>
                        <input class="form-control" name="lokasi" id="lokasi" rows="3"
                            placeholder="Masukkan Jumlah Stock" value="<?= $data['lokasi'] ?>">
                        </input>
                    </div>
                    <div class="mb-3">
                        <label for="kapasitas" class="form-label">kapasitas</label>
                        <input class="form-control" type="number" name="kapasitas" id="kapasitas" rows="3"
                            placeholder="Masukkan lokasi mesin" value="<?= $data['kapasitas'] ?>">
                        </input>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" name="status" id="status" aria-label="Default select example">
                            <option value="hidup" <?= ($data['status'] == 'hidup') ? 'selected' : '' ?>>hidup</option>
                            <option value="mati" <?= ($data['status'] == 'Gagal') ? 'selected' : '' ?>>Gagal</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="jumlah_roll" class="form-label">jumlah roll</label>
                        <input class="form-control" type="number" name="jumlah_roll" id="jumlah_roll" rows="3"
                            placeholder="Masukkan lokasi mesin" value="<?= $data['jumlah_roll'] ?>">
                        </input>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="app?page=mesin&view=index" class="me-3"><i class="fa-solid fa-left-long"></i>Kembali</a>
                        <button type="submit" name="update" class="btn btn-primary"><i class="fa-solid fa-download"></i>Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>