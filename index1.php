<?php
include 'config/db.php';

// Ambil semua mesin
$mesin_result = mysqli_query($conn, "SELECT * FROM mesin");
if (!$mesin_result) die("Query mesin gagal: " . mysqli_error($conn));
$mesins = mysqli_fetch_all($mesin_result, MYSQLI_ASSOC);
if (count($mesins) == 0) die("Belum ada mesin tersedia");

// Pilih mesin default
$selected_mesin_id = intval($_GET['mesin_id'] ?? $mesins[0]['id']);

// Ambil produk sesuai mesin terpilih
$produk_sql = "
    SELECT 
        smp.id AS smp_id,
        smp.stock,
        p.id AS produk_id,
        p.gudang_id,
        p.gambar,
        p.harga_produk,
        g.nama_produk,
        m.id AS mesin_id,
        m.nama AS nama_mesin
    FROM setting_mesin_produk smp
    JOIN produk p ON smp.produk_id = p.id
    JOIN gudang g ON p.gudang_id = g.id
    JOIN mesin m ON smp.mesin_id = m.id
    WHERE smp.mesin_id = '$selected_mesin_id'
";

$produk_result = mysqli_query($conn, $produk_sql);
if (!$produk_result) die("Query produk gagal: " . mysqli_error($conn));
$produk_tersedia = mysqli_fetch_all($produk_result, MYSQLI_ASSOC);

// Generate kode produk otomatis (A1, A2, A3, dst)
foreach ($produk_tersedia as $index => $p) {
    $produk_tersedia[$index]['code'] = chr(65 + floor($index / 3)) . (($index % 3) + 1);
}

