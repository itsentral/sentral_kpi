<?php
$ENABLE_MANAGE = has_permission('KPI.Manage');
$ENABLE_VIEW = has_permission('KPI.View');
$ENABLE_DELETE = has_permission('KPI.Delete');
?>

<table class="table table-bordered table-striped" id="table_kpi">
    <thead>
        <tr>
            <th width="5%">No</th>
            <th>Divisi Name</th>
            <th width="15%">Periode</th>
            <th width="12%">Status Realisasi</th>
            <th width="15%">Create by</th>
            <th width="25%">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($kpi_headers)): ?>
            <?php $no = 1;
            foreach ($kpi_headers as $row): ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row->divisi_name) ?></td>
                    <td class="text-center">
                        <?php if (!empty($row->periode)): ?>
                            <span class="label label-primary">
                                <i class="fa fa-calendar"></i>
                                Jan <?= $row->periode ?> - Dec <?= $row->periode ?>
                            </span>
                        <?php else: ?>
                            <span class="label label-default">-</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-center">
                        <?php if ($row->is_realisasi == 2): ?>
                            <span class="label label-success">
                                <i class="fa fa-check-circle"></i> Realisasi Lengkap
                            </span>
                            <?php if ($row->is_close == 1): ?>
                                <br>
                                <span class="label label-danger" style="margin-top:3px; display:inline-block;">
                                    <i class="fa fa-lock"></i> Close Period
                                </span>
                            <?php endif; ?>
                        <?php elseif ($row->is_realisasi == 1): ?>
                            <span class="label label-info">
                                <i class="fa fa-clock-o"></i> Proses Realisasi
                            </span>
                        <?php else: ?>
                            <span class="label label-warning">
                                <i class="fa fa-hourglass-start"></i> Belum Direalisasi
                            </span>
                        <?php endif; ?>
                    </td>
                    <td><?= $row->create_by ?> <br>
                        <span class="text-muted small">
                            <i><?= date('d-m-Y H:i', strtotime($row->create_date)) ?></i>
                        </span>
                    </td>
                    <td class="text-center">
                        <?php if ($ENABLE_MANAGE): ?>
                            <?php if ($row->is_close == 1): ?>
                                <a href="<?= site_url('kpi/realisasi/' . $row->id) ?>"
                                    class="btn btn-info btn-xs"
                                    style="width: 100px; margin: 1px;"
                                    title="View Realisasi (Periode Ditutup)">
                                    <i class="fa fa-eye"></i> View Realisasi
                                </a>
                            <?php else: ?>
                                <a href="javascript:void(0)"
                                    class="btn btn-primary btn-xs btn-realisasi"
                                    style="width: 100px; margin: 1px;"
                                    data-id="<?= $row->id ?>"
                                    data-is-realisasi="<?= $row->is_realisasi ?>"
                                    data-divisi="<?= htmlspecialchars($row->divisi_name) ?>"
                                    title="Isi Realisasi Bulanan">
                                    <i class="fa fa-pencil"></i> Isi Realisasi
                                </a>

                                <?php if ($row->is_realisasi == 2):
                                ?>
                                    <button type="button"
                                        class="btn btn-success btn-xs btn-close-period"
                                        style="width: 100px; margin: 1px;"
                                        data-id="<?= $row->id ?>"
                                        data-periode="<?= $row->periode ?>"
                                        data-divisi="<?= htmlspecialchars($row->divisi_name) ?>"
                                        title="Tutup Periode KPI">
                                        <i class="fa fa-lock"></i> Tutup Periode
                                    </button>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php if ($ENABLE_VIEW): ?>
                            <a href="<?= site_url('kpi/view/' . $row->id) ?>"
                                class="btn btn-info btn-xs"
                                style="width: 100px; margin: 1px;"
                                title="View Detail">
                                <i class="fa fa-eye"></i> View Indikator
                            </a>
                        <?php endif; ?>

                        <?php if ($ENABLE_MANAGE && $row->is_realisasi == 0 && $row->is_close == 0): ?>
                            <a href="<?= site_url('kpi/edit/' . $row->id) ?>"
                                class="btn btn-warning btn-xs"
                                style="width: 100px; margin: 1px;"
                                title="Edit">
                                <i class="fa fa-edit"></i> Edit Indikator
                            </a>
                        <?php endif; ?>


                        <?php if ($ENABLE_DELETE && $row->is_realisasi == 0 && $row->is_close == 0): ?>
                            <a href="<?= site_url('kpi/delete/' . $row->id) ?>"
                                class="btn btn-danger btn-xs btn-delete"
                                style="width: 100px; margin: 1px;"
                                data-id="<?= $row->id ?>"
                                data-divisi="<?= htmlspecialchars($row->divisi_name) ?>"
                                title="Delete">
                                <i class="fa fa-trash"></i> Delete
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $(document).on('click', '.btn-realisasi', function(e) {
            e.preventDefault();

            var headerId = $(this).data('id');
            var isRealisasi = $(this).data('is-realisasi');
            var divisi = $(this).data('divisi');

            if (isRealisasi == 1 || isRealisasi == 2) {
                window.location.href = '<?= site_url('kpi/realisasi/') ?>' + headerId;
            } else {
                Swal.fire({
                    title: 'Perhatian!',
                    html: `
                        <div style="text-align: center;">
                            <p class="text-warning" style="font-size: 14px;">
                                <i class="fa fa-exclamation-triangle"></i> 
                                <strong>Pastikan pengisian indikator sudah selesai dibuat!</strong>
                            </p>
                            <p style="font-size: 13px;" class="text-danger">
                                Setelah Anda mulai mengisi realisasi, <strong>indikator tidak dapat diubah lagi</strong>.
                            </p>
                            <br>
                            <p style="font-size: 13px;">Apakah Anda yakin ingin melanjutkan?</p>
                        </div>
                    `,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '<i class="fa fa-check"></i> Ya, Lanjutkan',
                    cancelButtonText: '<i class="fa fa-times"></i> Batal',
                    customClass: {
                        popup: 'swal-wide'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '<?= site_url('kpi/realisasi/') ?>' + headerId;
                    }
                });
            }
        });

        $(document).on('click', '.btn-close-period', function(e) {
            e.preventDefault();

            var headerId = $(this).data('id');
            var periode = $(this).data('periode');
            var divisi = $(this).data('divisi');
            var button = $(this);

            Swal.fire({
                title: 'Tutup Periode KPI?',
                html: `
                        <p class="text-danger">
                            <i class="fa fa-exclamation-triangle"></i>
                            Realisasi akan dikunci dan tidak dapat diubah.
                        </p>
                        `,

                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '<i class="fa fa-lock"></i> Ya, Tutup Periode!',
                cancelButtonText: '<i class="fa fa-times"></i> Batal',
                width: '400px'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Sedang menutup periode KPI',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    $.ajax({
                        url: '<?= site_url('kpi/close_period') ?>',
                        type: 'POST',
                        data: {
                            header_id: headerId,
                            <?= $this->security->get_csrf_token_name(); ?>: '<?= $this->security->get_csrf_hash(); ?>'
                        },
                        dataType: 'json',
                        success: function(res) {
                            if (res.status === 'success') {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: 'Periode KPI telah ditutup.',
                                    icon: 'success',
                                    timer: 2000
                                }).then(() => {
                                    location.reload(); // refresh list
                                });
                            } else {
                                Swal.fire({
                                    title: 'Gagal',
                                    text: res.message,
                                    icon: 'error'
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Tidak dapat terhubung ke server.',
                                icon: 'error'
                            });
                        }
                    });
                }
            });
        });

        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();

            var url = $(this).attr('href');
            var divisi = $(this).data('divisi');
            var button = $(this);
            var row = button.closest('tr');

            Swal.fire({
                title: 'Konfirmasi Hapus',
                html: `Yakin ingin menghapus KPI untuk divisi <strong>${divisi}</strong>?<br><small class="text-danger">Data yang sudah dihapus tidak dapat dikembalikan!</small>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '<i class="fa fa-trash"></i> Ya, Hapus!',
                cancelButtonText: '<i class="fa fa-times"></i> Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Menghapus...',
                        text: 'Sedang memproses',
                        icon: 'info',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'json',
                        success: function(res) {
                            if (res.status === 'success') {
                                if (row.length) {
                                    row.fadeOut(500, function() {
                                        $(this).remove();
                                    });
                                }
                                Swal.fire({
                                    title: 'Berhasil!',
                                    html: res.message,
                                    icon: 'success',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            } else {
                                Swal.fire({
                                    title: 'Gagal',
                                    text: res.message || 'Terjadi kesalahan saat menghapus.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Tidak dapat terhubung ke server. Coba lagi nanti.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            });
        });
    });
</script>