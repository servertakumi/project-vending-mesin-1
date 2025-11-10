<?php
if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $keterangan = $_POST['keterangan'];
    $lokasi = $_POST['lokasi'];
    $status = $_POST['status'];
    $kapasitas = $_POST['kapasitas'];
    $jumlah_roll = $_POST['jumlah_roll'];


    $query = "INSERT INTO `mesin`(`nama`, `keterangan`, `lokasi`, `status`, `kapasitas`, `jumlah_roll`) 
    VALUES ('$nama', '$keterangan', '$lokasi', '$status', '$kapasitas', '$jumlah_roll')";

    $result = mysqli_query($conn, $query);
    if ($result) {
        echo "
        <script>
            alert('Data berhasil disimpan.');
            window.location.href = 'app?page=mesin';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('Data gagal disimpan.');
        </script>
        ";
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
                <h5 style="color:white;">Mesin</h5>
            </div>

            <div class="card-header">
                <form action="" method="POST">

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Mesin</label>
                        <input type="text" class="form-control" name="nama" id="nama" placeholder="Masukkan Nama Mesin">
                    </div>

                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan Mesin</label>
                        <input class="form-control" name="keterangan" id="keterangan" rows="3"
                            placeholder="Masukkan Keterangan Mesin"></input>
                    </div>

                    <div class="mb-3">
                        <label for="lokasi" class="form-label">Lokasi</label>
                        <input class="form-control" name="lokasi" id="lokasi" rows="3"
                            placeholder="Masukkan Lokasi Mesin"></input>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">status</label>
                        <select class="form-select" name="status" id="status" aria-label="Default select example">
                            <option value="hidup">hidup</option>
                            <option value="mati">mati</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="kapasitas" class="form-label">kapasitas</label>
                        <input type="number" class="form-control" name="kapasitas" id="kapasitas" rows="3"
                            placeholder="Masukkan Kapasitas"></input>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah_roll" class="form-label">Jumlah Roll</label>
                        <input type="number" class="form-control" name="jumlah_roll" id="jumlah_roll" rows="3"
                            placeholder="Masukkan Jumlah Roll"></input>
                    </div>



                    <div class="d-flex justify-content-between">
                        <a href="app?page=mesin&view=index" class="me-3"><i class="fa-solid fa-left-long"></i>Kembali</a>
                        <button type="submit" name="simpan" class="btn btn-primary"><i class="fa-solid fa-download"></i>Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>