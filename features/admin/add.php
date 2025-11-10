<?php
if (isset($_POST['simpan'])) {
    $nama = trim($_POST['nama'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($nama === '' || $username === '' || $email === '' || $password === '') {
        echo "
        <script>
            alert('semua field wajib diisi.');
        </script>
        ";
    } else {
        $safename = mysqli_real_escape_string($conn, $nama);
        $safeusername = mysqli_real_escape_string($conn, $username);
        $safeemail = mysqli_real_escape_string($conn, $email);
        $checkusername = mysqli_query($conn, "SELECT id FROM admin WHERE username ='$safeusername' LIMIT 1");
        if ($checkusername && mysqli_num_rows($checkusername) > 0) {
            echo "
            <script>
                alert('username sudah di gunakan, pilih username lain.')
            </script>
            ";
        } else {
            $hashedpassword = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO admin (nama, username, email, password) VALUES ('$safename','$safeusername','$safeemail','$hashedpassword')";

            $result = mysqli_query($conn, $query);
            
            if ($result) {
                echo "
                <script>
                    alert('Data berhasil disimpan.');
                    window.location.href = 'app?page=admin';
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
    }
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
<div class="d-flex justify-content-center mt-5">
    <div class="shadow-lg p-3 mb-5 bg-body-tertiary rounded">
        <div class="card" style="width: 70rem">
            <div class="card-header" style="background-color: #3fc1d8ff ;">
                <h5 style="color:white;">admin</h5>
            </div>

            <div class="card-header">
                <form action="" method="POST">

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" name="nama" id="nama" placeholder="Masukkan nama lengkap">
                    </div>

                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" id="username" placeholder="Masukkan username">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Masukkan email">
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Masukkan password">
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="./app?page=admin&view=index" class="me-3"><i class="fa-solid fa-left-long"></i>Kembali</a>
                        <button type="submit" name="simpan" class="btn btn-primary"><i class="fa-solid fa-download"></i>Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>