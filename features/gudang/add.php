<?php
if (isset($_POST['simpan'])) {
    $nama_produk = $_POST['nama_produk'];
    $keterangan_produk = $_POST['keterangan_produk'];
    $jumlah_stock = $_POST['jumlah_stock'];
    $lokasi_gudang = $_POST['lokasi_gudang'];


    $query = "INSERT INTO `gudang`(`nama_produk`, `keterangan_produk`, `jumlah_stock`, `lokasi_gudang`) 
    VALUES ('$nama_produk', '$keterangan_produk', '$jumlah_stock', '$lokasi_gudang')";

    $result = mysqli_query($conn, $query);
    var_dump($query);
    if ($result) {
        echo "
        <script>
            alert('Data berhasil disimpan.');
            window.location.href = 'app?page=gudang';
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
                    <h6 class="text-center">welcome to storage</h6>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="d-flex justify-content-center mt-5">
    <div class="shadow-lg p-3 mb-5 bg-body-tertiary rounded">
        <div class="card" style="width: 70rem">
            <div class="card-header" style="background-color: #3fc1d8ff ;">
                <h5 style="color:white;">Gudang</h5>
            </div>

            <div class="card-header">
                <form action="" method="POST">

                    <div class="mb-3">
                        <label for="nama_produk" class="form-label">Nama</label>
                        <input type="text" class="form-control" name="nama_produk" id="nama_produk" placeholder="Masukkan Nama Produk">
                    </div>

                    <div class="mb-3">
                        <label for="keterangan_produk" class="form-label">Keterangan Produk</label>
                        <input class="form-control" name="keterangan_produk" id="keterangan_produk" rows="3"
                            placeholder="Masukkan keterangan"></input>
                    </div>

                    <div class="mb-3">
                        <label for="jumlah_stock" class="form-label">Jumlah Stock</label>
                        <input type="number" class="form-control" name="jumlah_stock" id="jumlah_stock" rows="3"
                            placeholder="Masukkan Jumlah Stock"></input>
                    </div>

                    <div class="mb-3">
                        <label for="lokasi_gudang" class="form-label">Lokasi Gudang</label>
                        <input class="form-control" name="lokasi_gudang" id="lokasi_gudang" rows="3"
                            placeholder="Masukkan Lokasi"></input>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="app?page=gudang&view=index" class="me-3"><i class="fa-solid fa-left-long"></i>Kembali</a>
                        <button type="submit" name="simpan" class="btn btn-primary"><i class="fa-solid fa-download"></i>Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>