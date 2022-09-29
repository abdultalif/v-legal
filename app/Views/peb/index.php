<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="alert alert-info alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h5><i class="icon fas fa-info"></i> Perhatian!</h5>
    Diharapkan untuk mengupload <b>PEB</b> maksimal <b>30 hari</b> setelah dokumen terbit, agar bisa kami rekap. <br> Terima Kasih.
</div>

<div class="card">
    <div class="card-header">
        List PEB
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body p-0">
        <table id="peb-data" class="table table-sm table-striped w-100">
            <thead>
                <th>No. </th>
                <th>No. Invoice</th>
                <th>No. Dokumen</th>
                <th>Tgl Terbit</th>
                <th>Status</th>
                <th>Upload</th>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('addons'); ?>
<script type="text/javascript">
$(function() {
    if ($("#peb-data").length > 0) {
        var table = $("#peb-data").DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "<?=base_url('peb/getList');?>",
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
                [0, 'desc']
            ],
            type: 'GET',
            columns: [{
                    data: 'pengajuan_id'
                },
                {
                    data: 'no_invoice'
                },
                {
                    data: 'no_dokumen'
                },
                {
                    data: 'tgl_sent'
                },
                {
                    data: 'tgl_sent'
                },
                {
                    data: 'pengajuan_id'
                },
            ],
            columnDefs: [{
                targets: [-1],
                orderable: false,
                searchable: false
            }, {
                "targets": 3,
                "render": function(data, type, row, meta) {
                    return `${moment(row.tgl_sent).format('DD MMMM YYYY')}`;
                }
            }, {
                "targets": 4,
                "render": function(data, type, row, meta) {
                    let status;
                    status = row.peb > 0 ? '<span class="badge badge-success">Sudah Upload</span>' : '<span class="badge badge-danger">Belum Upload</span>';
                    return `
                        ${status}
                    `;
                }
            }, {
                "targets": 5,
                "render": function(data, type, row, meta) {
                    return `
                        <a href="<?=base_url()?>/lampiran/peb/${row.pengajuan_id}" class="btn btn-sm btn-secondary">
                            <i class="fa fa-upload fa-fw"></i> Upload PEB
                        </a>
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
    }
});
</script>
<?=$this->endSection();?>
