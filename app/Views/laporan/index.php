<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="row">
    <div class="col-md-12">
        <?= form_open('laporan/get', ['id'=>'formLaporan']); ?>
        <div class="card card-outline card-lightblue">
            <div class="card-header">
                <h5 class="card-title mt-1"><i class="fa fa-filter"></i> Filter Data</h5>
                <div class="card-tools">
                    <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Submit</button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="range_tgl">Periode</label>
                            <input autocomplete="off" placeholder="Periode Tanggal" type="text" name="range_tgl" id="range_tgl" class="form-control <?= $validation->hasError('tgl_awal') ? 'is-invalid' : ''; ?> <?= $validation->hasError('tgl_akhir') ? 'is-invalid' : ''; ?>" value="<?= set_value('range_tgl'); ?>">
                            <input type="hidden" value="<?= set_value('tgl_awal'); ?>" name="tgl_awal" id="tgl_awal">
                            <input type="hidden" value="<?= set_value('tgl_akhir'); ?>" name="tgl_akhir" id="tgl_akhir">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="status_dokumen">Status</label>
                            <select name="status_dokumen" id="status_dokumen" class="select2 form-control">
                                <option value="">Semua Dokumen</option>
                                <option value="diterima">Diterbitkan</option>
                                <option value="dibatalkan">Dibatalkan</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form-group">
                            <label for="client_id">Nama Client</label>
                            <select name="client_id" id="client_id" class="select2 form-control">
                                <option value="">Semua Client</option>
                                <?php foreach ($client as $c): ?>
                                <option <?= set_select("client_id", $c['client_id'], false); ?> value="<?= $c['client_id']; ?>">
                                    <?= $c['nama_client']; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="reviewer">Reviewer</label>
                            <select name="reviewer" id="reviewer" class="select2 form-control">
                                <option value="">Semua Reviewer</option>
                                <?php foreach ($reveiwer as $u): ?>
                                <option <?= set_select("user_id", $c['user_id'], false); ?> value="<?= $u['user_id']; ?>">
                                    <?= $u['name']; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?= form_close(); ?>
    </div>
    <div class="col-md">
        <?php if ($laporan): ?>
        <div class="card card-outline card-lightblue">
            <div class="card-body p-0">
                <table id="laporan-data" class="table table-bordered table-sm table-striped w-100">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Client</th>
                            <th>Invoice</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no = 1;
                            foreach ($laporan as $row): ?>
                        <tr>
                            <td>
                                <?= $no++; ?>
                            </td>
                            <td class="text-uppercase">
                                <?= $row['nama_client']; ?>
                            </td>
                            <td>
                                <?= $row['no_invoice']; ?>
                            </td>
                            <td>
                                <?php 
                                if($row['status_dokumen']=="diterima") {
                                    echo "Penerbitan";
                                } elseif($row['status_dokumen']=="dibatalkan") {
                                    echo "Pembatalan";
                                }
                                ?>
                            </td>
                            <td>
                                <?= date('d/m/Y', strtotime($row['updated_at'])); ?>
                            </td>
                            <td width="100">
                                <?= $row['status_dokumen'] =="dibatalkan" ? $row['keterangan'] : "-"; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('addons'); ?>
<script src="<?=base_url()?>/plugins/daterangepicker/moment.min.js"></script>
<script src="<?=base_url()?>/plugins/daterangepicker/daterangepicker.js">
</script>

<script type="text/javascript">
$(function() {
    $('body').addClass('sidebar-collapse');
    
    $('#range_tgl').daterangepicker({
        autoApply: true,
        autoUpdateInput: false,
        timePicker: true,
        timePicker24Hour: true,
        drops: "auto",
        ranges: {
            'Hari ini': [moment().startOf('day'), moment().endOf('day')],
            'Bulan ini': [moment().startOf('month'), moment().endOf('month')],
            'Bulan lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                'month').endOf('month')],
            'Tahun ini': [moment().startOf('year'), moment().endOf('year')],
            'Tahun lalu': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1,
                'year').endOf('year')],
        },
        alwaysShowCalendars: true,
        showCustomRangeLabel: false,
    });

    $('#range_tgl').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' s.d. ' + picker.endDate.format(
            'YYYY-MM-DD'));

        let awal = picker.startDate.format('YYYY-MM-DD HH:mm:ss'),
            akhir = picker.endDate.format('YYYY-MM-DD HH:mm:ss');
        $('#tgl_awal').val(awal);
        $('#tgl_akhir').val(akhir);
    });

    $('#range_tgl').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });

    $("#laporan-data").DataTable({
        buttons: [{
            text: '<i class="fa fa-file-pdf text-danger"></i> PDF',
            className: 'btn-default',
            action: function(e, dt, node, config) {
                $.extend({
                    redirectPost: function(location, args) {
                        var form = '';
                        $.each(args, function(key, value) {

                            form += '<input type="hidden" name="' + value.name + '" value="' + value.value + '">';
                            form += '<input type="hidden" name="' + key + '" value="' + value.value + '">';
                        });
                        $(document.body).append('<form id="cetakPDF" target="_blank" action="' + location + '" method="POST">' + form + '</form>');
                        $('#cetakPDF').submit();
                    }
                });
                $.redirectPost("<?=base_url('laporan/cetakPDF')?>", $("#formLaporan").serializeArray());
            },
        }, {
            extend: 'excel',
            text: '<i class="fa fa-file-excel text-success"></i> Excel',
            className: 'btn-default',
        }],
        dom: "<'row px-2 px-md-4 pt-2'<'col-md text-left mb-1'B>>" +
            "<'row m-0'<'col-md-12'tr>>",
        responsive: true,
        "paging": false,
        "ordering": true,
        "info": false
    });
});
</script>
<?= $this->endSection();
