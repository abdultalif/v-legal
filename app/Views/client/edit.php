<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<?= form_open('client/update', ['autocomplete'=>'off'], ['client_id'=>$client['client_id'],'user_id'=>$client['user_id']]); ?>
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card card-outline card-lightblue">
            <div class="card-header">
                Identitas Eksportir
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="nama_client">
                        Nama Auditee/Eksportir
                        <sup class="text-danger">*</sup>
                    </label>
                    <input placeholder="Nama Client" class="form-control <?= $validation->hasError('nama_client') ? 'is-invalid' : ''; ?>" value="<?= old('nama_client', $client['nama_client']); ?>" type="text" name="nama_client" id="nama_client">
                    <div class="invalid-feedback">
                        <?= $validation->getError('nama_client'); ?>
                    </div>
                </div>
                <div class="row row-cols-2">
                    <div class="col">
                        <div class="form-group">
                            <label for="provinsi_id">
                                Provinsi
                                <sup class="text-danger">*</sup>
                            </label>
                            <select data-kab="<?=$client['kabupaten_id']?>" class="form-control select2 <?= $validation->hasError('provinsi_id') ? 'is-invalid' : ''; ?>" name="provinsi_id" id="provinsi_id">
                                <option value="" selected>Provinsi</option>
                                <?php foreach ($provinsi as $p) : ?>
                                <?php if ($p['status'] == 1) : ?>
                                <option <?= selected($p['provinsi_id'], $client['provinsi_id']); ?> value="
                                    <?= $p['provinsi_id']; ?>" <?= set_select('provinsi_id', $p['provinsi_id']); ?>>
                                    <?= $p['nama_provinsi']; ?>
                                </option>
                                <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">
                                <?= $validation->getError('provinsi_id'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="kabupaten_id">
                                Kabupaten
                                <sup class="text-danger">*</sup>
                            </label>
                            <select class="form-control select2 <?= $validation->hasError('kabupaten_id') ? 'is-invalid' : ''; ?>" name="kabupaten_id" id="kabupaten_id">
                                <option value="" selected>Kabupaten</option>
                            </select>
                            <div class="invalid-feedback">
                                <?= $validation->getError('kabupaten_id'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>
                        Alamat Kantor
                        <sup class="text-danger">*</sup>
                    </label>
                    <textarea rows="4" placeholder="Alamat Client" name="alamat_client" id="alamat_client" class="form-control <?= $validation->hasError('alamat_client') ? 'is-invalid' : ''; ?>"><?= old('alamat_client', $client['alamat_client']); ?></textarea>
                    <div class="invalid-feedback">
                        <?= $validation->getError('alamat_client'); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md">
                        <div class="form-group">
                            <label>
                                NPWP
                                <sup class="text-danger">*</sup>
                            </label>
                            <input placeholder="Nomor NPWP" class="form-control <?= $validation->hasError('npwp') ? 'is-invalid' : ''; ?>" value="<?= old('npwp', $client['npwp']); ?>" type="text" name="npwp" id="npwp">
                            <div class="invalid-feedback">
                                <?= $validation->getError('npwp'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form-group">
                            <label>
                                No. ETPIK
                                <sup class="text-danger">*</sup>
                            </label>
                            <input placeholder="No. ETPIK" class="form-control <?= $validation->hasError('no_etpik') ? 'is-invalid' : ''; ?>" value="<?= old('no_etpik', $client['no_etpik']); ?>" type="text" name="no_etpik" id="no_etpik">
                            <div class="invalid-feedback">
                                <?= $validation->getError('no_etpik'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>
                        Sertifikat LK
                        <sup class="text-danger">*</sup>
                    </label>
                    <div class="row row-cols-2">
                        <div class="col-12 mb-3">
                            <input placeholder="Nomor Sertifikat" class="form-control <?= $validation->hasError('no_sertifikat') ? 'is-invalid' : ''; ?>" value="<?= old('no_sertifikat', $client['no_sertifikat']); ?>" type="text" name="no_sertifikat" id="no_sertifikat">
                            <div class="invalid-feedback">
                                <?= $validation->getError('no_sertifikat'); ?>
                            </div>
                        </div>
                        <div class="col">
                            <input placeholder="Tanggal Berlaku Sertifikat" class="form-control gijgo <?= $validation->hasError('tgl_sertifikat') ? 'is-invalid' : ''; ?>" value="<?= old('tgl_sertifikat', $client['tgl_sertifikat']); ?>" type="text" name="tgl_sertifikat" id="tgl_sertifikat">
                            <div class="invalid-feedback">
                                <?= $validation->getError('tgl_sertifikat'); ?>
                            </div>
                        </div>
                        <div class="col">
                            <input placeholder="Tanggal Berakhir Sertifikat" class="form-control gijgo <?= $validation->hasError('tgl_kadaluwarsa_sertifikat') ? 'is-invalid' : ''; ?>" value="<?= old('tgl_kadaluwarsa_sertifikat', $client['tgl_kadaluwarsa_sertifikat']); ?>" type="text" name="tgl_kadaluwarsa_sertifikat" id="tgl_kadaluwarsa_sertifikat">
                            <div class="invalid-feedback">
                                <?= $validation->getError('tgl_kadaluwarsa_sertifikat'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row row-cols-2">
                    <div class="col">
                        <div class="form-group">
                            <label for="telepon">Telepon</label>
                            <input placeholder="Telepon" class="form-control <?= $validation->hasError('telepon') ? 'is-invalid' : ''; ?>" value="<?= old('telepon', $client['telepon']); ?>" type="text" name="telepon" id="telepon">
                            <div class="invalid-feedback">
                                <?= $validation->getError('telepon'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="fax">Fax</label>
                            <input placeholder="Fax" class="form-control <?= $validation->hasError('fax') ? 'is-invalid' : ''; ?>" value="<?= old('fax', $client['fax']); ?>" type="text" name="fax" id="fax">
                            <div class="invalid-feedback">
                                <?= $validation->getError('fax'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row row-cols-2">
                    <div class="col">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input placeholder="Email" class="form-control <?= $validation->hasError('email') ? 'is-invalid' : ''; ?>" value="<?= old('email', $client['email']); ?>" type="text" name="email" id="email">
                            <div class="invalid-feedback">
                                <?= $validation->getError('email'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="website">Website</label>
                            <input placeholder="Website" class="form-control <?= $validation->hasError('website') ? 'is-invalid' : ''; ?>" value="<?= old('website', $client['website']); ?>" type="text" name="website" id="website">
                            <div class="invalid-feedback">
                                <?= $validation->getError('website'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if (is_superadmin()): ?>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control <?= $validation->hasError('status') ? 'is-invalid' : ''; ?>" name="status" id="status">
                        <option value="" selected></option>
                        <option <?= selected(1, $client['status']); ?> value="1" <?= set_select('status', '1'); ?>>Aktif</option>
                        <option <?= selected(0, $client['status']); ?> value="0" <?= set_select('status', '0'); ?>>Nonaktif</option>
                    </select>
                    <div class="invalid-feedback">
                        <?= $validation->getError('status'); ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-secondary">Reset</button>
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</div>
<?= form_close(); ?>
<?= $this->endSection(); ?>

<?= $this->section('addons'); ?>
<script type="text/javascript">
$(document).ready(function() {
    $('#provinsi_id').on('change', function() {
        let prov = $(this).val();
        let kabId = $(this).data('kab');
        let base_url = "<?=base_url()?>";
        let url = base_url + '/client/getKabupaten/' + prov;
        $.getJSON(url, function(data) {
            $('#kabupaten_id').html('');
            data.forEach(function(data) {
                let option = `<option value="${data.kabupaten_id}">${data.nama_kabupaten}</option>`;
                $('#kabupaten_id').append(option);
            });
            $('#kabupaten_id').val(kabId).trigger('change');
        });
    });
    $('#provinsi_id').trigger('change');
});
</script>
<?= $this->endSection(); ?>