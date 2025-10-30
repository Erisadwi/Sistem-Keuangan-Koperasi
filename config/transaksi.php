<?php
return [

    // ==============================
    // 1. TRANSAKSI KAS MASUK (Pemasukan)
    // ==============================
    'TKD' => [
        // Kas/bank bertambah (debit)
        ['side' => 'D', 'akun' => 'tujuan', 'amount' => 'full'],
        // Akun sumber berkurang (kredit) — biasanya pendapatan
        ['side' => 'K', 'akun' => 'sumber', 'amount' => 'full'],
    ],

    // ==============================
    // 2. TRANSAKSI KAS KELUAR (Pengeluaran)
    // ==============================
    'TKK' => [
        // Akun sumber berkurang (kas keluar → kredit)
        ['side' => 'K', 'akun' => 'sumber', 'amount' => 'full'],
        // Akun tujuan bertambah (biaya/beban) → debit
        ['side' => 'D', 'akun' => 'tujuan', 'amount' => 'full'],
    ],

    // ==============================
    // 3. TRANSFER ANTAR AKUN (Kas ke Kas)
    // ==============================
    'TRF' => [
        // Kas tujuan bertambah
        ['side' => 'D', 'akun' => 'tujuan', 'amount' => 'full'],
        // Kas sumber berkurang
        ['side' => 'K', 'akun' => 'sumber', 'amount' => 'full'],
    ],

    // ==============================
    // 4. TRANSAKSI NON KAS (Jurnal penyesuaian, dll.)
    // ==============================
    'TNK' => [
        // Debit ke akun tujuan
        ['side' => 'D', 'akun' => 'tujuan', 'amount' => 'full'],
        // Kredit ke akun sumber
        ['side' => 'K', 'akun' => 'sumber', 'amount' => 'full'],
    ],

    // ==============================
    // DEFAULT fallback (kalau type_transaksi tak dikenal)
    // ==============================
    'default' => [
        ['side' => 'D', 'akun' => 'tujuan', 'amount' => 'full'],
        ['side' => 'K', 'akun' => 'sumber', 'amount' => 'full'],
    ],
];
