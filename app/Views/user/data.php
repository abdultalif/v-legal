<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<?= form_open('user/multi_delete', ['id'=>'form-bulk']); ?>
<div class="card">
    <div class="card-header">
        <a href="<?= base_url(); ?>/user/add" class="btn btn-primary btn-sm">
            <i class="fa fa-plus">
            </i> Create
        </a>
        <button type="button" class="btn btn-default btn-sm" onclick="bulk_delete()">
            <i class="fa fa-trash">
            </i>
            Hapus
        </button>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus">
                </i>
            </button>
        </div>
    </div>
    <div class="card-body p-0">
        <table id="user-data" class="table table-sm table-striped w-100">
            <thead>
                <th width="25">
                    <input type="checkbox" id="select_all" class="text-center">
                </th>
                <th>No.</th>
                <th>Foto</th>
                <th>Username</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Created At</th>
                <th>Status</th>
                <th>Opsi</th>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<?= form_close(); ?>
<?= $this->endSection(); ?>

<?= $this->section('addons'); ?>
<script type="text/javascript">
$(function() {
    if ($("#user-data").length > 0) {
        var table = $("#user-data").DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "<?=base_url('user/json');?>",
            buttons: ['copy', 'csv', 'print', 'excel'],
            dom: "<'row px-2 px-md-4 pt-2'<'col-md-3'l><'col-md-5 text-center'B><'col-md-4'f>>" +
                "<'row'<'col-md-12'tr>>" +
                "<'row px-2 px-md-4 py-3'<'col-md-5'i><'col-md-7'p>>",
            lengthMenu: [
                [10, 20, 50, 100],
                [10, 20, 50, 100]
            ],
            responsive: true,
            order: [
                [1, 'desc'],
            ],
            type: 'GET',
            columns: [{
                    data: 'user_id'
                },
                {
                    data: 'user_id'
                },
                {
                    data: 'foto'
                },
                {
                    data: 'username'
                },
                {
                    data: 'name'
                },
                {
                    data: 'email'
                },
                {
                    data: 'role'
                },
                {
                    data: 'created_at'
                },
                {
                    data: 'status'
                },
                {
                    data: 'user_id'
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
                    return `<img style="width:25px;height:25px;" class="rounded" src="<?=base_url()?>/img/user/${data}"/>`;
                }
            }, {
                "targets": 8,
                "render": function(data, type, row, meta) {
                    if (data == "1") {
                        return `<span class="badge badge-success">Aktif</span>`;
                    } else {
                        return `<span class="badge badge-danger">Nonaktif</span>`;
                    }
                }
            }, {
                "targets": 9,
                "render": function(data, type, row, meta) {
                    return `
                    <div class="text-center">
                        <div class="btn-group">
                            <a href="<?=base_url()?>/user/edit/${data}" class="btn btn-xs btn-default">
                                <i class="fa fa-edit fa-fw"></i>
                            </a>
                            <form action="/user/delete/${data}" method="post">
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
    if ($('#user-data tbody tr .check:checked').length == 0) {
        alert('Tidak ada data yang dipilih');
    } else {
        if (confirm('Confirm delete?')) {
            $('#form-bulk').submit();
        }
    }
}
</script>
<?= $this->endSection(); ?>