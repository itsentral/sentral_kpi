-- Pilih schema KPI Digital dan hentikan sementara proses yang dapat menulis ke tabel ini.
-- Jalankan setelah membuat backup schema server. Semua tabel harus ada dan kosong.
SELECT DATABASE() AS database_aktif;

SET @cleanup_kpi_sql = IF(
    EXISTS (SELECT 1 FROM `child_customer_bank`)
    OR EXISTS (SELECT 1 FROM `cms_kewenangan`)
    OR EXISTS (SELECT 1 FROM `employees_internal`)
    OR EXISTS (SELECT 1 FROM `jurnaltras_bayar_dp`)
    OR EXISTS (SELECT 1 FROM `jurnaltras_incoming_material`)
    OR EXISTS (SELECT 1 FROM `jurnaltras_incoming_nonmaterial`)
    OR EXISTS (SELECT 1 FROM `jurnaltras_terima_invoice`)
    OR EXISTS (SELECT 1 FROM `kons_kategori_paket`)
    OR EXISTS (SELECT 1 FROM `kons_konsultan_kompetensi`)
    OR EXISTS (SELECT 1 FROM `kons_master_aktifitas`)
    OR EXISTS (SELECT 1 FROM `kons_master_check_point`)
    OR EXISTS (SELECT 1 FROM `kons_master_kompetensi`)
    OR EXISTS (SELECT 1 FROM `kons_master_konsultan`)
    OR EXISTS (SELECT 1 FROM `kons_master_konsultasi_detail`)
    OR EXISTS (SELECT 1 FROM `kons_master_konsultasi_header`)
    OR EXISTS (SELECT 1 FROM `kons_master_paket`)
    OR EXISTS (SELECT 1 FROM `kons_quotations_header`)
    OR EXISTS (SELECT 1 FROM `ms_budget3`)
    OR EXISTS (SELECT 1 FROM `provinsi_backup`)
    OR EXISTS (SELECT 1 FROM `quotation_header`)
    OR EXISTS (SELECT 1 FROM `recycle_master`)
    OR EXISTS (SELECT 1 FROM `rutin_planning_detail`)
    OR EXISTS (SELECT 1 FROM `rutin_planning_header`)
,
    'SELECT ''Pembersihan dibatalkan karena ada tabel yang berisi data.'' AS status',
    'DROP TABLE
        `child_customer_bank`,
        `cms_kewenangan`,
        `employees_internal`,
        `jurnaltras_bayar_dp`,
        `jurnaltras_incoming_material`,
        `jurnaltras_incoming_nonmaterial`,
        `jurnaltras_terima_invoice`,
        `kons_kategori_paket`,
        `kons_konsultan_kompetensi`,
        `kons_master_aktifitas`,
        `kons_master_check_point`,
        `kons_master_kompetensi`,
        `kons_master_konsultan`,
        `kons_master_konsultasi_detail`,
        `kons_master_konsultasi_header`,
        `kons_master_paket`,
        `kons_quotations_header`,
        `ms_budget3`,
        `provinsi_backup`,
        `quotation_header`,
        `recycle_master`,
        `rutin_planning_detail`,
        `rutin_planning_header`'
);

PREPARE cleanup_kpi FROM @cleanup_kpi_sql;
EXECUTE cleanup_kpi;
DEALLOCATE PREPARE cleanup_kpi;
