<?php


// Ambil data total penjualan per mesin
$sql_laporan = "
    SELECT 
        m.id AS mesin_id,
        m.nama AS nama_mesin,
        COUNT(t.id) AS total_terjual
    FROM mesin m
    LEFT JOIN transaksi t ON t.mesin_id = m.id AND t.status='Sukses'
    GROUP BY m.id
    ORDER BY total_terjual DESC
";
$result_laporan = mysqli_query($conn, $sql_laporan);
if (!$result_laporan) die("Query laporan gagal: " . mysqli_error($conn));

$mesin_data = [];
while ($row = mysqli_fetch_assoc($result_laporan)) {
    $mesin_data[] = $row;
}

// Ambil mesin paling laris & paling tidak laris
$mesin_laris = $mesin_data[0] ?? null;
$mesin_tidak_laris = end($mesin_data) ?? null;

// Siapkan data untuk grafik
$labels = [];
$values = [];
foreach ($mesin_data as $m) {
    $labels[] = $m['nama_mesin'];
    $values[] = (int)$m['total_terjual'];
}
?>
<?php


$query = mysqli_query($conn, "
    SELECT 
        g.nama_produk AS nama_produk,
        SUM(t.qty) AS total_terjual
    FROM transaksi t
    JOIN gudang g ON t.gudang_id = g.id
    GROUP BY g.nama_produk
    ORDER BY total_terjual DESC
");

if (!$query) {
    die("Query gagal: " . mysqli_error($conn));
}

$produk = [];
$jumlah = [];

while ($row = mysqli_fetch_assoc($query)) {
    $produk[] = $row['nama_produk'];
    $jumlah[] = $row['total_terjual'];
}
// 
$query = mysqli_query($conn, "
    SELECT 
        g.nama_produk AS nama_produk,
        SUM(t.qty) AS total_terjual
    FROM transaksi t
    JOIN gudang g ON t.gudang_id = g.id
    WHERE t.status = 'Sukses'
    GROUP BY g.nama_produk
    ORDER BY total_terjual DESC
");


if (!$query) {
    die("Query gagal: " . mysqli_error($conn));
}

$produk = [];
$jumlah = [];

while ($row = mysqli_fetch_assoc($query)) {
    $produk[] = $row['nama_produk'];
    $jumlah[] = $row['total_terjual'];
}

// Ambil total transaksi per hari
$query = "
    SELECT 
        DATE(created_at) AS tanggal, 
        SUM(total_harga) AS total_penjualan
    FROM transaksi
    WHERE status = 'Sukses'
    GROUP BY DATE(created_at)
    ORDER BY tanggal ASC
";
$result = mysqli_query($conn, $query);
$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data['tanggal'][] = $row['tanggal'];
    $data['total'][] = $row['total_penjualan'];
}
// ===================
// LAPORAN PENJUALAN MESIN
// ===================
$sql_laporan = "
    SELECT 
        m.id AS mesin_id,
        m.nama AS nama_mesin,
        COUNT(t.id) AS total_terjual
    FROM mesin m
    LEFT JOIN transaksi t ON t.mesin_id = m.id AND t.status='Sukses'
    GROUP BY m.id
    ORDER BY total_terjual DESC
";
$result_laporan = mysqli_query($conn, $sql_laporan);
$mesin_data = [];
while ($row = mysqli_fetch_assoc($result_laporan)) {
    $mesin_data[] = $row;
}

$labels = [];
$values = [];
foreach ($mesin_data as $m) {
    $labels[] = $m['nama_mesin'];
    $values[] = (int)$m['total_terjual'];
}

$mesin_laris = $mesin_data[0] ?? null;
$mesin_tidak_laris = end($mesin_data) ?? null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
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
    <div class="container py-4">
        <div class="shadow mb-4 bg-body-tertiary rounded">
            <div class="card border-2">
                <div class="card-body p-2">
                    <div class="d-flex justify-content-center align-items-center text-white rounded"
                        style="background: url('assets/images/curved-images/curved14.jpg') center/cover no-repeat; height: 200px;">
                        <div class="container">
                            <div class="shadow mb-4 bg-body-tertiary rounded">
                                <div class="card p-3" style="margin-top: 250px;">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <img src="assets/images/curved-images/curved1.jpg" style="width: 80px; height: 80px;" class="rounded float-start p-2 shadow mb-0 bg-body-tertiary rounded" alt="...">
                                        </div>
                                        <div class="col-md-11 mt-3">
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card m-3">
                    <div class="row g-0 align-items-center">
                        <div class="col-md-2 text-end pe-3">
                            <div class="card-body pt-1">
                                <img src="assets/images/curved-images/mesin.webp" alt="" class="img-fluid">
                            </div>
                        </div>
                        <div class="col-md-2 text-end pe-3">
                            <div class="card-body pt-1">
                                <img src="assets/images/curved-images/mesin1.webp" alt="" class="img-fluid">
                            </div>
                        </div>
                        <div class="col-md-2 text-end pe-3">
                            <div class="card-body pt-1">
                                <img src="assets/images/curved-images/mesin2.webp" alt="" class="img-fluid">
                            </div>
                        </div>
                        <div class="col-md-6 ps-3">
                            <div class="card-body">
                                <h5 class="mb-1">Vending mechine</h5>
                                <p class="mb-0">tempat untuk menjual makan yang berbasis mesin</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <div class="card w-100">
                <div class="card-body">
                    <div class="d-md-flex align-items-center">
                        <div>
                            <h4 class="card-title">Laporan</h4>
                            <p class="card-subtitle">
                                Takumi vending machine
                            </p>
                        </div>
                        <div class="ms-auto">
                            <ul class="list-unstyled mb-0">
                                <li class="list-inline-item text-primary">
                                    <span class="round-8 text-bg-primary rounded-circle me-1 d-inline-block"></span>
                                    Ample
                                </li>
                                <li class="list-inline-item text-info">
                                    <span class="round-8 text-bg-info rounded-circle me-1 d-inline-block"></span>
                                    Pixel Admin
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div>
                        <div class="container py-5">

                            <canvas id="salesChart" height="100"></canvas>
                        </div>
                        <script>
                            const ctx = document.getElementById('salesChart').getContext('2d');
                            new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: <?= json_encode($data['tanggal'] ?? []) ?>,
                                    datasets: [{
                                        label: 'Total Penjualan (Rp)',
                                        data: <?= json_encode($data['total'] ?? []) ?>,
                                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                                        borderColor: 'rgba(54, 162, 235, 1)',
                                        borderWidth: 2,
                                        borderRadius: 8
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            ticks: {
                                                callback: (value) => 'Rp ' + value.toLocaleString()
                                            }
                                        }
                                    },
                                    plugins: {
                                        legend: {
                                            display: true,
                                            position: 'top'
                                        },
                                        tooltip: {
                                            callbacks: {
                                                label: ctx => 'Rp ' + ctx.formattedValue
                                            }
                                        }
                                    }
                                }
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card overflow-hidden">
                <div class="card-body pb-0">
                    <div class="d-flex align-items-start">
                        <div>
                            <h4 class="card-title">Weekly Stats</h4>
                            <p class="card-subtitle">Average sales</p>
                        </div>
                        <div class="ms-auto">
                            <div class="dropdown">
                                <a href="javascript:void(0)" class="text-muted" id="year1-dropdown" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="ti ti-dots fs-7"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="year1-dropdown">
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)">Action</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)">Another action</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)">Something else here</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>

                    <div class="card-body">
                        <canvas id="produkChart" height="315"></canvas>
                    </div>
                    <script>
                        const cte = document.getElementById('produkChart');

                        new Chart(cte, {
                            type: 'bar',
                            data: {
                                labels: <?= json_encode($produk); ?>,
                                datasets: [{
                                    label: 'Jumlah Produk Terjual',
                                    data: <?= json_encode($jumlah); ?>,
                                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    borderWidth: 2,
                                    borderRadius: 8
                                }]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        title: {
                                            display: true,
                                            text: 'Jumlah Terjual'
                                        }
                                    },
                                    x: {
                                        title: {
                                            display: true,
                                            text: 'Nama Produk'
                                        }
                                    }
                                },
                                plugins: {
                                    legend: {
                                        display: false
                                    },
                                    title: {
                                        display: true,
                                        text: 'Total Produk Terjual per Item',
                                        font: {
                                            size: 16
                                        }
                                    }
                                }
                            }
                        });
                    </script>
                </div>
            </div>
        </div>

        <h3 class="text-center mb-4">Laporan Penjualan Mesin</h3>
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card shadow-sm p-3">
                    <h5>Mesin Paling Laris</h5>
                    <?php if ($mesin_laris): ?>
                        <p class="fw-bold"><?= htmlspecialchars($mesin_laris['nama_mesin']) ?></p>
                        <p>Total Produk Terjual: <?= $mesin_laris['total_terjual'] ?></p>

                        <h6 class="mt-3">Detail Produk:</h6>
                        <ul class="mb-0">
                            <?php
                            // Ambil produk yang terjual di mesin paling laris
                            $id_mesin_laris = $mesin_laris['mesin_id'];
                            $query_produk_laris = "
                        SELECT g.nama_produk, COUNT(t.id) AS jumlah_terjual
                        FROM transaksi t
                        JOIN gudang g ON t.gudang_id = g.id
                        WHERE t.mesin_id = '$id_mesin_laris' AND t.status='Sukses'
                        GROUP BY g.id
                        ORDER BY jumlah_terjual DESC
                    ";
                            $result_produk_laris = mysqli_query($conn, $query_produk_laris);
                            if (mysqli_num_rows($result_produk_laris) > 0):
                                while ($p = mysqli_fetch_assoc($result_produk_laris)): ?>
                                    <li><?= htmlspecialchars($p['nama_produk']) ?> — <?= $p['jumlah_terjual'] ?> terjual</li>
                                <?php endwhile;
                            else: ?>
                                <li class="text-muted">Belum ada produk terjual</li>
                            <?php endif; ?>
                        </ul>
                    <?php else: ?>
                        <p class="text-muted">Belum ada data</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm p-3">
                    <h5>Mesin Paling Tidak Laris</h5>
                    <?php if ($mesin_tidak_laris): ?>
                        <p class="fw-bold"><?= htmlspecialchars($mesin_tidak_laris['nama_mesin']) ?></p>
                        <p>Total Produk Terjual: <?= $mesin_tidak_laris['total_terjual'] ?></p>

                        <h6 class="mt-3">Detail Produk:</h6>
                        <ul class="mb-0">
                            <?php
                            // Ambil produk di mesin paling tidak laris
                            $id_mesin_tidak_laris = $mesin_tidak_laris['mesin_id'];
                            $query_produk_tidak_laris = "
                        SELECT g.nama_produk, COUNT(t.id) AS jumlah_terjual
                        FROM transaksi t
                        JOIN gudang g ON t.gudang_id = g.id
                        WHERE t.mesin_id = '$id_mesin_tidak_laris' AND t.status='Sukses'
                        GROUP BY g.id
                        ORDER BY jumlah_terjual ASC
                    ";
                            $result_produk_tidak_laris = mysqli_query($conn, $query_produk_tidak_laris);
                            if (mysqli_num_rows($result_produk_tidak_laris) > 0):
                                while ($p = mysqli_fetch_assoc($result_produk_tidak_laris)): ?>
                                    <li><?= htmlspecialchars($p['nama_produk']) ?> — <?= $p['jumlah_terjual'] ?> terjual</li>
                                <?php endwhile;
                            else: ?>
                                <li class="text-muted">Belum ada produk terjual</li>
                            <?php endif; ?>
                        </ul>
                    <?php else: ?>
                        <p class="text-muted">Belum ada data</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-md-flex align-items-center">
                        <div>
                            <h4 class="card-title">Products Performance</h4>
                            <p class="card-subtitle">
                                Ample Admin Vs Pixel Admin
                            </p>
                        </div>
                        <div class="ms-auto mt-3 mt-md-0">
                            <select class="form-select theme-select border-0" aria-label="Default select example">
                                <option value="1">March 2025</option>
                                <option value="2">March 2025</option>
                                <option value="3">March 2025</option>
                            </select>
                        </div>
                    </div>
                    <div class="table-responsive mt-4">
                        <table class="table mb-0 text-nowrap varient-table align-middle fs-3">
                            <thead>
                                <tr>
                                    <th scope="col" class="px-0 text-muted">
                                        Assigned
                                    </th>
                                    <th scope="col" class="px-0 text-muted">Name</th>
                                    <th scope="col" class="px-0 text-muted">
                                        Priority
                                    </th>
                                    <th scope="col" class="px-0 text-muted text-end">
                                        Budget
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="px-0">
                                        <div class="d-flex align-items-center">
                                            <img src="./assets/images/profile/user-5.jpg" class="rounded-circle" width="40"
                                                alt="flexy" />
                                            <div class="ms-3">
                                                <h6 class="mb-0 fw-bolder">
                                                    Muhammad fasya'a khoirul jamil
                                                </h6>
                                                <span class="text-muted">Mhasiswa Takumi</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-0">Real Homes WP Theme</td>
                                    <td class="px-0">
                                        <span class="badge text-bg-primary">Medium</span>
                                    </td>
                                    <td class="px-0 text-dark fw-medium text-end">
                                        $24.5K
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-0">
                                        <div class="d-flex align-items-center">
                                            <img src="./assets/images/profile/user-3.jpg" class="rounded-circle" width="40"
                                                alt="flexy" />
                                            <div class="ms-3">
                                                <h6 class="mb-0 fw-bolder">Rizky sabana</h6>
                                                <span class="text-muted">Mahasiswa Takumi</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-0">Elite Admin</td>
                                    <td class="px-0">
                                        <span class="badge text-bg-danger">Medium</span>
                                    </td>
                                    <td class="px-0 text-dark fw-medium text-end">
                                        $3.9K
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>

</html>