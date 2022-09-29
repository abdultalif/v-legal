<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<?= form_open('pengajuan/multi_delete', ['id'=>'form-bulk']); ?>
<div class="card">
    <div class="card-header">
        <a
        <?php if (date('d') > env('ls.deadlineLMK')) : ?>
        <?php if (count(cekLMK()) == 0): ?>
        onclick="Swal.fire('Perhatian!','<p>Mohon untuk segera mengupload LMK bulan lalu terlebih dahulu, sebelum mengajukan dokumen baru.</p>Terima Kasih', 'warning');return false;"
        <?php endif; ?>
        <?php endif; ?>
        href="<?= base_url(); ?>/pengajuan/add" class="btn btn-primary btn-sm">
            <i class="fa fa-plus"></i> Buat
        </a>
        <button type="button" class="btn btn-danger btn-sm" onclick="bulk_delete()">
            <i class="fa fa-trash"></i>
            Hapus
        </button>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" id="btn-refresh">
                <i class="fas fa-sync-alt"></i>
            </button>
        </div>
    </div>

    <div class="card-body p-0">
        <table id="pengajuan-data" class="table table-sm table-striped w-100">
            <thead>
                <th width="25">
                    <input type="checkbox" id="select_all" class="text-center">
                </th>
                <th width="50">No. </th>
                <th width="100">Invoice</th>
                <th>Nama Pembeli</th>
                <th>Negara</th>
                <th>Loading</th>
                <th>Discharge</th>
                <th>Status</th>
                <th width="100" class="text-center">Opsi</th>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<?= form_close(); ?>

