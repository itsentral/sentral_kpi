<?php
$ENABLE_ADD     = has_permission('KPI.Add');
$ENABLE_MANAGE  = has_permission('KPI.Manage');
$ENABLE_VIEW    = has_permission('KPI.View');
$ENABLE_DELETE  = has_permission('KPI.Delete');
?>
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/plugins/sweetalert2/sweetalert2.min.css') ?>">

<script src="<?= base_url('assets/plugins/sweetalert2/sweetalert2.all.min.js') ?>"></script>
<style>
	.ajax_loader {
		display: none !important;
	}

	.skeleton {
		background: #f2f2f2;
		border-radius: 4px;
		animation: shimmer 1.5s infinite linear;
		background: linear-gradient(90deg, #f2f2f2 25%, #e0e0e0 50%, #f2f2f2 75%);
		background-size: 200% 100%;
	}

	@keyframes shimmer {
		0% {
			background-position: 200% 0;
		}

		100% {
			background-position: -200% 0;
		}
	}

	.skeleton-line {
		height: 20px;
		margin: 8px 0;
	}

	.skeleton-line.short {
		width: 60%;
	}

	.skeleton-line.medium {
		width: 80%;
	}
</style>

<div class="box">
	<!-- /.box-header -->
	<div class="box-body">
		<div class="box-header text-right" style="padding-bottom:10px;">
			<button class="btn btn-sm btn-primary refresh-list-kpi">
				<i class="fa fa-refresh"></i> Refresh
			</button>
			<?php if (has_permission('KPI.Add')): ?>
				<a href="<?= site_url('kpi/add') ?>" class="btn btn-success btn-sm">
					<i class="fa fa-plus"></i> Add New KPI
				</a>
			<?php endif; ?>
		</div>
		<div id="skeleton-loading">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th width="5%">No</th>
						<th>Divisi Name</th>
						<th>Bobot Enabled</th>
						<th>Created At</th>
						<th width="20%">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php for ($i = 0; $i < 5; $i++):
					?>
						<tr>
							<td>
								<div class="skeleton skeleton-line short"></div>
							</td>
							<td>
								<div class="skeleton skeleton-line medium"></div>
							</td>
							<td>
								<div class="skeleton skeleton-line short"></div>
							</td>
							<td>
								<div class="skeleton skeleton-line medium"></div>
							</td>
							<td>
								<div class="skeleton skeleton-line short"></div>
							</td>
						</tr>
					<?php endfor; ?>
				</tbody>
			</table>
		</div>

		<div id="kpi-content" style="display:none;"></div>
	</div>
</div>

<!-- DataTables -->
<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.min.js') ?>"></script>

<script>
	function loadKpiList() {
		$.ajax({
			url: siteurl + active_controller + 'get_list',
			type: 'GET',
			beforeSend: function() {
				$('#skeleton-loading').show();
				$('#kpi-content').hide();
			},
			success: function(response) {
				$('#skeleton-loading').hide();
				$('#kpi-content').html(response).fadeIn();

				if ($.fn.DataTable.isDataTable('#table_kpi')) {
					$('#table_kpi').DataTable().destroy();
				}

				$('#table_kpi').DataTable({
					paging: true,
					searching: true,
					ordering: true,
					info: true
				});
			},
			error: function() {
				$('#skeleton-loading').hide();
				$('#kpi-content')
					.html('<p class="text-danger">Gagal memuat data.</p>')
					.show();
			}
		});
	}

	$(document).ready(function() {
		loadKpiList();

		$(document).on('click', '.refresh-list-kpi', function(e) {
			e.preventDefault();
			loadKpiList();
		});
	});
</script>