<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<?= form_open('provinsi/multi_delete', ['id'=>'form-bulk']); ?>
<div class="card">
    <div class="card-header">
        <a href="<?= base_url(); ?>/provinsi/add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah</a>
        <button type="button" class="btn btn-default btn-sm" onclick="bulk_delete()">
            <i class="fa fa-trash"></i>
            Hapus
        </button>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body p-0">
        <table id="provinsi-data" class="table table-sm table-striped w-100">
            <thead>
                <th width="25">
                    <input type="checkbox" id="select_all" class="text-center">
                </th>
                <th width="50">No. </th>
                <th width="75">Kode</th>
                <th>Nama</th>
                <th>Status</th>
                <th width="100" class="text-center"></th>
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
    if ($("#provinsi-data").length > 0) {
        var table = $("#provinsi-data").DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "<?=base_url('provinsi/json');?>",
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
                [1, 'asc']
            ],
            type: 'GET',
            columns: [{
                    data: 'provinsi_id'
                },
                {
                    data: 'provinsi_id'
                },
                {
                    data: 'kode_provinsi'
                },
                {
                    data: 'nama_provinsi'
                },
                {
                    data: 'status'
                },
                {
                    data: 'provinsi_id'
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
                "targets": 4,
                "render": function(data, type, row, meta) {
                    if (data == "1") {
                        return `<span class="badge badge-success">Aktif</span>`;
                    } else {
                        return `<span class="badge badge-danger">Nonaktif</span>`;
                    }
                }
            }, {
                "targets": 5,
                "render": function(data, type, row, meta) {
                    return `
                        <div class="text-center">
                            <div class="btn-group">
                                <a href="<?=base_url()?>/provinsi/edit/${data}" class="btn btn-xs btn-default">
                                    <i class="fa fa-edit fa-fw"></i>
                                </a>
                                
                                <form action="/provinsi/delete/${data}" method="post">
                                    <?= csrf_field(); ?>
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-default btn-xs" onclick="return confirm('Confirm Delete ?');">
                                        <i class="fa fa-trash fa-fw"></i>
                                    </button>
                                </form>
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
                $('td:eq(1)', row).html(index);
            }
        });

        table.buttons().container().appendTo('#dataTable_wrapper .col-md-5:eq(0)');
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

function bulk_delete() {
    if ($('#provinsi-data tbody tr .check:checked').length == 0) {
        alert('Tidak ada data yang dipilih');
    } else {
        if (confirm('Confirm delete?')) {
            $('#form-bulk').submit();
        }
    }
}
</script>
<?= $this->endSection(); ?>