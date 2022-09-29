<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>



<div class="card card-outline card-lightblue">
    <div class="card-header">
        <h5 class="card-title mt-1">
            Penerbitan Dokumen
        </h5>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" id="btn-refresh">
                <i class="fas fa-sync-alt"></i>
            </button>
            <a href="<?= base_url('service/add_terkirim'); ?>" class="btn btn-xs btn-primary">
                <i class="fa fa-plus"></i> Tambah
            </a>
        </div>
    </div>

    <div class="card-body p-0">

        <table id="penerbitan-data" class="table table-sm table-striped w-100">

            <thead>

                <th>#</th>

                <th>Tanggal</th>

                <th>No.Dokumen</th>

                <th>No.Invoice</th>

                <th>Barcode</th>

                <th>Status</th>

                <th class="text-center">Aksi</th>

            </thead>

            <tbody></tbody>

        </table>

    </div>

</div>



<?= $this->endSection(); ?>



<?= $this->section('addons'); ?>

<script type="text/javascript">
    $(function() {

        if ($("#penerbitan-data").length > 0) {

            var table = $("#penerbitan-data").DataTable({

                "processing": true,

                "serverSide": true,

                "ajax": "<?= base_url('service/json_terkirim'); ?>",

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

                        data: 'sent_id'

                    },

                    {

                        data: 'tgl_sent'

                    },

                    {

                        data: 'no_dokumen'

                    },

                    {

                        data: 'no_invoice'

                    },

                    {

                        data: 'barcode'

                    },

                    {

                        data: 'status'

                    },

                    {

                        data: 'sent_id'

                    },

                ],

                columnDefs: [{

                    targets: [0, -1],

                    orderable: false,

                    searchable: false

                }, {

                    "targets": 5,

                    "render": function(data, type, row, meta) {

                        let color = "";

                        if (data == 'terbit') {

                            color = "success";

                        } else {

                            color = "danger";

                        }

                        return `<div class="text-center">

                                <span class="badge text-capitalize badge-${color}">

                                    ${data}

                                </span>

                            </div>`;

                    }

                }, {

                    "targets": 6,

                    "render": function(data, type, row, meta) {

                        return `<form method="post" action="<?= base_url() ?>/service/delete_terkirim/${row.sent_id}">

                        <input type="hidden" name="_method" value="DELETE">

                        <div class="text-center">

                            <a class="btn btn-xs btn-success" href="<?= base_url() ?>/service/download_vlegal/${row.no_dokumen}">

                                <i class="fa fa-download fa-fw"></i>

                            </a>

                            <a target="_blank" class="btn btn-xs btn-warning" href="<?= base_url() ?>/service/for_auditee/${row.no_dokumen}">

                                <i class="fa fa-share fa-fw"></i>

                            </a>

                            <a class="btn btn-xs btn-primary" href="<?= base_url() ?>/service/send_to_email/${row.no_dokumen}">

                                <i class="fa fa-envelope fa-fw"></i>

                            </a>

                            <?php if (is_superadmin()) : ?>
                            
                            <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Dokumen ${row.no_dokumen} akan dihapus dari database, yakin?')">

                                <i class="fa fa-trash fa-fw"></i>

                            </button>
                            
                            <?php endif; ?>

                        </div>

                    </form>

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

        }

    });
</script>

<?= $this->endSection(); ?>