<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="card card-outline card-secondary">
    <div class="card-header">
        <div class="row">
            <div class="col-md-4">
                <select id="client_filter" class="w-100 select2 custom-select custom-select-sm">
                    <option value="">-- Pilih Eksportir --</option>
                    <?php foreach ($client as $item): ?>
                        <option value="<?=$item['client_id']?>"><?= $item['nama_client']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md text-right">
                <button type="button" class="btn btn-tool" id="btn-refresh">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <table id="peb-data" class="table table-sm table-striped w-100">
            <thead>
                <th>No. </th>
                <th>Eksportir</th>
                <th>No. Invoice</th>
                <th>No. Dokumen</th>
                <th>Tgl Terbit</th>
                <th>Status</th>
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
                    data: 'nama_client'
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
            ],
            columnDefs: [{
                targets: [-1],
                orderable: false,
                searchable: false
            }, {
                "targets": 4,
                "render": function(data, type, row, meta) {
                    return `${moment(row.tgl_sent).format('DD MMMM YYYY')}`;
                }
            }, {
                "targets": 5,
                "render": function(data, type, row, meta) {
                    let status;
                    status = row.peb > 0 ? '<span class="badge badge-success">Sudah Upload</span>' : '<span class="badge badge-danger">Belum Upload</span>';
                    return `
                        ${status}
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

        $('#btn-refresh').on('click', function(){
            table.ajax.reload();
        });
    }

    $('#client_filter').on('change', function() {
        let id = $(this).val();
        let ajaxUrl = "<?=base_url('peb/getList');?>/" + id;

        $('#peb-data').DataTable().ajax.url(ajaxUrl).load();
    });
});
</script>
<?=$this->endSection();?>
