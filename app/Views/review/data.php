<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<?= form_open('pengajuan/multi_delete', ['id' => 'form-bulk']); ?>
<div class="card">
    <div class="card-header">
        <?php if (userdata('role') == 'superadmin') : ?>
            <button type="button" class="btn btn-danger btn-sm" onclick="bulk_delete()">
                <i class="fa fa-trash"></i>
                Hapus
            </button>
        <?php endif; ?>
        <div class="card-tools">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <button type="button" class="btn btn-tool" id="btn-refresh">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </span>
                </div>

                <select name="status_select" class="form-control" role="button" tabindex="0" onchange="return changeStatus($(this).val())">
                    <option value="dikirim">Draft</option>
                    <option value="ditolak">Rejected</option>
                    <option value="diterima">Diterima LIU</option>
                    <option value="dibatalkan">Dibatalkan</option>
                    <option value="draft">Belum dikirim</option>
                </select>
            </div>
        </div>
    </div>

    <div class="card-body p-0">
        <table id="pengajuan-data" class="table table-sm table-striped w-100">
            <thead>
                <th width="25">
                    <input type="checkbox" id="select_all" class="text-center">
                </th>
                <th width="50">No. </th>
                <th width="120">No. Invoice</th>
                <th>Client</th>
                <th>Created</th>
                <th>Updated</th>
                <th>Status Dokumen</th>
                <th>Operator</th>
                <th width="100" class="text-center">Opsi</th>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
<?= form_close(); ?>
<?= $this->endSection(); ?>

<?= $this->section('addons'); ?>
<script type="text/javascript">
    $(function() {
        if ($("#pengajuan-data").length > 0) {
            var table = $("#pengajuan-data").DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "<?= base_url('review/json/dikirim'); ?>",
                buttons: ['copy', 'csv', 'print', 'excel'],
                dom: "<'row px-2 px-md-4 pt-2'<'col-md-3'l><'col-md-5 text-center'B><'col-md-4'f>>" +
                    "<'row'<'col-md-12'tr>>" +
                    "<'row px-2 px-md-4 py-3'<'col-md-5'i><'col-md-7'p>>",
                lengthMenu: [
                    [20, 50, 100],
                    [20, 50, 100]
                ],
                responsive: true,
                order: [
                    [1, 'desc']
                ],
                type: 'GET',
                columns: [{
                        data: 'pengajuan_id'
                    },
                    {
                        data: 'pengajuan_id'
                    },
                    {
                        data: 'no_invoice'
                    },
                    {
                        data: 'nama_client'
                    },
                    {
                        data: 'created_at'
                    },
                    {
                        data: 'updated_at'
                    },
                    {
                        data: 'status_dokumen'
                    },
                    {
                        data: 'reviewer'
                    },
                    {
                        data: 'pengajuan_id'
                    },
                ],
                columnDefs: [{
                    targets: [0, -1],
                    orderable: false,
                    searchable: false
                }, {
                    "targets": 0,
                    "render": function(data, type, row, meta) {
                        return `<input name="checked[]" class="check" value="${data}" type="checkbox">`;
                    }
                }, {
                    "targets": 2,
                    "render": function(data, type, row, meta) {
                        return `<a href="<?= base_url() ?>/review/detail/${row.pengajuan_id}">${row.no_invoice}</a>`;
                    }
                }, {
                    "targets": 6,
                    "render": function(data, type, row, meta) {
                        let status = '';
                        if (row.status_dokumen == "dikirim") {
                            status = 'Draft';
                        } else if (row.status_dokumen == "diterima") {
                            status = 'Diterima LIU';
                        } else if (row.status_dokumen == "dibatalkan") {
                            status = 'Dibatalkan';
                        } else if (row.status_dokumen == "ditolak") {
                            status = `Penolakan <br/> "${row.keterangan_status}"`;
                        } else if (row.status_dokumen == "draft") {
                            status = `Belum Dikirim`;
                        } else {
                            status = '';
                        }
                        return status;
                    }
                }, {
                    "targets": 8,
                    "render": function(data, type, row, meta) {
                        if (row.status_dokumen == "dikirim") {
                            return `
                                <div class="text-center">
                                    <div class="btn-group">
                                        <a title="Review Pengajuan" data-toggle="tooltip" data-placement="left" class="btn btn-primary btn-sm" href="<?= base_url() ?>/review/detail/${data}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-square-dots-fill" viewBox="0 0 16 16">
                                                <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2h-2.5a1 1 0 0 0-.8.4l-1.9 2.533a1 1 0 0 1-1.6 0L5.3 12.4a1 1 0 0 0-.8-.4H2a2 2 0 0 1-2-2V2zm5 4a1 1 0 1 0-2 0 1 1 0 0 0 2 0zm4 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0zm3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            `;
                        } else {
                            return ``;
                        }
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
                    $('td:eq(1)', row).html(index);
                }
            });
            table.buttons().container().appendTo('#dataTable_wrapper .col-md-5:eq(0)');

            $('#btn-refresh').on('click', function() {
                table.ajax.reload();
            });
        }

        $('#select_all').on('click', function() {
            if (this.checked) {
                $('.check').each(function() {
                    this.checked = true;
                    $('#select_all').prop('checked', true);
                });
            } else {
                $('.check').each(function() {
                    this.checked = false;
                    $('#select_all').prop('checked', false);
                });
            }
        });
    });

    function changeStatus(status) {
        let ajaxUrl = "<?= base_url() ?>/review/json/" + status;
        $('#pengajuan-data').DataTable().ajax.url(ajaxUrl).load();
    }

    function bulk_delete() {
        if ($('#pengajuan-data tbody tr .check:checked').length == 0) {
            alert('Tidak ada data yang dipilih');
        } else {
            if (confirm('Confirm delete?')) {
                $('#form-bulk').submit();
            }
        }
    }
</script>
<?= $this->endSection();
