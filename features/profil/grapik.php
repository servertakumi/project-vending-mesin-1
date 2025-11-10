<?php
include 'config/db.php';

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
?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Diagram Produk Terjual</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">📊 Jumlah Produk Terjual</h4>
            </div>
            <div class="card-body">
                <canvas id="produkChart" height="120"></canvas>
            </div>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('produkChart');

        new Chart(ctx, {
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

</body>

</html>