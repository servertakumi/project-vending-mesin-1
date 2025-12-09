import express from "express";
import cors from "cors";
import bodyParser from "body-parser";
import ollama from "ollama"; // Ganti OpenAI jadi ini
import mysql from "mysql2/promise";
import dotenv from "dotenv";

dotenv.config();

const takumiRegex = /(trimakasih|trima kasih|terima kasih|terimakasih|halo|helo|hallo|hai|takumi|politeknik takumi|kuliah|pelatihan|training|program|jurusan|biaya|beasiswa|pendaftaran|daftar|jepang|magang|kerja ke jepang)/i;

const app = express();
const port = 3000;

app.use(cors());
app.use(bodyParser.json());

// Database sama kayak sebelumnya
const db = await mysql.createPool({
  host: "localhost",
  user: "root",
  password: "",
  database: "training_center"
});

// OLLAMA CLIENT (GRATIS LOCAL!)
const ollamaClient = {
  chat: async (messages, options = {}) => {
    const prompt = messages.map(m => `${m.role === 'user' ? 'User' : 'Assistant'}: ${m.content}`).join('\n');
    const response = await ollama.chat({
      model: 'llama3.2', // Ganti model kalau mau (gratis: llama3.2, mistral, dll)
      messages: [{ role: 'user', content: prompt }],
      options: { temperature: 0.7, ...options }
    });
    return { choices: [{ message: { content: response.message.content } }] };
  }
};

const memory = {};
const MAX_MEMORY = 20;

app.get("/greeting", (req, res) => {
  const userId = req.ip;
  if (!memory[userId]) memory[userId] = [];

  const greeting = `✨ Selamat Datang di Takumi Training Center! ✨  
Saya adalah AI Assistant resmi yang siap membantu menjawab semua pertanyaanmu seputar pelatihan, pendaftaran, biaya, dan karier ke Jepang.  
Ada yang bisa dibantu hari ini? 😊`;

  memory[userId].push({ role: "assistant", content: greeting });
  res.json({ reply: greeting.trim() });
});

