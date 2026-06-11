# BUKU PANDUAN PENGGUNA (MANUAL BOOK)
## Sistem Informasi Evaluasi Baitul Arqam (ArqamApp)
*Sistem Pendukung Keputusan Evaluasi Kelulusan Menggunakan Metode AHP-SAW & Analisis Efektivitas Pembelajaran N-Gain*

---

## DAFTAR ISI
1. [BAB I: PENDAHULUAN](#bab-i-pendahuluan)
   - 1.1 Latar Belakang & Deskripsi Sistem
   - 1.2 Tujuan Sistem
   - 1.3 Hak Akses & Peran Pengguna (User Roles)
2. [BAB II: SPESIFIKASI & INSTALASI SISTEM](#bab-ii-spesifikasi--instalasi-sistem)
   - 2.1 Lingkungan Pengembangan (Development Stack)
   - 2.2 Panduan Instalasi Awal (Setup Project)
3. [BAB III: PANDUAN ADMINISTRATOR (ADMIN)](#bab-iii-panduan-administrator-admin)
   - 3.1 Manajemen Event Baitul Arqam
   - 3.2 Manajemen Data Peserta (Import & Sinkronisasi)
   - 3.3 Manajemen Data Fasilitator & Penugasan Kelompok
   - 3.4 Manajemen Bank Soal & Evaluasi Kognitif
   - 3.5 Presensi Kehadiran & Scanner QR-Code
   - 3.6 Penilaian Evaluasi Psikomotorik & Afektif
   - 3.7 Proses Perhitungan SPK (AHP-SAW) & Penentuan Predikat Kelulusan
   - 3.8 Ekspor Laporan Akhir (Excel & PDF)
   - 3.9 Audit Log & Pemeliharaan Sistem
4. [BAB IV: PANDUAN FASILITATOR (PENDAMPING KELOMPOK)](#bab-iv-panduan-fasilitator-pendamping-kelompok)
   - 4.1 Akses Event & Daftar Kelompok
   - 4.2 Manajemen Presensi Harian Kelompok
   - 4.3 Penilaian Psikomotorik Peserta Bimbingan
5. [BAB V: PANDUAN PESERTA (PARTICIPANT)](#bab-v-panduan-peserta-participant)
   - 5.1 Login Akun & Melengkapi Profil Mandiri
   - 5.2 Penggunaan QR-Code untuk Kehadiran
   - 5.3 Mengerjakan Ujian Kognitif (Pretest & Posttest)
   - 5.4 Pengisian Angket Afektif (Self-Assessment)
   - 5.5 Melihat Hasil Akhir & Analisis Nilai N-Gain
6. [BAB VI: PENJELASAN METODE & FORMULA MATEMATIS](#bab-vi-penjelasan-metode--formula-matematis)
   - 6.1 Analytical Hierarchy Process (AHP) untuk Pembobotan Kriteria
   - 6.2 Simple Additive Weighting (SAW) untuk Pemeringkatan Kelulusan
   - 6.3 Hake's N-Gain Score untuk Analisis Efektivitas Kognitif

---

## BAB I: PENDAHULUAN

### 1.1 Latar Belakang & Deskripsi Sistem
ArqamApp adalah sebuah platform web terintegrasi yang dirancang khusus untuk memfasilitasi evaluasi hasil pelaksanaan pelatihan keislaman dan kepemimpinan Baitul Arqam. Sistem ini memadukan konsep akademik evaluasi multi-kriteria berbasis **Sistem Pendukung Keputusan (SPK)** guna menentukan kelayakan kelulusan peserta secara objektif, adil, transparan, dan akuntabel.

### 1.2 Tujuan Sistem
- **Digitalisasi Proses**: Menggantikan pencatatan presensi, tes, dan penilaian manual ke dalam satu database terpusat.
- **Objektivitas Penilaian**: Menghilangkan bias penilaian subjektif melalui otomatisasi kalkulasi SPK menggunakan metode gabungan **AHP** (untuk pembobotan kriteria) dan **SAW** (untuk pemeringkatan akhir).
- **Pengukuran Kinerja**: Mengukur efektivitas peningkatan pemahaman kognitif peserta sebelum dan sesudah pelatihan menggunakan formula **Hake's Normalized Gain (N-Gain) Score**.

### 1.3 Hak Akses & Peran Pengguna (User Roles)
Sistem membedakan akses menu dan fungsi berdasarkan tiga peran utama:
1. **Administrator (Super User / Panitia Utama)**:
   - Akses penuh ke seluruh menu konfigurasi sistem.
   - Mengelola master data event, peserta, fasilitator, bank soal, bobot AHP, serta ekspor laporan.
2. **Fasilitator (FGD Facilitator)**:
   - Hak akses terbatas pada event dan kelompok peserta bimbingan yang ditugaskan kepada dirinya.
   - Menginput nilai praktik keagamaan (**Psikomotorik / C3**) untuk peserta yang dibimbingnya.
   - Melakukan presensi manual atau scan presensi kehadiran kelompok.
3. **Peserta (Training Participant)**:
   - Mengisi profil mandiri (termasuk upload foto resmi).
   - Melihat jadwal pelatihan secara real-time.
   - Mengisi angket penilaian sikap mandiri (**Afektif / C4**).
   - Mengerjakan ujian evaluasi pemahaman materi secara online (**Pretest & Posttest**).
   - Melihat rekap hasil kelulusan, nilai kriteria, serta metrik peningkatan N-Gain mereka secara privat.

---

## BAB II: SPESIFIKASI & INSTALASI SISTEM

### 2.1 Lingkungan Pengembangan (Development Stack)
Untuk menjalankan ArqamApp dengan optimal, spesifikasi server minimal yang dibutuhkan meliputi:
*   **Framework PHP**: Laravel 11.x (membutuhkan PHP >= 8.2)
*   **Web Server**: Apache / Nginx
*   **Database Management System**: MySQL 8.0+ atau MariaDB 10.4+
*   **Frontend Engine**: Tailwind CSS (UI Styling via CDN/Vite), Alpine.js (Reactive States), Font Awesome / Heroicons (Iconography)
*   **Dependency Managers**: Composer (PHP) & NPM (NodeJS untuk asset compilation)

### 2.2 Panduan Instalasi Awal (Setup Project)
Ikuti langkah-langkah di bawah ini untuk memasang project di lingkungan server lokal atau *hosting*:

1.  **Clone Project & Install Dependencies**
    ```bash
    git clone https://github.com/ZAKITRIPAMUNGKAS/skp.git
    cd skp
    composer install
    npm install && npm run build
    ```
2.  **Konfigurasi Environment (`.env`)**
    Salin berkas `.env.example` menjadi `.env` kemudian sesuaikan konfigurasi koneksi database Anda:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=db_sistem_evaluasi
    DB_USERNAME=root
    DB_PASSWORD=
    ```
3.  **Generate Application Key & Symbolic Link**
    ```bash
    php artisan key:generate
    php artisan storage:link
    ```
4.  **Migrasi Database & Seeding Data Awal**
    Jalankan migrasi untuk membuat tabel relasional dan mengisikan data awal (seeds) kriteria, akun admin default, dan parameter sistem:
    ```bash
    php artisan migrate:fresh --seed
    ```
5.  **Menjalankan Server Lokal**
    ```bash
    php artisan serve
    ```
    Akses aplikasi melalui browser Anda di URL: `http://127.0.0.1:8000`.

---

## BAB III: PANDUAN ADMINISTRATOR (ADMIN)

### 3.1 Manajemen Event Baitul Arqam
*   **Akses Menu**: Masuk ke sidebar kiri -> **Kelola Event**.
*   **Membuat Event Baru**: 
    1. Klik tombol **+ Buat Event Baru** di pojok kanan atas.
    2. Isi formulir pembuatan event: Nama Event, Tanggal Pelaksanaan, Tempat/Lokasi, Batas Kuota, dan Deskripsi Pelatihan.
    3. Klik **Simpan**.
*   **Detail Event**: Di dalam detail event terdapat tab pemantauan khusus:
    - **Detail**: Informasi umum event.
    - **Peserta**: Mengelola daftar peserta terdaftar.
    - **Fasilitator**: Memetakan instruktur pendamping kelompok.
    - **Sesi Jadwal**: Menyusun linimasa materi kegiatan.
    - **Laporan Akhir**: Tab komputasi AHP-SAW, rekapitulasi nilai, serta tombol cetak laporan.

### 3.2 Manajemen Data Peserta (Import & Sinkronisasi)
*   **Akses Menu**: Sidebar -> **Kelola Peserta** ATAU tab **Peserta** di dalam Detail Event.
*   **Import Massal via Excel**:
    1. Unduh template Excel yang disediakan pada tombol **Unduh Template** agar struktur kolom tidak mengalami galat (error).
    2. Masukkan data nama, email, username default, jenis kelamin, instansi, dan kelompok peserta pada berkas Excel tersebut.
    3. Klik **Import Excel**, unggah file yang telah diisi, lalu kirimkan. Akun login peserta akan otomatis terbuat menggunakan email/username yang terdaftar.

### 3.3 Manajemen Data Fasilitator & Penugasan Kelompok
*   **Akses Menu**: Sidebar -> **Kelola Fasilitator**.
*   **Registrasi Akun Fasilitator**: Masukkan nama lengkap, username, email, dan password awal.
*   **Plotting Penugasan**: Pada halaman Detail Event -> tab **Fasilitator**, tentukan fasilitator mana saja yang bertugas mendampingi event ini dan tentukan kelompok mana yang berada di bawah bimbingannya.

### 3.4 Manajemen Bank Soal & Ujian Kognitif
*   **Akses Menu**: Sidebar -> **Bank Soal**.
*   **Penyusunan Butir Soal**:
    1. Admin dapat membuat soal pilihan ganda (multiple choice) beserta kunci jawaban (A, B, C, D, E).
    2. Tentukan bobot dari masing-masing soal (secara umum bernilai sama, misalnya jika total 20 soal maka 1 soal bernilai 5 poin untuk skala 100).
    3. Ujian kognitif terbagi menjadi 2 tahap: **Pretest** (sebelum pelatihan dimulai) dan **Posttest** (setelah seluruh materi berakhir) guna mengukur peningkatan kognisi peserta.

### 3.5 Presensi Kehadiran & Scanner QR-Code
*   **Akses Menu**: Detail Event -> tab **Sesi Jadwal**.
*   **Cara Melakukan Presensi**:
    1. Klik detail pada salah satu sesi jadwal kegiatan yang aktif.
    2. Admin dapat mengklik tombol **Buka Scan QR** untuk menggunakan kamera laptop/ponsel guna memindai QR-Code unik milik peserta.
    3. Alternatif lain: Admin dapat menandai kehadiran secara manual (Hadir, Izin, Alpa) melalui daftar tabel peserta di bawahnya jika kamera scanner mengalami kendala teknis.

### 3.6 Penilaian Evaluasi Psikomotorik & Afektif
*   **Psikomotorik (C3)**: Kriteria ini dinilai oleh Fasilitator pendamping kelompok bimbingan masing-masing atau di-override oleh Admin. Terdiri atas:
    - Praktik Wudhu & Tayamum
    - Gerakan & Bacaan Shalat
    - Praktik Thaharah / Penyelenggaraan Jenazah
*   **Afektif (C4)**: Dinilai secara mandiri oleh peserta melalui kuesioner *self-assessment* perilaku utama keaktifan forum, kedisiplinan shalat jamaah tepat waktu, serta kesopanan/etika berkomunikasi selama kegiatan pelatihan.

### 3.7 Proses Perhitungan SPK (AHP-SAW)
*   **Akses Menu**: Detail Event -> tab **Laporan Akhir**.
*   **Langkah Komputasi Sistem**:
    1. **Matriks Perbandingan AHP**: Admin menginput tingkat kepentingan kriteria pada matriks pairwise comparison (misal: Kognitif dibanding Afektif). Sistem otomatis menghitung Eigenvector untuk mendapatkan bobot global ($W_j$) dan mengecek nilai Consistency Ratio (CR) agar bernilai < 0.1 (Konsisten).
    2. **Normalisasi SAW**: Nilai riil kriteria masing-masing peserta ($X_{ij}$) dinormalisasi berdasarkan jenis kriteria (karena seluruh kriteria merupakan kriteria keuntungan/benefit, maka menggunakan rumus pembagian nilai peserta dengan nilai tertinggi pada kelompok event tersebut).
    3. **Penjumlahan Terbobot (Peringkat)**: Skor normalisasi ($R_{ij}$) dikalikan dengan bobot kriteria AHP ($W_j$) untuk menghasilkan nilai preferensi akhir ($V_i$) yang berkisar antara 0 s.d 100.
    4. **Predikat Kelulusan**: Berdasarkan nilai akhir tersebut, peserta diklasifikasikan ke dalam predikat:
       - **Lulus Utama** (Skor >= 80)
       - **Lulus Madya** (Skor 65 - 79.9)
       - **Lulus Dasar** (Skor 50 - 64.9)
       - **Ditangguhkan / Tidak Lulus** (Skor < 50)

### 3.8 Ekspor Laporan Akhir (Excel & PDF)
*   Melalui tab **Laporan Akhir**, admin dapat mengklik:
    - **Ekspor Excel**: Menghasilkan berkas `.xlsx` lengkap berisi data kriteria mentah, hasil normalisasi, nilai akhir preferensi, predikat kelulusan, serta skor N-Gain masing-masing peserta.
    - **Cetak Laporan (PDF)**: Menghasilkan dokumen laporan resmi berformat PDF yang siap dicetak dan ditandatangani oleh pimpinan penyelenggara.

### 3.9 Audit Log & Pemeliharaan Sistem
*   **Log Aktivitas**: Sidebar -> **Log Aktivitas**. Admin dapat melacak riwayat tindakan pengguna di dalam sistem (siapa yang mengubah nilai, menghapus data peserta, atau mengubah konfigurasi bobot kriteria) demi aspek keamanan data (*data auditability*).

---

## BAB IV: PANDUAN FASILITATOR (PENDAMPING KELOMPOK)

### 4.1 Akses Event & Daftar Kelompok
*   Saat Fasilitator login, halaman utama akan langsung menampilkan daftar Event Baitul Arqam aktif yang menugaskan dirinya.
*   Fasilitator dapat mengklik event tersebut untuk melihat daftar peserta yang tergabung di dalam **Kelompok Bimbingan**-nya.

### 4.2 Manajemen Presensi Harian Kelompok
*   Pada halaman detail event bimbingan, fasilitator dapat mencatatkan kehadiran peserta secara cepat per sesi materi untuk memastikan tidak ada peserta kelompoknya yang membolos tanpa keterangan yang sah.

### 4.3 Penilaian Psikomotorik Peserta Bimbingan
*   Fasilitator bertugas mengevaluasi aspek keterampilan ibadah praktis (**Kriteria C3**).
*   Pilih nama peserta bimbingan, klik **Input Nilai Praktik**, kemudian masukkan nilai pada form parameter penilai wudhu/tayamum, bacaan shalat, dan perawatan jenazah (skala 0 - 100).
*   Sistem akan secara otomatis menyinkronkan data nilai ini ke basis data pusat untuk digunakan dalam perhitungan SPK oleh Admin.

---

## BAB V: PANDUAN PESERTA (PARTICIPANT)

### 5.1 Login Akun & Melengkapi Profil Mandiri
*   Peserta login menggunakan kredensial berupa Username / Email dan Password yang telah dibagikan oleh panitia pelaksana.
*   Pada saat login pertama kali, peserta diwajibkan mengakses halaman **Profil Saya** untuk:
    - Melengkapi identitas instansi, nomor telepon, dan nomor induk.
    - Mengunggah foto profil formal dengan format rasio 3:4 atau 1:1 guna memudahkan pencetakan sertifikat/kartu presensi kelak.

### 5.2 Penggunaan QR-Code untuk Kehadiran
*   Halaman utama (Dashboard) peserta memuat **QR-Code Unik** yang menempel pada data profilnya.
*   Pada setiap awal sesi materi kegiatan, peserta cukup menunjukkan layar ponselnya yang menampilkan QR-Code tersebut kepada panitia/fasilitator untuk dipindai. Proses ini akan otomatis mengubah status presensi mereka menjadi **Hadir** pada basis data sistem.

### 5.3 Mengerjakan Ujian Kognitif (Pretest & Posttest)
*   **Pretest**: Tersedia di dashboard pada hari pertama sebelum materi pelatihan disampaikan oleh narasumber.
*   **Posttest**: Tersedia di dashboard pada hari terakhir pelatihan setelah seluruh rangkaian materi selesai.
*   Peserta harus mengklik tombol **Mulai Ujian**, mengerjakan butir soal pilihan ganda di dalam batas waktu yang ditentukan, dan mengklik **Selesai** untuk mengirimkan jawaban. Nilai akhir kognitif akan langsung terhitung secara otomatis setelah ujian dikirim.

### 5.4 Pengisian Angket Afektif (Self-Assessment)
*   Peserta mengakses menu **Evaluasi Afektif** pada sidebar atau menu bawah.
*   Isi butir-butir kuisioner refleksi sikap/perilaku dengan memilih skala kesiapan dan perilaku ibadah harian mereka secara jujur. Nilai angket ini akan dikonversi menjadi indeks **Kriteria C4 (Afektif)**.

### 5.5 Melihat Hasil Akhir & Analisis Nilai N-Gain
*   Setelah panitia melakukan penutupan event dan menghitung kelulusan, peserta dapat mengakses menu **Hasil Penilaian**.
*   Pada halaman tersebut, peserta dapat melihat:
    - Skor detail per kriteria (Kognitif, Afektif, Psikomotorik, Kehadiran).
    - Nilai Preferensi Akhir dan Predikat Kelulusan (Lulus Utama / Madya / Dasar / Ditangguhkan).
    - **Analisis Peningkatan Kognitif (N-Gain Score)**: Menunjukkan persentase efektivitas peningkatan pemahaman materi dari hasil Pretest ke Posttest mereka.

---

## BAB VI: PENJELASAN METODE & FORMULA MATEMATIS

Sebagai landasan ilmiah penulisan skripsi atau dokumentasi akademik, sistem ini menggunakan tiga pilar komputasi matematis berikut:

### 6.1 Analytical Hierarchy Process (AHP) untuk Pembobotan Kriteria
Metode AHP digunakan untuk menentukan nilai bobot dari masing-masing kriteria evaluasi secara objektif melalui perbandingan berpasangan (*pairwise comparison*):

1.  **Matriks Perbandingan Berpasangan ($A$)**:
    $$A = \begin{bmatrix} 
    a_{11} & a_{12} & \dots & a_{1n} \\
    a_{21} & a_{22} & \dots & a_{2n} \\
    \vdots & \vdots & \ddots & \vdots \\
    a_{n1} & a_{n2} & \dots & a_{nn}
    \end{bmatrix}$$
    Di mana $a_{ij}$ adalah tingkat kepentingan kriteria $i$ dibandingkan dengan kriteria $j$ berdasarkan skala perbandingan Saaty (1-9).
2.  **Menghitung Eigenvector (Bobot Prioritas $W$)**:
    Eigenvector dihitung dengan menormalisasi setiap kolom matriks $A$, kemudian mencari nilai rata-rata baris:
    $$w_i = \frac{1}{n} \sum_{j=1}^{n} \frac{a_{ij}}{\sum_{k=1}^{n} a_{kj}}$$
3.  **Uji Konsistensi (Consistency Ratio - CR)**:
    Menghitung Eigenvalue Maksimum ($\lambda_{max}$):
    $$\lambda_{max} = \frac{1}{n} \sum_{i=1}^{n} \frac{(A \cdot W)_i}{w_i}$$
    Menghitung Consistency Index (CI):
    $$CI = \frac{\lambda_{max} - n}{n - 1}$$
    Menghitung Consistency Ratio (CR) dengan membandingkan CI terhadap Random Index (RI):
    $$CR = \frac{CI}{RI}$$
    *Syarat mutlak: Nilai CR harus kurang dari $0.1$ ($10\%$) agar pembobotan dianggap valid dan konsisten.*

---

### 6.2 Simple Additive Weighting (SAW) untuk Pemeringkatan Kelulusan
Metode SAW mencari penjumlahan terbobot dari kinerja rating pada setiap alternatif di semua kriteria.

1.  **Normalisasi Matriks Keputusan ($R$)**:
    Karena seluruh kriteria pada ArqamApp bersifat keuntungan (*benefit*), maka dinormalisasi menggunakan rumus:
    $$r_{ij} = \frac{x_{ij}}{max(x_{ij})}$$
    Di mana:
    - $r_{ij}$ adalah nilai rating kinerja ternormalisasi dari alternatif $A_i$ pada kriteria $C_j$.
    - $x_{ij}$ adalah nilai asli kriteria alternatif $A_i$ pada kriteria $C_j$.
    - $max(x_{ij})$ adalah nilai terbesar dari semua alternatif pada kriteria $C_j$ di dalam event tersebut.
2.  **Perhitungan Nilai Preferensi Akhir ($V_i$)**:
    Nilai akhir dari setiap alternatif peserta dihitung dengan rumus:
    $$V_i = \sum_{j=1}^{n} w_j \cdot r_{ij}$$
    Di mana:
    - $V_i$ adalah nilai akhir peserta ke-$i$.
    - $w_j$ adalah bobot kriteria ke-$j$ yang diperoleh dari hasil perhitungan metode AHP.
    - $r_{ij}$ adalah nilai kriteria ternormalisasi peserta ke-$i$ pada kriteria ke-$j$.
    *Skor V_i ini berkisar antara 0 - 100 yang menentukan predikat kelulusan peserta.*

---

### 6.3 Hake's Normalized Gain (N-Gain) Score untuk Analisis Efektivitas Kognitif
Analisis N-Gain digunakan untuk mendeteksi efisiensi pemahaman materi pelatihan dengan mengukur selisih antara nilai ujian awal (*pretest*) dan nilai ujian akhir (*posttest*).

1.  **Rumus N-Gain Score**:
    $$G = \frac{\text{Skor Posttest} - \text{Skor Pretest}}{\text{Skor Maksimum} - \text{Skor Pretest}}$$
    Di mana $\text{Skor Maksimum}$ bernilai $100$.
2.  **Klasifikasi Nilai Gain Terhadap Efektivitas**:
    Skor N-Gain yang diperoleh dikategorikan menurut kriteria Hake sebagai berikut:
    - **N-Gain $> 0.7$**: Efektivitas Peningkatan **Tinggi** (Paham Optimal)
    - **$0.3 \le \text{N-Gain} \le 0.7$**: Efektivitas Peningkatan **Sedang** (Paham Cukup)
    - **N-Gain $< 0.3$**: Efektivitas Peningkatan **Rendah** (Kurang Paham)
3.  **Persentase Efektivitas N-Gain**:
    $$\text{Efektivitas (\%)} = \text{N-Gain Score} \times 100\%$$
    Klasifikasi Tafsiran Efektivitas:
    - **$> 76\%$**: Sangat Efektif
    - **$56\% - 75\%$**: Efektif
    - **$40\% - 55\%$**: Cukup Efektif
    - **$< 40\%$**: Tidak Efektif

---
*Dokumen ini dibuat secara resmi untuk mendampingi implementasi kode program ArqamApp v2.0.*