<div class="fade modal" id="modal-draft" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <img src="<?=base_url()?>/img/vlegal.png" alt="" height="50px">
                </h5>
                <ul class="nav nav-tabs ml-auto">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#vlegal-licence">LICENCE</a>
                    </li>
                    <li class="nav-item" id="nav-detail">
                        <a class="nav-link" data-toggle="tab" href="#vlegal-detail">DETAIL</a>
                    </li>
                </ul>
            </div>
            <div class="tab-content modal-body">
                <div class="tab-pane fade show active" id="vlegal-licence">
                    <table class="table-bordered w-100">
                        <tr>
                            <td width="50%" class="p-2 align-top">
                                <h6>Issuing authority</h6>
                                <div class="row">
                                    <div class="col-lg-2">Name</div>
                                    <div class="col-lg"><?= env('ls.name'); ?></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-2">Address</div>
                                    <div class="col-lg"><?= env('draft.lsAddress'); ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">Authority registration number</div>
                                    <div class="col-lg"><?= env('draft.lsNumber'); ?></div>
                                </div>
                            </td>
                            <td width="50%" class="p-2 align-top">
                                <h6>Importer</h6>
                                <div class="row">
                                    <div class="col-lg-2">Name</div>
                                    <div class="col-lg text-uppercase"><span class="nama_buyer"></span></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-2">Address</div>
                                    <div class="col-lg text-uppercase"><span id="alamat_buyer"></span></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg">Country of destination and ISO Code <span id="nama_negara" class="text-uppercase"></span> - <span id="kode_negara"></span></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">Port of loading</div>
                                    <div class="col-lg text-uppercase"><span id="nama_loading"></span></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">Port of discharge</div>
                                    <div class="col-lg text-uppercase"><span id="nama_discharge"></span></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">Value (<span id="mata_uang"></span>)</div>
                                    <div class="col-lg"><span id="total-nilai"></span></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%" class="p-2 align-top">
                                <h6>V-Legal/licence number</h6>
                                <p>-</p>
                            </td>
                            <td width="50%" class="p-2 align-top">
                                <h6>Date of Expiry</h6>
                                <table style="border: 2px solid black">
                                    <tr>
                                        <td class="px-3 py-1">--</td>
                                        <td class="px-3 py-1">--</td>
                                        <td class="px-3 py-1">----</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%" class="p-2 align-top">
                                <h6>Country of export</h6>
                                <p class="text-uppercase">Indonesia</p>
                            </td>
                            <td rowspan="2" width="50%" class="p-2 align-top">
                                <h6>Means of transport</h6>
                                <p class="text-uppercase"><span id="alat_angkut"></span></p>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%" class="p-2 align-top">
                                <h6>ISO Code</h6>
                                <p class="text-uppercase">ID</p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="p-2 align-top">
                                <h6>Licensee</h6>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-2">Name</div>
                                            <div class="col-lg text-uppercase"><span class="nama_client"></span></div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-lg-2">Address</div>
                                            <div class="col-lg text-uppercase"><span id="alamat_client"></span></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-4">ETPIK Number</div>
                                            <div class="col-lg">N/A</div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-lg-4">Tax Payer Number</div>
                                            <div class="col-lg"><span id="npwp"></span></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <table class="table-bordered w-100">
                        <tr>
                            <td width="70%" class="p-2 align-top">
                                <h6>Commercial description of the timber products</h6>
                                <p class="text-uppercase" id="nama_produk"></p>
                            </td>
                            <td width="30%" class="p-2 align-top">
                                <h6>HS-Heading</h6>
                                <p class="text-uppercase" id="kode_hs"></p>
                            </td>
                        </tr>
                    </table>
                    <table class="table-bordered w-100">
                        <tr>
                            <td width="60%" class="p-2 align-top">
                                <h6>Common and Scientific Names</h6>
                                <p class="text-uppercase" id="nama_jenis"></p>
                            </td>
                            <td width="25%" class="p-2 align-top">
                                <h6>Country of harvest</h6>
                                <p class="text-uppercase" id="negara_panen"></p>
                            </td>
                            <td width="15%" class="p-2 align-top">
                                <h6>ISO Codes</h6>
                                <p class="text-uppercase" id="kode_negara_panen"></p>
                            </td>
                        </tr>
                    </table>
                    <table class="table-bordered w-100">
                        <tr>
                            <td width="33.33%" class="p-2 align-top">
                                <h6>Volume (m3)</h6>
                                <p class="text-uppercase" id="total-volume-1"></p>
                            </td>
                            <td width="33.33%" class="p-2 align-top">
                                <h6>Net Weight (kg)</h6>
                                <p class="text-uppercase" id="total-berat-1"></p>
                            </td>
                            <td width="33.33%" class="p-2 align-top">
                                <h6>Number of Units</h6>
                                <p class="text-uppercase" id="total-unit-1"></p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="p-2 align-top">
                                <h6>Distinguishing marks</h6>
                                <div class="text-uppercase">
                                    INVOICE: <span id="no_invoice"></span> ISSUED <span id="tgl_invoice"></span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="p-2 align-top">
                                <h6>Signature and stamp of issuing authority</h6>
                                <div class="py-4"></div>
                                <div class="row">
                                    <div class="col-lg-2">Name</div>
                                    <div class="col-lg"><?= env('draft.signName'); ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2">Place and date</div>
                                    <div class="col-lg">-</div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="tab-pane fade" id="vlegal-detail">
                    <div class="p-3 pt-4 border">
                        <p class="text-uppercase mb-4">
                            ATTACHMENT V-LEGAL DOCUMENT
                        </p>
                        <table class="w-100">
                            <tr>
                                <td>V-Legal license number</td>
                                <td>:</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>Date of Expiry</td>
                                <td>:</td>
                                <td>-- --- ----</td>
                            </tr>
                            <tr>
                                <td>Issuing authority</td>
                                <td>:</td>
                                <td><?= env('ls.name'); ?> / <?= env('draft.lsNumber'); ?></td>
                            </tr>
                            <tr>
                                <td>Licensee</td>
                                <td>:</td>
                                <td><div class="nama_client text-uppercase"></div></td>
                            </tr>
                            <tr>
                                <td>Importer</td>
                                <td>:</td>
                                <td><div class="nama_buyer text-uppercase"></div></td>
                            </tr>
                        </table>
                        <div class="py-3"></div>
                        <table class="table-bordered" class="align-top">
                            <thead>
                                <tr class="text-left">
                                    <th class="p-1">No</th>
                                    <th class="p-1">Commercial Description of The Timber Products</th>
                                    <th class="p-1">HS-Heading</th>
                                    <th class="p-1">Common and Scientific Names</th>
                                    <th class="p-1">Countries of Harvest</th>
                                    <th class="p-1">ISO Codes</th>
                                    <th class="p-1">Volume (m3)</th>
                                    <th class="p-1">Net Weight (Kg)</th>
                                    <th class="p-1">Number of Units</th>
                                </tr>
                            </thead>
                            <tbody id="row-detail"></tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="6" class="text-center">TOTAL</th>
                                    <td id="total-volume-2"></td>
                                    <td id="total-berat-2"></td>
                                    <td id="total-unit-2"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="#" id="btn-print-draft" target="_blank" class="btn btn-primary">
                    <i class="fa fa-print"></i>
                    Print Draft
                </a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>



<?= $this->section('addons'); ?>

