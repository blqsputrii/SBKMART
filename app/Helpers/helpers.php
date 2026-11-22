<?php
if (! function_exists('rupiah')) {
    function rupiah($angka): string
    {
        return 'Rp ' . number_format((float) $angka, 0, ',', '.');
    }
}

if (! function_exists('warna_status')) {
    function warna_status($status): string
    {
        return match ($status) {
            'Aktif', 'Tersedia', 'Diterima Utuh' => 'success',
            'Dipesan' => 'warning',
            'Diterima Sebagian' => 'info',
            default => 'secondary',
        };
    }
}