// Proses beli
$message = "";
if (isset($_POST['buy'])) {
    $code = strtoupper(trim($_POST['code']));
    $produk_dipilih = null;

    foreach ($produk_tersedia as $p) {
        if ($p['code'] === $code) {
            $produk_dipilih = $p;
            break;
        }
    }

    if ($produk_dipilih) {
        $smp_id = $produk_dipilih['smp_id'];
        $produk_id = $produk_dipilih['produk_id'];
        $gudang_id = $produk_dipilih['gudang_id'];
        $mesin_id = $produk_dipilih['mesin_id'];
        $harga = $produk_dipilih['harga_produk'];
        $qty = 1;
        $total = $harga * $qty;

        if ($produk_dipilih['stock'] <= 0) {
            $status = "Gagal: Produk Habis";
            $message = "❌ Stok untuk <strong>{$produk_dipilih['nama_produk']}</strong> sudah habis.";

            mysqli_query($conn, "
                INSERT INTO transaksi (produk_id, gudang_id, mesin_id, qty, total_harga, status, created_at)
                VALUES ('$produk_id', '$gudang_id', '$mesin_id', '$qty', '$total', '$status', NOW())
            ");
        } else {
            $status = "Sukses";

            mysqli_query($conn, "
                INSERT INTO transaksi (produk_id, gudang_id, mesin_id, qty, total_harga, status, created_at)
                VALUES ('$produk_id', '$gudang_id', '$mesin_id', '$qty', '$total', '$status', NOW())
            ");

            // Kurangi stok di setting_mesin_produk
            mysqli_query($conn, "
                UPDATE setting_mesin_produk 
                SET stock = stock - 1 
                WHERE id = '$smp_id' AND mesin_id = '$mesin_id'
            ");

            $message = "🎉 Anda membeli <strong>{$produk_dipilih['nama_produk']}</strong> seharga Rp " . number_format($harga, 0, ',', '.') . "<br><span class='text-success'>Transaksi berhasil!</span>";
        }
    } else {
        $status = "Gagal: Produk Tidak Ditemukan";
        $message = "❌ Kode produk tidak ditemukan.";

        mysqli_query($conn, "
        INSERT INTO transaksi (produk_id, gudang_id, mesin_id, qty, total_harga, status, created_at)
        VALUES (0, 0, '$selected_mesin_id', 0, 0, '$status', NOW())
    ");
    }


    // Refresh produk setelah beli supaya stok update
    $produk_result = mysqli_query($conn, $produk_sql);
    if ($produk_result) {
        $produk_tersedia = mysqli_fetch_all($produk_result, MYSQLI_ASSOC);
        foreach ($produk_tersedia as $index => $p) {
            $produk_tersedia[$index]['code'] = chr(65 + floor($index / 3)) . (($index % 3) + 1);
        }
    } else {
        $produk_tersedia = [];
    }
}
?>
<?php include('./pembeli/layouts/header.php'); ?>

<?php
include('./pembeli/layouts/navbar.php'); ?>
<?php
// ================= CONFIG SERVER AI =================
// GANTI URL INI SAJA SESUAI LOKASI SERVER AI KAMU
$AI_SERVER = "http://localhost:3000/chat";
// contoh lain:
// $AI_SERVER = "http://localhost:5050/chat";
// $AI_SERVER = "http://192.168.1.5:3000/chat"; (LAN)
// =====================================================
?>


<!-- Carousel Start -->
<header class="header-2">
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">

        <div class="carousel-indicators" style="top: 600px;">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>

        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="page-header min-vh-100 relative" style="background-image: url('./assets/asset1/img/mk1.jpg'); background-size: cover; background-position: center;">
                    <span class="mask bg-gradient opacity-4"></span>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-7 text-center mx-auto">
                                <h1 class="text-white pt-3 mt-n5">Material Kit 2</h1>
                                <p class="lead text-white mt-3">Free & Open Source Web UI Kit built over Bootstrap 5. <br /> Join over 1.6 million developers around the world.</p>
                                <a href="#" class="btn btn-info">Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <div class="page-header min-vh-100 relative" style="background-image: url('./assets/asset1/img/mk3.jpg'); background-size: cover; background-position: center;">
                    <span class="mask bg-gradient opacity-4"></span>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-7 text-center mx-auto">
                                <h1 class="text-white text-shadow pt-3 mt-n5">Material Kit 2</h1>
                                <p class="lead text-white mt-3">Free & Open Source Web UI Kit built over Bootstrap 5. <br /> Join over 1.6 million developers around the world.</p>
                                <a href="#" class="btn btn-info">Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <div class="page-header min-vh-100 relative" style="background-image: url('./assets/asset1/img/mk2.jpg'); background-size: cover; background-position: center;">
                    <span class="mask bg-gradient opacity-4"></span>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-7 text-center mx-auto">
                                <h1 class="text-white pt-3 mt-n5">Material Kit 2</h1>
                                <p class="lead text-white mt-3">Free & Open Source Web UI Kit built over Bootstrap 5. <br /> Join over 1.6 million developers around the world.</p>
                                <a href="#" class="btn btn-info">Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Kiri / Kanan -->

    </div>
</header>


<div class="card card-body blur shadow-blur mx-3 mx-md-4 mt-n6">

    <section class="pt-3 pb-4" id="count-stats">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 mx-auto py-3">
                    <div class="row">
                        <div class="col-md-4 position-relative">
                            <div class="p-3 text-center">
                                <h1 class="text-gradient text-info"><span id="state1" countTo="70">0</span>+</h1>
                                <h5 class="mt-3">Coded Elements</h5>
                                <p class="text-sm font-weight-normal">From buttons, to inputs, navbars, alerts or cards, you are covered</p>
                            </div>
                            <hr class="vertical dark">
                        </div>
                        <div class="col-md-4 position-relative">
                            <div class="p-3 text-center">
                                <h1 class="text-gradient text-info"> <span id="state2" countTo="15">0</span>+</h1>
                                <h5 class="mt-3">Design Blocks</h5>
                                <p class="text-sm font-weight-normal">Mix the sections, change the colors and unleash your creativity</p>
                            </div>
                            <hr class="vertical dark">
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 text-center">
                                <h1 class="text-gradient text-info" id="state3" countTo="4">0</h1>
                                <h5 class="mt-3">Pages</h5>
                                <p class="text-sm font-weight-normal">Save 3-4 weeks of work when you use our pre-made pages for your website</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="my-5 py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5">
                    <div class="d-flex justify-content-center">
                        <dotlottie-wc
                            src="https://lottie.host/9b0e8da6-6240-434a-9c3d-9a196ede5cc0/AVrdUdRtsV.lottie"
                            style="width: 270px;height: 270px;"
                            autoplay
                            loop></dotlottie-wc>
                    </div>
                    <h2 class="text-info fw-bold custom-font">Tanya training center AI</h2>
                    <div class="mt-4">
                        <strong>
                            Punya pertanyaan tentang Training center? <b class="text-info">Tanyakan langsung</b><br>
                            ke asisten AI kami
                        </strong>
                    </div>
                    <p class="mt-3">Atau tanyakan ke <b>WhatsApp </b>pintar kami</p>
                    <a href="https://wa.me/628132024295?text=Halo%20Takumi%20training%20center"
                        class="btn btn-success btn-lg rounded-pill px-2 py-2 shadow-lg d-inline-flex align-items-center gap-3 text-white text-decoration-none"
                        style="font-size: 20px; font-weight: 600; background: linear-gradient(135deg, #258dd3ff, #00b7ffff); border: none;"
                        target="_blank">
                        <!-- Ikon WhatsApp -->
                        <i class="fa-brands fa-whatsapp ms-2" style="color: #ffffff;"></i>
                        <!-- Teks utama -->
                        <div class="text-start">
                            <small class="opacity-90 me-2">Online 24 Jam • Balas Otomatis</small>
                        </div>
                    </a>
                    <div class="container mt-3">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="d-flex align-items-center justify-content-center text-white rounded-3 bg-info bg-gradient" style="width:40px; height:40px;">
                                <i class="fas fa-bolt"></i>
                            </div>
                            <div class="fw-small fs-5">Respons real-time dengan akurat</div>
                        </div>
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="d-flex align-items-center justify-content-center text-white rounded-3 bg-danger bg-gradient" style="width:40px; height:40px;">
                                <i class="fas fa-database"></i>
                            </div>
                            <div class="fw-medium fs-5">Materi pelatihan lengkap dan terupdate</div>
                        </div>
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="d-flex align-items-center justify-content-center text-white rounded-3 bg-success bg-gradient" style="width:40px; height:40px;">
                                <i class="fas fa-database"></i>
                            </div>
                            <div class="fw-medium fs-5">Pelatihan interaktif dengan feedback instan</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 mt-lg-0 mt-4">
                    <div class="body_ai">
                        <div id="chat-wrapper">

                            <!-- HEADER -->
                            <div id="chat-header">
                                <i class="fa-solid fa-robot"></i>
                                Takumi Training Center AI Assistant
                            </div>

                            <!-- CHAT CONTAINER -->
                            <div id="chat-container">

                                <!-- CHAT BOX -->
                                <div id="chat-box"></div>

                                <!-- QUICK BUTTONS -->
                                <div id="popular-container">
                                    <div class="popular-item" onclick="sendQuick('Apa saja program pelatihan yang tersedia?')">
                                        <span class="popular-icon">📚</span> Program Pelatihan
                                    </div>
                                    <div class="popular-item" onclick="sendQuick('Bagaimana cara mendaftar?')">
                                        <span class="popular-icon">📝</span> Cara Daftar
                                    </div>
                                    <div class="popular-item" onclick="sendQuick('Berapa biaya?')">
                                        <span class="popular-icon">💰</span> Biaya
                                    </div>
                                    <div class="popular-item" onclick="sendQuick('Kapan jadwal pelatihan terbaru?')">
                                        <span class="popular-icon">📅</span> Jadwal
                                    </div>
                                </div>

                                <!-- INPUT -->
                                <div id="input-container">
                                    <input type="text" id="user-input" placeholder="Tanyakan sesuatu...">
                                    <button id="send-btn">Kirim</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <dotlottie-wc
                    src="https://lottie.host/3b5ed91e-0eaf-424e-bf73-aa843f3eb941/ZdYBLU2zea.lottie"
                    style="width: 300px;height: 300px"
                    autoplay
                    loop></dotlottie-wc>
            </div>
            <div class="col-md-9">
                <div class="vending-wrapper">

                    <div class="machine-header mb-4">
                        <form method="GET" class="d-flex align-items-center justify-content-center gap-3">
                            <span class="text-white fw-semibold">Pilih Mesin:</span>

                            <select name="mesin_id" class="select-modern" onchange="this.form.submit()">
                                <?php foreach ($mesins as $mesin): ?>
                                    <option value="<?= $mesin['id'] ?>" <?= $mesin['id'] == $selected_mesin_id ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($mesin['nama']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </form>
                    </div>

                    <div class="row vending-layout">

                        <!-- PRODUK -->
                        <div class="col-md-8 border-end product-area">

                            <div class="text-center mb-4">
                                <h2 class="fw-bold text-info mb-0">
                                    Mesin:
                                    <?= htmlspecialchars($mesins[array_search($selected_mesin_id, array_column($mesins, 'id'))]['nama']) ?>
                                </h2>
                                <p class="text-muted">Pilih produk favoritmu</p>
                            </div>

                            <div class="row g-3 product-grid">
                                <?php if (!empty($produk_tersedia)): ?>
                                    <?php foreach ($produk_tersedia as $p): ?>
                                        <div class="col-6 col-sm-6 col-md-4">
                                            <div class="card product-card">
                                                <img src="<?= htmlspecialchars($p['gambar']) ?>" class="card-img-top product-img">

                                                <div class="card-body text-center">
                                                    <h6 class="fw-semibold text-info"><?= htmlspecialchars($p['nama_produk']) ?></h6>
                                                    <p class="small text-secondary mb-1">Kode: <strong><?= htmlspecialchars($p['code']) ?></strong></p>
                                                    <p class="fw-bold text-dark mb-1">Rp <?= number_format($p['harga_produk'], 0, ',', '.') ?></p>

                                                    <?php if ($p['stock'] > 0): ?>
                                                        <p class="small text-secondary">Stock: <strong><?= $p['stock'] ?></strong></p>
                                                    <?php else: ?>
                                                        <p class="small text-danger fw-bold">Stock Habis</p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="text-center text-muted">Belum ada produk di mesin ini</div>
                                <?php endif; ?>
                            </div>

                        </div>

                        <!-- PANEL KONTROL -->
                        <!-- PANEL KONTROL -->
                        <div class="col-md-4 control-panel d-flex flex-column">

                            <!-- BOX INFO -->
                            <div class="control-box mb-3 text-center p-3 rounded shadow-sm">
                                <?= $message ?: '<div class="text-info fw-semibold">Masukkan kode produk (contoh: A1)</div>' ?>
                            </div>

                            <!-- FORM BELI -->
                            <div class="sticky-buy-box p-3 rounded shadow-sm mb-3">
                                <form action="?mesin_id=<?= $selected_mesin_id ?>" method="POST" class="mb-2">
                                    <div class="input-group">
                                        <input id="productCode" type="text" name="code" maxlength="2"
                                            class="form-control form-control-lg fw-bold text-center"
                                            placeholder="Kode..." readonly required>
                                        <button type="submit" name="buy" class="btn btn-info btn-lg fw-bold">Beli</button>
                                    </div>
                                </form>

                                <!-- Tombol hapus -->
                                <button id="clearBtn" class="btn btn-danger w-100 fw-bold">Hapus</button>
                            </div>

                            <!-- KEYPAD -->
                            <div class="keypad-wrapper mt-3 p-3 rounded shadow-sm">
                                <div class="row g-3">
                                    <?php foreach (["A", "B", "C", "1", "2", "3"] as $btn): ?>
                                        <div class="col-4">
                                            <button type="button" class="btn btn-keypad w-100 fw-bold py-3"
                                                data-value="<?= $btn ?>">
                                                <?= $btn ?>
                                            </button>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                        </div>

                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                const input = document.getElementById("productCode");
                                const clearBtn = document.getElementById("clearBtn");

                                // keypad click
                                document.querySelectorAll(".btn-keypad").forEach(btn => {
                                    btn.addEventListener("click", () => {
                                        let val = btn.getAttribute("data-value");

                                        // Maksimal 2 karakter (misal: A1, C3)
                                        if (input.value.length < 2) {
                                            input.value += val;
                                        }
                                    });
                                });

                                // Tombol Hapus
                                clearBtn.addEventListener("click", () => {
                                    input.value = "";
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<script>
    const chatBox = document.getElementById("chat-box");
    const input = document.getElementById("user-input");
    const btn = document.getElementById("send-btn");
    const API_URL = "http://localhost:3000/chat";

    /* ========= ADD MESSAGE ========= */
    function addMessage(content, type = "bot") {
        const div = document.createElement("div");
        div.className = "message " + (type === "bot" ? "bot-message" : "user-message");

        if (type === "bot") {
            div.innerHTML = `
      <div class="bot-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
	<g fill="none">
		<path d="m12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036q-.016-.004-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.016-.018m.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092q.019.005.029-.008l.004-.014l-.034-.614q-.005-.019-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01z" />
		<path fill="#fff" d="M9.107 5.448c.598-1.75 3.016-1.803 3.725-.159l.06.16l.807 2.36a4 4 0 0 0 2.276 2.411l.217.081l2.36.806c1.75.598 1.803 3.016.16 3.725l-.16.06l-2.36.807a4 4 0 0 0-2.412 2.276l-.081.216l-.806 2.361c-.598 1.75-3.016 1.803-3.724.16l-.062-.16l-.806-2.36a4 4 0 0 0-2.276-2.412l-.216-.081l-2.36-.806c-1.751-.598-1.804-3.016-.16-3.724l.16-.062l2.36-.806A4 4 0 0 0 8.22 8.025l.081-.216zM19 2a1 1 0 0 1 .898.56l.048.117l.35 1.026l1.027.35a1 1 0 0 1 .118 1.845l-.118.048l-1.026.35l-.35 1.027a1 1 0 0 1-1.845.117l-.048-.117l-.35-1.026l-1.027-.35a1 1 0 0 1-.118-1.845l.118-.048l1.026-.35l.35-1.027A1 1 0 0 1 19 2" />
	</g>
</svg></div>
      <div class="bot-text">${content}</div>
    `;
        } else {
            div.innerHTML = `
      <div class="user-text">${content}</div>
      <div class="user-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
	<circle cx="12" cy="6" r="4" fill="#fff" />
	<path fill="#fff" d="M20 17.5c0 2.485 0 4.5-8 4.5s-8-2.015-8-4.5S7.582 13 12 13s8 2.015 8 4.5" />
</svg></div>
    `;
        }

        chatBox.appendChild(div);

        requestAnimationFrame(() => {
            chatBox.scrollTop = chatBox.scrollHeight;
        });
    }

    /* ========= TYPING LOADER ========= */
    function addTyping() {
        if (document.getElementById("typing")) return;

        const div = document.createElement("div");
        div.className = "message bot-message";
        div.id = "typing";
        div.innerHTML = `
    <div class="bot-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
	<g fill="none">
		<path d="m12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036q-.016-.004-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.016-.018m.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092q.019.005.029-.008l.004-.014l-.034-.614q-.005-.019-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01z" />
		<path fill="#fff" d="M9.107 5.448c.598-1.75 3.016-1.803 3.725-.159l.06.16l.807 2.36a4 4 0 0 0 2.276 2.411l.217.081l2.36.806c1.75.598 1.803 3.016.16 3.725l-.16.06l-2.36.807a4 4 0 0 0-2.412 2.276l-.081.216l-.806 2.361c-.598 1.75-3.016 1.803-3.724.16l-.062-.16l-.806-2.36a4 4 0 0 0-2.276-2.412l-.216-.081l-2.36-.806c-1.751-.598-1.804-3.016-.16-3.724l.16-.062l2.36-.806A4 4 0 0 0 8.22 8.025l.081-.216zM19 2a1 1 0 0 1 .898.56l.048.117l.35 1.026l1.027.35a1 1 0 0 1 .118 1.845l-.118.048l-1.026.35l-.35 1.027a1 1 0 0 1-1.845.117l-.048-.117l-.35-1.026l-1.027-.35a1 1 0 0 1-.118-1.845l.118-.048l1.026-.35l.35-1.027A1 1 0 0 1 19 2" />
	</g>
</svg></div>
    <div class="bot-text">
      <div class="typing-wrapper">
        <span class="typing-dot"></span>
        <span class="typing-dot"></span>
        <span class="typing-dot"></span>
      </div>
    </div>
  `;

        chatBox.appendChild(div);
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    function removeTyping() {
        const t = document.getElementById("typing");
        if (t) t.remove();
    }

    /* ========= GREETING ========= */
    window.addEventListener("load", async () => {
        try {
            const res = await fetch("http://localhost:3000/greeting");
            const data = await res.json();
            addMessage(data.reply, "bot");
        } catch {
            addMessage("Halo! Saya Takumi AI 👋", "bot");
        }
    });

    /* ========= SEND MESSAGE ========= */
    async function sendMessage() {
        const msg = input.value.trim();
        if (!msg) return;

        addMessage(msg, "user");
        input.value = "";
        addTyping();

        try {
            const res = await fetch(API_URL, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    message: msg
                })
            });

            const data = await res.json();
            removeTyping();
            addMessage(data.reply, "bot");
        } catch {
            removeTyping();
            addMessage("⚠️ Server sedang sibuk, coba lagi ya.", "bot");
        }
    }

    /* ========= EVENTS ========= */
    btn.addEventListener("click", sendMessage);
    input.addEventListener("keydown", e => {
        if (e.key === "Enter") sendMessage();
    });

    /* QUICK BUTTON */
    function sendQuick(text) {
        input.value = text;
        sendMessage();
    }
</script>
<script
    src="https://unpkg.com/@lottiefiles/dotlottie-wc@0.8.5/dist/dotlottie-wc.js"
    type="module">
</script>






<!-- Footer Start -->

<?php include('./pembeli/layouts/footer.php'); ?>