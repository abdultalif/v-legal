<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="card card-outline card-lightblue">
    <div class="card-header">
        <h5 class="card-title mt-1">
            Pembatalan Dokumen
        </h5>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" id="btn-refresh">
                <i class="fas fa-sync-alt"></i>
            </button>
            <a href="<?= base_url('pembatalan/add'); ?>" class="btn btn-xs btn-primary">
                <i class="fa fa-plus"></i> Tambah
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <table id="pembatalan-data" class="table table-sm table-striped w-100">
            <thead>
                <th>#</th>
                <th>Tanggal</th>
                <th>No.Dokumen</th>
                <th>Keterangan</th>
                <th>User</th>
                <th>Status</th>
                <th>Lampiran</th>
                <th width="120" class="text-center">Aksi</th>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modal-reject-pembatalan" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <?= form_open('pembatalan/reject'); ?>
            <input type="hidden" name="pembatalan_id" id="pembatalan_id">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Reject Pembatalan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="feedback">Feedback</label>
                    <textarea class="form-control" name="feedback" id="feedback" rows="2" maxlength="50">Status dokumen SUDAH DIPAKAI. mohon upload notul PEB</textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('addons'); ?>
<script type="text/javascript">
$(function() {
    if ($("#pembatalan-data").length > 0) {
        var table = $("#pembatalan-data").DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "<?=base_url('pembatalan/json');?>",
            buttons: ['copy', 'csv', 'print', 'excel'],
            dom: "<'row px-2 px-md-4 pt-2'<'col-md text-left'B><'col-md'f>>" +
                "<'row'<'col-md-12'tr>>" +
                "<'row px-2 px-md-4 py-3'<'col-md-5'i><'col-md-7'p>>",
            lengthMenu: [
                [10],
                [10]
            ],
            responsive: true,
            order: [
                [1, 'desc']
            ],
            type: 'GET',
            columns: [{
                    data: 'pembatalan_id'
                },
                {
                    data: 'tgl_pembatalan'
                },
                {
                    data: 'no_dokumen'
                },
                {
                    data: 'keterangan'
                },
                {
                    data: 'user'
                },
                {
                    data: 'status'
                },
                {
                    data: 'pembatalan_id'
                },
                {
                    data: 'pembatalan_id'
                },
            ],
            columnDefs: [{
                targets: [0, -1],
                orderable: false,
                searchable: false
            }, {
                "targets": 2,
                "render": function(data, type, row, meta) {
                    <?php if (is_admin() || is_superadmin()) : ?>
                    return `<a target="_blank" href="<?=base_url()?>/service/download_vlegal/${row.no_dokumen}"><small>${row.no_dokumen}</small><br>${row.no_invoice}</a>`;
                    <?php else: ?>
                    return `<small>${row.no_dokumen}</small><br>${row.no_invoice}`;
                    <?php endif;?>
                }
            }, {
                "targets": 5,
                "render": function(data, type, row, meta) {
                    let color = "";
                    if (data == 'sukses') {
                        color = "success";
                    } else if (data == 'gagal') {
                        color = "danger";
                    } else {
                        color = "secondary";
                    }
                    return `<div class="text-center">
                        <span onclick="return alert('${row.feedback??'no feedback'}')" class="badge text-capitalize badge-${color}" style="cursor: pointer">
                            ${data}
                        </span>
                    </div>`;
                }
            }, {
                "targets": 6,
                "render": function(data, type, row, meta) {
                    let peb = '';
                    if(row.peb){
                        peb = `<a target="_blank" href="<?=base_url()?>/uploads/pembatalan/peb/${row.peb}" class="btn btn-xs btn-secondary">PEB</a>`;
                    }
                    return `<div class="text-center">
                        <a target="_blank" href="<?=base_url()?>/uploads/pembatalan/${row.surat_pembatalan}" class="btn btn-xs btn-secondary">Surat</a>
                        ${peb}
                    </div>`;
                }
            }, {
                "targets": 7,
                "render": function(data, type, row, meta) {
                    return `
                    <div class="text-center">
                        <div class="btn-group <?php if (!is_superadmin()) : ?>${row.status=='sukses'?'d-none':''}<?php endif; ?>">
                            <button type="button" class="btn btn-sm btn-outline-dark dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-cog"></i> Opsi
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="<?=base_url()?>/pembatalan/edit/${row.pembatalan_id}" class="dropdown-item">
                                    <i class="fa fa-edit fa-fw"></i> Edit
                                </a>
                                <?php if (is_admin() || is_superadmin()): ?>
                                <div class="dropdown-divider"></div>
                                <button class="dropdown-item btn-reject-pembatalan" data-id="${row.pembatalan_id}">
                                    <i class="fa fa-times fa-fw"></i> Reject
                                </button>
                                <form method="post" action="<?=base_url()?>/service/send_pembatalan/${row.pembatalan_id}">
                                    <input type="hidden" name="_method" value="POST">
                                    <button type="submit" class="dropdown-item" onclick="return confirm('Dokumen ${row.no_dokumen} akan dibatalkan, lanjut?')">
                                        <i class="fa fa-check fa-fw"></i> Kirim ke LIU
                                    </button>
                                </form>
                                <?php endif; ?>
                                <div class="dropdown-divider"></div>
                                <form method="post" action="<?=base_url()?>/pembatalan/delete/${row.pembatalan_id}">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="dropdown-item" onclick="return confirm('Dokumen ${row.no_dokumen} akan dihapus dari database, yakin?')">
                                        <i class="fa fa-trash fa-fw"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    `;
                }
            }],
            rowId: function(a) {
                return a;
            },
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(0)', row).html(index);
            }
        });
        table.buttons().container().appendTo('#dataTable_wrapper .col-md-5:eq(0)');
        $('#btn-refresh').on('click', function() {
            table.ajax.reload();
        });
        $('#pembatalan-data').on('click', '.btn-reject-pembatalan', function() {
            let id = $(this).data('id');
            $('#modal-reject-pembatalan #pembatalan_id').val(id);
            $('#modal-reject-pembatalan').modal('show');
        });
    }
});
</script>
<?= $this->endSection(); ?>