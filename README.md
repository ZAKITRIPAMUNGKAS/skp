# ARQAM App — Sistem Evaluasi Perkaderan Baitul Arqam

Aplikasi web penilaian peserta Perkaderan Muhammadiyah berbasis **Laravel 10**, **Blade**, **Tailwind CSS**, **Alpine.js**, dan **MySQL**.

---

## Deskripsi Aplikasi

ARQAM App adalah sistem evaluasi peserta kegiatan Baitul Arqam (perkaderan Muhammadiyah) yang mencakup:

- **Manajemen Event** — CRUD event beserta sesi dan peserta
- **QR Attendance** — Absensi peserta via scan QR Code
- **Pretest & Posttest** — Soal pilihan ganda dengan timer dan auto-save
- **Penilaian Afektif** — Skala Likert (SS/S/TS/STS) per sub-aspek
- **Penilaian Psikomotor** — Mass scoring oleh admin (Outbound + Ibadah)
- **Angket Penyelenggaraan** — Survei kepuasan peserta (A/B/C/D)
- **AHP (Analytic Hierarchy Process)** — Penentuan bobot kriteria
- **SAW (Simple Additive Weighting)** — Ranking peserta
- **Laporan PDF** — Multi-halaman otomatis

---

## Struktur Modul

| Modul | Deskripsi |
|-------|-----------|
| Event Management | CRUD event, sesi, peserta, ID card |
| Attendance | Scan QR dark-mode, realtime counter |
| Pretest/Posttest | Soal management, timer, localStorage, scoring |
| Afektif | Sub-aspek dengan butir pernyataan Likert |
| Psikomotor | Mass scoring table (Outbound 4 + Ibadah 3) |
| Angket | 27 item, 8 kategori, komentar bebas |
| AHP | Matriks pairwise 5×5, eigenvector, CI/CR |
| SAW | Normalisasi benefit, Vi = Σ(wj × rij) |
| Laporan | PDF cover, biodata, nilai, ranking, grafik |

---

## Cara Instalasi

```bash
# Clone repository
git clone <repo-url>
cd SISTEM

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Configure database in .env
DB_DATABASE=arqam_db
DB_USERNAME=root
DB_PASSWORD=

# Run migrations
php artisan migrate

# Seed default data (optional)
php artisan db:seed

# Build assets
npm run build

# Start server
php artisan serve
```

---

## Cara Menghitung Ranking

### 1. Pastikan Data Lengkap
- Semua peserta memiliki nilai: Pretest, Posttest, Afektif, Psikomotor, Kehadiran

### 2. Atur Bobot AHP
- Buka tab **AHP-SAW** pada halaman event
- Isi matriks perbandingan berpasangan 5×5
- Pastikan **CR ≤ 0.1** (konsisten)
- Klik **Simpan Bobot**

### 3. Hitung Ranking SAW
- Pindah ke sub-tab **Ranking SAW**
- Klik **Hitung Ranking**
- Sistem akan:
  1. Normalisasi nilai (benefit: rij = xij / max)
  2. Kalikan dengan bobot AHP
  3. Hitung Vi = Σ(wj × rij)
  4. Urutkan berdasarkan skor tertinggi
  5. Tentukan predikat (Amat Baik / Baik / Cukup / Kurang)

### 4. Predikat
| Skor | Predikat |
|------|----------|
| ≥ 0.85 | Amat Baik |
| ≥ 0.70 | Baik |
| ≥ 0.55 | Cukup |
| < 0.55 | Kurang |

---

## Cara Generate Laporan

1. Buka halaman event → tab **Laporan**
2. Pilih jenis laporan:
   - **Laporan Evaluasi Lengkap** — PDF multi-halaman
   - **Cetak Ranking** — Ctrl+P langsung dari browser
   - **Laporan Angket** — Rekap survei
   - **Export Excel** — Data nilai lengkap

---

## Tech Stack

- **Backend:** Laravel 10, PHP 8.1+
- **Frontend:** Blade, Tailwind CSS, Alpine.js
- **Database:** MySQL
- **Font:** Inter (body), Poppins (heading)

---

## Lisensi

© 2026 — ARQAM App. Dibangun untuk keperluan skripsi.
