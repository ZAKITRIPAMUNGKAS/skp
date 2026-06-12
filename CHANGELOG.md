# Changelog

Semua pembaruan pada proyek ini akan didokumentasikan di file ini.

## [v2.0.2] - 2026-06-13

### Ditambahkan
- Modul CRUD Pengaturan Landing Page (SystemSetting).
- Fitur pemetaan teks dinamis untuk Landing Page (Judul, Subjudul, Deskripsi Tentang Aplikasi).
- Manajemen daftar fitur aplikasi yang dinamis (tambah, edit, hapus fitur di halaman depan).
- Fitur unggah multi-gambar untuk bagian *header* (Gambar Utama) Landing Page.
- Slider / Carousel otomatis (berjalan tiap 4 detik) untuk menampilkan multi-gambar di halaman Landing Page menggunakan Alpine.js.
- Konversi format otomatis: Setiap gambar yang diunggah otomatis dikompresi (kualitas 80%) dan dikonversi menjadi format WebP untuk memuat performa lebih cepat.

### Diperbaiki
- Perbaikan masalah entitas HTML literal (&bull;) yang sebelumnya muncul mentah sebagai teks biasa pada pop-up "Alasan Tidak Hadir". Entitas tersebut diganti dengan tanda hubung biasa (-).
- Perbaikan informasi detail pop-up: Nama lokasi kegiatan kini disertakan bersama dengan nama Event pada pop-up "Alasan Tidak Hadir" di halaman Kelola Event, Daftar Peserta, dan Detail Peserta.
