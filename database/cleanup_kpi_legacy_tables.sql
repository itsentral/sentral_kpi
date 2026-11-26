-- Pilih database KPI Digital di server sebelum menjalankan skrip ini.
-- Pastikan backup enam tabel di bawah tersedia. DROP TABLE menghapus struktur dan data.
SELECT DATABASE() AS database_aktif;

DROP TABLE IF EXISTS
    `customer_address_invoice`,
    `invoice_stage`,
    `product_lvl_1`,
    `product_lvl_2`,
    `product_lvl_3`,
    `product_lvl_4`;
