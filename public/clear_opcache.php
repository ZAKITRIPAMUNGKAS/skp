<?php

if (function_exists('opcache_reset')) {
    if (opcache_reset()) {
        echo "SUCCESS: OPcache PHP berhasil di-reset! Memori cPanel sekarang menggunakan kode terbaru.";
    } else {
        echo "WARNING: Gagal mereset OPcache, namun fungsi tersedia.";
    }
} else {
    echo "INFO: OPcache tidak aktif pada server ini (tidak perlu di-reset).";
}
