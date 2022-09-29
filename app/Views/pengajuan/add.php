<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="row justify-content-center">
    <div class="col-md-9">
        <?= session()->getFlashdata('pesan'); ?>
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h5 class="card-title">Form <?= $title; ?></h5>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <a href="<?= base_url(); ?>/pengajuan" class="btn btn-sm btn-default">Kembali</a>
                </div>
            </div>
            <!-- /.card-header -->
            <?= form_open('pengajuan/save', ['autocomplete'=>'off']); ?>
            <div class="card-body">
                <?= csrf_field(); ?>
                <div class="form-group row">
                    <label for="buyer_id" class="col-sm-3 col-form-label font-weight-normal">Pembeli</label>
                    <div class="col-sm-9">
                        <select class="form-control custom-select select2 <?= $validation->hasError('buyer_id') ? 'is-invalid' : ''; ?>" name="buyer_id" id="buyer_id">
                            <option value="" selected disabled>- Pilih Pembeli -</option>
                            <?php foreach ($buyer as $b) : ?>
                                <?php if(userdata('user_id') == $b['user_id'] && $b['status'] == "1") : ?>
                                    <option data-negara="<?= $b['nama_negara']; ?>" data-alamat="<?= $b['alamat_buyer']; ?>" value="<?= $b['buyer_id']; ?>" <?= set_select('buyer_id', $b['buyer_id']); ?>><?= $b['nama_buyer']; ?> - <?= $b['kode_negara']; ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">
                            <?= $validation->getError('buyer_id'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="alamat_buyer" class="col-sm-3 col-form-label font-weight-normal">Alamat</label>
                    <div class="col-sm-9">
                        <textarea placeholder="Alamat" id="alamat_buyer" rows="2" class="form-control" readonly></textarea>
                    </div>
                </div>
                <div class="py-3"></div>
                <div class="form-group row">
                    <label for="mata_uang" class="col-sm-3 col-form-label font-weight-normal">Mata Uang</label>
                    <div class="col-sm-9">
                        <select class="form-control custom-select select2 <?= $validation->hasError('mata_uang') ? 'is-invalid' : ''; ?>" name="mata_uang" id="mata_uang">
                            <option value="" selected>- Pilih Mata Uang -</option>
                            <?php foreach ($uang as $u) : ?>
                            <option value="<?= $u['iso_4217']; ?>" <?= set_select('mata_uang', $u['iso_4217']); ?>><?= $u['iso_4217']; ?> - <?= $u['nama_uang']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">
                            <?= $validation->getError('mata_uang'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="loading_id" class="col-sm-3 col-form-label font-weight-normal">Port of Loading</label>
                    <div class="col-sm-9">
                        <select class="form-control custom-select select2 <?= $validation->hasError('loading_id') ? 'is-invalid' : ''; ?>" name="loading_id" id="loading_id">
                            <option value="" selected>- Pilih Port of Loading -</option>
                            <?php foreach ($loading as $l) : ?>
                            <option value="<?= $l['loading_id']; ?>" <?= set_select('loading_id', $l['loading_id']); ?>>[<?= $l['kode_loading']; ?>] <?= $l['nama_loading']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">
                            <?= $validation->getError('loading_id'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="discharge_id" class="col-sm-3 col-form-label font-weight-normal">Port of Discharge</label>
                    <div class="col-sm-4 pb-3 pb-sm-0">
                        <select class="form-control custom-select select2 <?= $validation->hasError('negara_id') ? 'is-invalid' : ''; ?>" name="negara_id" id="negara_id">
                            <option value="" selected>- Negara Tujuan -</option>
                            <?php foreach ($negara as $n) : ?>
                            <option value="<?= $n['negara_id']; ?>" <?= set_select('negara_id', $n['negara_id']); ?>><?= $n['nama_negara']; ?> - <?= $n['kode_negara']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">
                            <?= $validation->getError('negara_id'); ?>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <select class="form-control custom-select select-discharge <?= $validation->hasError('discharge_id') ? 'is-invalid' : ''; ?>" name="discharge_id" id="discharge_id">
                            <option value="" selected>- Port of Discharge -</option>
                        </select>
                        <div class="invalid-feedback">
                            <?= $validation->getError('discharge_id'); ?>
                        </div>
                    </div>
                </div>
                <div class="py-3"></div>
                <div class="form-group row">
                    <label for="no_sertifikat" class="col-sm-3 col-form-label font-weight-normal">Nomor Sertifikat / NPWP</label>
                    <div class="col-sm-4 mb-3 mb-sm-0">
                        <input readonly class="form-control" value="<?= old('no_sertifikat', $client['no_sertifikat']); ?>" type="text">
                    </div>
                    <div class="col-sm-5">
                        <input readonly class="form-control" value="<?= old('npwp', $client['npwp']); ?>" type="text">
                    </div>
                </div>
                <div class="py-3"></div>
                <div class="form-group row">
                    <label for="no_invoice" class="col-sm-3 col-form-label font-weight-normal">Invoice</label>
                    <div class="col-sm-5 mb-3 mb-sm-0">
                        <input placeholder="Nomor Invoice" class="form-control <?= $validation->hasError('no_invoice') ? 'is-invalid' : ''; ?>" value="<?= old('no_invoice'); ?>" type="text" name="no_invoice" id="no_invoice">
                        <div class="invalid-feedback">
                            <?= $validation->getError('no_invoice'); ?>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <input placeholder="Tanggal Invoice" class="form-control gijgo <?= $validation->hasError('tgl_invoice') ? 'is-invalid' : ''; ?>" value="<?= old('tgl_invoice'); ?>" type="text" name="tgl_invoice" id="tgl_invoice">
                        <div class="invalid-feedback">
                            <?= $validation->getError('tgl_invoice'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="alat_angkut" class="col-sm-3 col-form-label font-weight-normal">Pengiriman</label>
                    <div class="col-sm-4 mb-3 mb-sm-0">
                        <select name="alat_angkut" id="alat_angkut" class="form-control <?= $validation->hasError('alat_angkut') ? 'is-invalid' : ''; ?>">
                            <option value="">- Pilih Alat Angkut -</option>
                            <option value="1">By sea</option>
                            <option value="2">By air</option>
                            <option value="3">By land</option>
                        </select>
                        <div class="invalid-feedback">
                            <?= $validation->getError('alat_angkut'); ?>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <input placeholder="Tanggal Shipment" class="form-control gijgo <?= $validation->hasError('tgl_shipment') ? 'is-invalid' : ''; ?>" value="<?= old('tgl_shipment'); ?>" type="text" name="tgl_shipment" id="tgl_shipment">
                        <div class="invalid-feedback">
                            <?= $validation->getError('tgl_shipment'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="keterangan" class="col-sm-3 col-form-label font-weight-normal">Keterangan</label>
                    <div class="col-sm-9">
                        <textarea readonly placeholder="Keterangan" name="keterangan" id="keterangan" rows="1" class="form-control <?= $validation->hasError('keterangan') ? 'is-invalid' : ''; ?>"><?= old('keterngan'); ?></textarea>
                        <div class="invalid-feedback">
                            <?= $validation->getError('keterangan'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="lokasi_stuffing" class="col-sm-3 col-form-label font-weight-normal">Lokasi Stuffing</label>
                    <div class="col-sm-9">
                        <input placeholder="Lokasi Stuffing" class="form-control <?= $validation->hasError('lokasi_stuffing') ? 'is-invalid' : ''; ?>" value="<?= old('lokasi_stuffing'); ?>" type="text" name="lokasi_stuffing" id="lokasi_stuffing">
                        <div class="invalid-feedback">
                            <?= $validation->getError('lokasi_stuffing'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer text-right">
                <a href="" class="btn btn-default">Reset</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('addons'); ?>
<script type="text/javascript">
$(function() {
    $('#buyer_id').on('change', function() {
        let alamat = $('body #alamat_buyer');
        let buyer = $('#buyer_id').find(":selected");

        alamat.val('');
        alamat.val(buyer.data('alamat'));
    });

    $('#negara_id').on('change', function() {
        $('#discharge_id').val(null).trigger('change');

        let negara = $(this).val();
        let base_url = "<?=base_url()?>";
        let url = base_url + '/pengajuan/getDischarge/' + negara;
        let discharge = $('#discharge_id');

        $('#discharge_id').select2({
            minimumInputLength: 3,
            allowClear: true,
            placeholder: 'Port of Discharge',
            ajax: {
                dataType: 'json',
                url: url,
                delay: 800,
                data: function (params) {
                    var query = {
                        search: params.term,
                    }
                    
                    return query;
                },
                processResults: function (data, page) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });
    });
});
</script>
<?= $this->endSection(); ?>