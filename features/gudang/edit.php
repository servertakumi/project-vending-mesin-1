<?php
if ($_GET['id']){
    $id = $_GET['id'];
    $query = "SELECT * FROM gudang WHERE id = '$id' ";
    $result = mysqli_query ($conn, $query);
    $data = mysqli_fetch_assoc ($result);
    if (!$data) {
        header("Location: app.php");
    }

    if (isset($_POST['update'])) {
        $nama_produk = $_POST['nama_produk'];
        $keterangan_produk = $_POST['keterangan_produk'];
        $jumlah_stock = $_POST['jumlah_stock'];
        $lokasi_gudang = $_POST['lokasi_gudang'];
        $query = "UPDATE `gudang` SET `nama_produk`='$nama_produk',`keterangan_produk`='$keterangan_produk',`jumlah_stock`='$jumlah_stock',`lokasi_gudang`='$lokasi_gudang',`updated_at` = NOW() WHERE `id` = '$id' ";
        $result = mysqli_query ($conn, $query);
        if ($result) {
            echo "
            <script>
                alert('Data berhasil diubah.');
                window.location.href = 'app?page=gudang';
            </script>
            ";
        }else{
            echo"
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
                    <h6 class="text-center">welcome to storage</h6>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="d-flex justify-content-center mt-5">
    <div class="shadow-lg p-3 mb-5 bg-body-tertiary rounded">
        <div class="card" style="width: 70rem">
            <div class="card-header"  style="background-color: #3fc1d8ff ;">
                <h5 style="color:white;">Edit gudang</h5>
            </div>

            <div class="card-header">
                <form action="" method="POST">

                    <div class="mb-3">
                        <label for="nama_produk" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" name="nama_produk" id="nama_produk" placeholder="Masukkan Nama Produk"
                            value="<?=$data['nama_produk']?>">
                    </div>

                    <div class="mb-3">
                        <label for="keterangan_produk" class="form-label">Keterangan Produk</label>
                        <input class="form-control" name="keterangan_produk" id="keterangan_produk" rows="3"
                            placeholder="Masukkan keterangan produk" value="<?=$data['keterangan_produk']?>">
                        </input>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah_stock" class="form-label">Jumlah Stock</label>
                        <input class="form-control" name="jumlah_stock" id="jumlah_stock" rows="3"
                            placeholder="Masukkan Jumlah Stock" value="<?=$data['jumlah_stock']?>">
                        </input>
                    </div>
                    <div class="mb-3">
                        <label for="lokasi_gudang" class="form-label">Lokasi Gudang</label>
                        <input class="form-control" name="lokasi_gudang" id="lokasi_gudang" rows="3"
                            placeholder="Masukkan lokasi gudang" value="<?=$data['lokasi_gudang']?>">
                        </input>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="app?page=gudang&view=index" class="me-3"><i class="fa-solid fa-left-long"></i>Kembali</a>
                        <button type="submit" name="update" class="btn btn-primary"><i class="fa-solid fa-download"></i>Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>