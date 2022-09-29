<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<?= form_open_multipart('pembatalan/save'); ?>
<?= csrf_field(); ?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-outline card-lightblue">
            <div class="card-header">
                <h5 class="card-title mt-1">
                    Pembatalan Dokumen
                </h5>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <a href="<?= base_url('/pembatalan'); ?>" class="btn btn-sm btn-default">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label for="no_dokumen" class="col-sm-3 col-form-label font-weight-normal">
                        Nomor V-Legal
                        <sup class="text-danger">*</sup>
                    </label>
                    <div class="col-sm-9">
                        <input required minlength="24" maxlength="24" type="text" placeholder="<?= date('y') ?>.00000-00000.007.XX-XX" name="no_dokumen" id="no_dokumen" class="form-control <?= $validation->hasError('no_dokumen') ? 'is-invalid' : ''; ?>" value="<?= old('no_dokumen', $no_dokumen); ?>" <?= $no_dokumen?"readonly":""; ?>>
                        <div class="invalid-feedback">
                            <?= $validation->getError('no_dokumen'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="no_invoice" class="col-sm-3 col-form-label font-weight-normal">
                        Nomor Invoice
                        <sup class="text-danger">*</sup>
                    </label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="Nomor Invoice yang sebelumnya (jika ganti)" name="no_invoice" id="no_invoice" class="form-control <?= $validation->hasError('no_invoice') ? 'is-invalid' : ''; ?>" value="<?= old('no_invoice'); ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('no_invoice'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="keterangan" class="col-sm-3 col-form-label font-weight-normal">
                        Keterangan
                        <sup class="text-danger">*</sup>
                    </label>
                    <div class="col-sm-9">
                        <textarea maxlength="255" placeholder="Alasan Pembatalan" name="keterangan" id="keterangan" rows="3" class="form-control <?= $validation->hasError('keterangan') ? 'is-invalid' : ''; ?>"><?= old('keterangan'); ?></textarea>
                        <div class="invalid-feedback">
                            <?= $validation->getError('keterangan'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="surat_pembatalan" class="col-sm-3 col-form-label font-weight-normal">
                        Surat Pembatalan
                        <sup class="text-danger">*</sup>
                    </label>
                    <div class="col-sm-9">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="surat_pembatalan" id="surat_pembatalan" accept=".jpeg,.jpg,.png,.pdf,.doc,.docx,.xls,.xlsx">
                            <label class="custom-file-label" for="surat_pembatalan">File Surat</label>
                        </div>
                        <small class="text-muted">.pdf, .doc atau .docx</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="peb" class="col-sm-3 col-form-label font-weight-normal">
                        Notul PEB
                    </label>
                    <div class="col-sm-9">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="peb" id="peb" accept=".jpeg,.jpg,.png,.pdf,.doc,.docx,.xls,.xlsx">
                            <label class="custom-file-label" for="peb">File PEB</label>
                        </div>
                        <span class="text-muted small">Jika status <b>SUDAH DIPAKAI</b>, wajib melampirkan PEB</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-secondary">Reset</button>
                <button type="submit" class="btn btn-primary" onclick="return confirm('Kirim Pembatalan?')">Kirim</button>
            </div>
        </div>
    </div>
</div>
<?= form_close(); ?>
<?= $this->endSection(); ?>