<script type="text/javascript">

    $(function() {
        if ($("#pengajuan-data").length > 0) {

            var table = $("#pengajuan-data").DataTable({

                "processing": true,

                "serverSide": true,

                "ajax": "<?=base_url('pengajuan/json');?>",

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

                        data: 'buyer'

                    },

                    {

                        data: 'negara'

                    },

                    {

                        data: 'loading'

                    },

                    {

                        data: 'discharge'

                    },

                    {

                        data: 'status_dokumen'

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
                        if (row.status_dokumen == 'draft' || row.status_dokumen == 'ditolak') {
                            return `<input name="checked[]" class="check" value="${data}" type="checkbox">`;
                        } else {
                            return '';
                        }
                    }
                }, {
                    "targets": 2,
                    "render": function(data, type, row, meta) {
                        return `<a href="<?=base_url()?>/pengajuan/detail/${row.pengajuan_id}">${row.no_invoice} <br/> <small>${row.tgl_invoice}</small></a>`;
                    }
                }, {
                    "targets": 7,
                    "render": function(data, type, row, meta) {
                        let badge_color = {
                            'draft': 'badge-secondary',
                            'dikirim': 'badge-primary',
                            'diterima': 'badge-success',
                            'ditolak': 'badge-danger',
                            'dibatalkan': 'bg-pink',
                        }

                        let reject = '';
                        if (row.status_dokumen == "ditolak") {
                            reject = ". Silahkan diperbaiki lalu anda bisa mengirim ulang permohonan ini.";
                        }

                        return `<div class="text-center">
                            <small onclick="return status('Status Dokumen (${row.status_dokumen})','${row.keterangan_status} ${reject}')" title="klik untuk lihat keterangan" data-toggle="tooltip" data-placement="left" class="text-uppercase badge ${badge_color[row.status_dokumen]} btn text-white">
                                ${row.status_dokumen}
                            </small>
                        </div>`;
                    }
                }, {

                    "targets": 8,

                    "render": function(data, type, row, meta) {

                        if (row.status_dokumen == 'draft' || row.status_dokumen == 'ditolak') {
                            return `
                                <div class="text-center">
                                    <div class="btn-group">
                                        <a title="Draft V-Legal" data-toggle="tooltip" data-placement="top" class="btn btn-info btn-sm btn-draft" data-id="${row.pengajuan_id}">
                                            <i class="fa fa-print fa-fw"></i>
                                        </a>
                                        <a title="Upload Lampiran" data-toggle="tooltip" data-placement="top" class="btn btn-warning text-dark btn-sm" href="<?=base_url()?>/lampiran/upload/${data}">
                                            <i class="fa fa-upload fa-fw"></i>
                                        </a>

                                        <a onclick="return confirm('Ketika sudah terkirim pengajuan tidak bisa diedit, yakin ingin kirim?')" title="Kirim Pengajuan" data-toggle="tooltip" data-placement="top" class="btn btn-success btn-sm" href="<?=base_url()?>/pengajuan/send/${data}">

                                            <i class="fa fa-paper-plane fa-fw"></i>

                                        </a>

                                        <button type="button" class="btn btn-sm btn-default dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                            <span class="sr-only">Toggle Dropdown</span>

                                        </button>

                                        <div class="dropdown-menu dropdown-menu-right">

                                            <a href="<?=base_url()?>/pengajuan/edit/${data}" class="dropdown-item">

                                                <i class="fa fa-edit fa-fw"></i> Edit Detail Permohonan

                                            </a>

                                            <a href="<?=base_url()?>/detailpengajuan/detail/${data}" class="dropdown-item">

                                                <i class="fa fa-edit fa-fw"></i> Edit Rincian Invoice

                                            </a>

                                            <div class="dropdown-divider"></div>

                                            <form action="/pengajuan/delete/${data}" method="post">

                                                <?= csrf_field(); ?>

                                                <input type="hidden" name="_method" value="DELETE">

                                                <button type="submit" class="dropdown-item" onclick="return confirm('Confirm Delete ?');">

                                                    <i class="fa fa-trash fa-fw"></i> Hapus Permohonan

                                                </button>

                                            </form>

                                        </div>

                                    </div>

                                </div>

                            `;

                        } else if(row.status_dokumen == 'dikirim') {
                            return `
                                <div class="text-center">
                                    <div class="btn-group">
                                        <button data-id="${row.pengajuan_id}" type="button" title="Draft V-Legal" data-toggle="tooltip" data-placement="top" class="btn btn-secondary btn-sm btn-draft">
                                            <i class="fa fa-print fa-fw"></i> Draft
                                        </button>
                                    </div>
                                </div>`;
                        } else if(row.status_dokumen == 'diterima') {
                            return `
                                <div class="text-center">
                                    <div class="btn-group">
                                        <a title="Upload PEB" data-toggle="tooltip" data-placement="top" class="btn btn-success btn-sm" href="<?=base_url()?>/lampiran/peb/${data}">
                                            <i class="fa fa-file-upload fa-fw"></i> PEB
                                        </a>
                                    </div>
                                </div>`;
                        } else {
                            return '';
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

            $('#btn-refresh').on('click', function(){

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

    $(document).on('click', '#pengajuan-data tbody tr .btn-draft', function() {
        $('#modal-draft').modal('show');

        let pengajuan_id = $(this).data('id');
        $('#modal-draft #btn-print-draft').attr('href', '/pengajuan/draft/' + pengajuan_id);

        // Panggil Detail Pengajuan
        $.get("<?=base_url()?>/pengajuan/ajaxdraft/" + pengajuan_id, function(result){
            console.log(result);
            $('#modal-draft .nama_buyer').text(result.nama_buyer);
            $('#modal-draft #alamat_buyer').text(result.alamat_buyer);
            $('#modal-draft #nama_loading').text(result.nama_loading);
            $('#modal-draft #nama_discharge').text(result.nama_discharge);
            $('#modal-draft #nama_negara').text(result.nama_negara);
            $('#modal-draft #kode_negara').text(result.kode_negara);
            $('#modal-draft #mata_uang').text(result.mata_uang);

            alat_angkut = {
                1:'By Sea',
                2:'By Air',
                3:'By Land',
            };
            $('#modal-draft #alat_angkut').text(alat_angkut[result.alat_angkut]);

            $('#modal-draft .nama_client').text(result.nama_client);
            $('#modal-draft #alamat_client').text(result.alamat_client);
            $('#modal-draft #npwp').text(formatNpwp(result.npwp));
            $('#modal-draft #no_invoice').text(result.no_invoice);

            let getTglInv = new Date(result.tgl_invoice);
            let tglInv = getTglInv.getDate();
            let thnInv = getTglInv.getFullYear();
            let blnInv = getTglInv.toLocaleDateString('default', {month: 'long' });
            $('#modal-draft #tgl_invoice').text(`${tglInv} ${blnInv} ${thnInv}`);
        });

        // Panggil Detail Produk
        $.get("<?=base_url()?>/pengajuan/ajaxdraftdetail/" + pengajuan_id, function(result){
            $('#modal-draft #total-nilai').text(result.totalNilai);
            $('#modal-draft #total-volume-1').text(result.totalVol);
            $('#modal-draft #total-berat-1').text(result.totalBerat);
            $('#modal-draft #total-unit-1').text(result.totalUnit);

            if(result.detail.length == 1) {
                $('#modal-draft #nav-detail').toggle();
                $('#modal-draft #nama_produk').text(result.detail[0].nama_produk);
                $('#modal-draft #kode_hs').text(result.detail[0].kode_hs);
                $('#modal-draft #nama_jenis').text(result.nm_jns);
                $('#modal-draft #negara_panen').text(result.nm_ngr);
                $('#modal-draft #kode_negara_panen').text(result.kd_ngr);
            } else {
                $('#modal-draft #nama_produk, #modal-draft #kode_hs, #modal-draft #nama_jenis, #modal-draft #negara_panen, #modal-draft #kode_negara_panen').text('ENCLOSED');

                let rowDetail = '';
                $.each(result.detail, function(index, data){
                    rowDetail += `<tr>
                        <td>${index + 1}</td>
                        <td>${data.nama_produk}</td>
                        <td>${data.kode_hs}</td>
                        <td class="text-break">${data.nm_jns}</td>
                        <td class="text-break">${data.nm_ngr}</td>
                        <td class="text-break">${data.kd_ngr}</td>
                        <td>${data.volume}</td>
                        <td>${data.berat}</td>
                        <td>${data.jumlah}</td>
                    </tr>`;
                });

                $('#modal-draft #row-detail').html(rowDetail);
                $('#modal-draft #total-volume-2').text(result.totalVol);
                $('#modal-draft #total-berat-2').text(result.totalBerat);
                $('#modal-draft #total-unit-2').text(result.totalUnit);
            }
        });
    });

    function bulk_delete() {

        if ($('#pengajuan-data tbody tr .check:checked').length == 0) {

            alert('Tidak ada data yang dipilih');

        } else {

            if (confirm('Confirm delete?')) {

                $('#form-bulk').submit();

            }

        }

    }

    function formatNpwp(value) {
        value = value.replace(/[A-Za-z\W\s_]+/g, '');
        let split = 6;
        const dots = [];

        for (let i = 0, len = value.length; i < len; i += split) {
            split = i >= 2 && i <= 6 ? 3 : i >= 8 && i <= 12 ? 4 : 2;
            dots.push(value.substr(i, split));
        }

        const temp = dots.join('.');
        return temp.length > 12 ? `${temp.substr(0, 12)}-${temp.substr(12, 7)}` : temp;
    }

</script>

<?= $this->endSection();