app.post("/chat", async (req, res) => {
  const { message } = req.body;
  if (!message || message.trim() === "") return res.json({ reply: "Silakan ketik pertanyaan." });

  const userId = req.ip;
  if (!memory[userId]) memory[userId] = [];

  if (memory[userId].length > MAX_MEMORY) {
    memory[userId] = memory[userId].slice(-MAX_MEMORY);
  }

  let reply = "";

  try {
    // Cek pelatihan spesifik (sama kayak sebelumnya)
    const [pelatihanSpesifik] = await db.query(
      "SELECT * FROM pelatihan WHERE LOWER(nama_pelatihan) LIKE ? LIMIT 1",
      [`%${message.toLowerCase()}%`]
    );

    // === DETAIL PELATIHAN — HANYA 1 YANG DIPANGGIL, NGGAK PERNAH BAWA DAFTAR SEMUA ===
    if (/detail|info|jelasin|ceritain|tentang|apa itu/i.test(message) && /pelatihan|program|kursus|kelas|training/i.test(message)) {

      // Ekstrak nama pelatihan setelah kata kunci (contoh: "detail pelatihan digital marketing" → "digital marketing")
      const match = message.match(/(?:detail|info|jelasin|ceritain|tentang|apa itu)\s*(?:pelatihan|program|kursus|kelas|training)?\s*([^?.!,]*)/i);
      const namaDicari = match ? match[1].trim() : "";

      // Kalau user cuma ketik "detail pelatihan" tanpa nama → minta nama yang jelas
      if (!namaDicari || namaDicari.length < 2) {
        reply = `Maaf, nama pelatihan yang kamu maksud belum jelas 😊\n\nContoh:\n• detail pelatihan digital marketing\n• info bahasa jepang\n• jelasin web development`;
        memory[userId].push({ role: "assistant", content: reply });
        return res.json({ reply });
      }

      // Cari EXACTLY pelatihan yang diminta (pakai LIKE biar tetap fleksibel)
      const [rows] = await db.query(`
    SELECT * FROM pelatihan 
    WHERE status_pelatihan = 'Aktif' 
      AND LOWER(nama_pelatihan) LIKE ? 
    LIMIT 1
  `, [`%${namaDicari.toLowerCase()}%`]);

      // KETEMU → TAMPILKAN HANYA 1 DETAIL INI AJA
      if (rows.length > 0) {
        const p = rows[0];

        reply = `
            <h3 style="color:#258dd3ff; margin-top:0; margin-bottom:15px;">${p.nama_pelatihan}</h3>
            
            ${p.deskripsi_lengkap ? `<p><strong>Deskripsi:</strong><br>${p.deskripsi_lengkap}</p>` :
            p.deskripsi_pelatihan ? `<p><strong>Deskripsi:</strong><br>${p.deskripsi_pelatihan}</p>` :
              `<p><strong>Deskripsi:</strong><br>Pelatihan berkualitas tinggi bersama instruktur berpengalaman.</p>`}
            
            <p><strong>Level:</strong> ${p.level_pelatihan || "Semua Level"}</p>
            <p><strong>Durasi:</strong> ${p.tanggal_mulai || "-"} - ${p.tanggal_selesai}</p>
            <p><strong>Jadwal:</strong> ${p.jadwal || "Segera dibuka"}</p>
            <p><strong>Instruktur:</strong> ${p.instruktur_pelatihan || "Instruktur profesional"}</p>
            <p><strong>Biaya:</strong> Rp ${Number(p.harga_pelatihan).toLocaleString("id-ID")}</p>

            <div style="margin-top:25px; text-align:center;">
              <a href="register?page" style="background:#258dd3ff; color:white; padding:14px 28px; text-decoration:none; border-radius:8px; font-weight:bold; font-size:16px; margin:0 8px;">
                Daftar Sekarang
              </a>
              <a href="https://wa.link/s283dz" style="background:#00b7ffff; color:white; padding:14px 24px; text-decoration:none; border-radius:8px; font-size:16px; margin:0 8px;">
                Chat WA Marketing
              </a>
            </div>`;

        memory[userId].push({ role: "assistant", content: reply });
        return res.json({ reply });
      }

      // NGGAK KETEMU → HANYA BILANG BELUM ADA (TANPA BAWA DAFTAR LAIN!)
      else {
        reply = `Mohon maaf, pelatihan "<strong>${namaDicari.charAt(0).toUpperCase() + namaDicari.slice(1)}</strong>" belum tersedia saat ini.\n\nKalau nanti dibuka, saya langsung kabari kamu yang pertama ya!`;
        memory[userId].push({ role: "assistant", content: reply });
        return res.json({ reply });
      }
    }

    // Cek biaya (sama)
    if (/biaya|harga|uang|pembayaran|berapa/i.test(message)) {
      const [rows] = await db.query("SELECT * FROM pelatihan WHERE status_pelatihan = 'Aktif'");
      if (rows.length > 0) {
        reply = `
          <strong>Biaya Pelatihan Takumi (Per Semester)</strong><br><br>
          ${rows.map(p => `• <strong>${p.nama_pelatihan}</strong>: Rp ${Number(p.harga_pelatihan).toLocaleString("id-ID")}`).join("<br>")}
          <br><br>
          Catatan penting:<br>
          • Tersedia beasiswa hingga 100%<br>
          • Diskon early bird Gelombang 1 sampai 75%<br>
          • Cicilan 0% tersedia<br><br>
          Daftar sekarang di: <a href="https://pmb.takumi.ac.id">pmb.takumi.ac.id</a><br>
          Atau chat langsung: <a href="https://wa.me/6282258868305">WA Marketing</a>
        `;
        memory[userId].push({ role: "assistant", content: reply });
        return res.json({ reply });
      }
    }
    // ===== DAFTAR PELATIHAN / PROGRAM =====
    else if (/pelatihan|program|jurusan|ada apa|kelas apa|daftar pelatihan|program apa/i.test(message)) {
      const [rows] = await db.query("SELECT * FROM pelatihan WHERE status_pelatihan='Aktif'");
      if (rows.length === 0) {
        reply = "Belum ada pelatihan aktif saat ini.";
      } else {
        reply = `
          <div>
              <p>Haloooo 👋👋👋</p>
              <p>Senang sekali bisa membantu Anda hari ini 😊</p>
              <p>
                  Di Training center takumi,Kami memilika pelatuhan yang yang dirancang untuk membekaliagar
                  Anda dengan keterampilan yang siappakai di induster. Berikut adalah program pelatihan yang tersedia:
                  </p>
                  <div class="mt-3 ms-3">
                    ${rows.map(p => `
                        <li>
                          <p><b>${p.nama_pelatihan}</b>: ${p.keterangan_pelatihan}</p>
                        </li>
                    `).join("")}
                  </div>
              <div class="mt-3">
                <p>Semua program pelatihan kami memiliki keunggulan belajar Bahasa Jepang lho, takuminasan! Ditambah lagi,
                    kami punya kerjasama dengan lebih dari 1.000 perusahaan Jepang, jadi peluang magang dan kerja di Jepang sangat terbuka lebar.</p>
                <p>Mau tahu lebih detail tentang setiap program studi? Anda bisa klik link ini: https://takumi.ac.id/program-studi/
                </p>
              </div>
          </div>`;
      }
      memory[userId].push({ role: "assistant", content: reply });
      return res.json({ reply });

    } // <--- INI KURUNG KURAWAL YANG WAJIB ADA!

    // ===== TOPIK TAKUMI → PAKAI OLLAMA (GRATIS + CEPAT) =====
    else if (takumiRegex.test(message)) {

      const systemPrompt = `Kamu adalah chatbot resmi Takumi Training Center (panggil: Takumi-san).

        ATURAN WAJIB:
        1. Hanya jawab tentang:
          - Program pelatihan Politeknik Takumi
          - Pendaftaran & PMB
          - Biaya, beasiswa, fasilitas  
          - Magang dan kerja ke Jepang

        2. Bahasa Indonesia yang ramah, profesional, singkat, dan jelas.
        3. Dilarang bahas politik, gosip, hiburan, atau opini pribadi.
        4. Kalau pertanyaan di luar Takumi → jawab sopan + arahkan ke WA: https://wa.me/6282258868305

        FORMAT:
        - Maksimal 3 paragraf
        - Gunakan emoji secukupnya
        - Gunakan paragraf yang rapih dan mudah di baca
        - Jangan ulang-ulang kalimat
        - menjawab terimakasih dengan porfesional
        - jawab lah dengan formal dan profesional`
        ;

      const messages = [
        { role: "system", content: systemPrompt },
        ...memory[userId].slice(-15), // ambil 10 chat terakhir biar ingat konteks
        { role: "user", content: message }
      ];

      try {
        // PAKAI OLLAMA (GRATIS SELAMANYA)
        const response = await ollama.chat({
          model: "qwen2.5:3b", // CEPAT BANGET (atau ganti: llama3.2 / qwen2.5:3b)
          messages: messages.map(m => ({ role: m.role, content: m.content }))
        });

        reply = response.message.content.trim();

        // Simpan ke memory
        memory[userId].push({ role: "user", content: message });
        memory[userId].push({ role: "assistant", content: reply });

        console.log(`\nUser (${userId}): ${message}`);
        console.log(`Takumi AI: ${reply}\n`);

        return res.json({ reply });

      } catch (err) {
        console.error("Ollama error:", err.message);
        reply = "Maaf, saya sedang sedikit sibuk. Coba lagi dalam 10 detik ya! Atau langsung hubungi admin: https://wa.me/6282258868305";
        return res.json({ reply });
      }
    }

    // Fallback luar topik (sama)
    else {
       const topic = (message);
      reply = `
    <div>
      <strong>
        Halo takuminasan! 👋
      </strong>

      <p>
       Wah, pertanyaan Anda menarik sekali! 😊<br>
        Mengenai <b>${topic}</b>, mohon maaf sekali,
        saya sebagai <b>Takumi training center AI</b> belum memiliki
        informasi spesifik mengenai hal tersebut.
      </p>

      <p>
        Fokus saya adalah membantu memberikan informasi seputar
        <b>Takumi rtaining center</b>, seperti:
      </p>

      <ul>
        <li>pelatihan</li>
        <li>Biaya pelatihan</li>
        <li>Pendaftaran</li>
        <li>Cara daftar</li>
      </ul>

      <p>
        ✨ <b>Kabar Baik!</b><br>
        Pendaftaran pelatihan
        <b>Takumi training center Tahun Akademik 2026–2027</b>
        telah dibuka.
      </p>

      <ul>
        <li>🎓 Beasiswa hingga <b>100%</b></li>
        <li>🛠 Sistem <b>Learning by Doing</b></li>
        <li>🌏 Standar lulusan Global</li>
        <li>🇯🇵 Kesempatan berkarier ke Jepang</li>
      </ul>

      <p>
        Jika Anda tertarik untuk meraih mimpi berkarier,
        saya siap membantu 😊
      </p>

      <p>
        <b>Daftar sekarang:</b>
        <a href="https://pmb.takumi.ac.id" target="_blank">
          https://pmb.takumi.ac.id
        </a><br>

        <b>Hubungi Marketing:</b>
        <a href="https://wa.link/s283dz" target="_blank">
          klik di sini
          </a>
          </p>
          </div>
          `;
      memory[userId].push({ role: "assistant", content: reply });
      return res.json({ reply });
    }

  } catch (err) {
    console.error("Error Ollama:", err.message);
    res.json({ reply: "Maaf, sistem lokal sedang disetup. Coba lagi ya!" });
  }
});

app.get("/", (_, res) => {
  res.send("Takumi AI Server + Ollama GRATIS berjalan!");
});

app.listen(port, () => {
  console.log(`Server Takumi AI (Ollama Gratis) jalan di http://localhost:${port}`);
  console.log("Full gratis, no API key needed! 🚀");
});