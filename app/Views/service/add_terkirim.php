<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<?= form_open_multipart('service/save_terkirim'); ?>
<?= csrf_field(); ?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-outline card-lightblue">
            <div class="card-header">
                <h5 class="card-title mt-1">
                    <?= $title ?>
                </h5>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <a href="<?= base_url('/terkirim'); ?>" class="btn btn-sm btn-default">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label for="no_invoice" class="col-sm-3 col-form-label font-weight-normal">
                        Nomor Invoice
                        <sup class="text-danger">*</sup>
                    </label>
                    <div class="col-sm-9">
                        <select name="no_invoice" class="form-control" id="no_invoice">
                            <option value="">Pilih Invoice</option>
                            <?php foreach($no_invoice as $item): ?>
                                <option value="<?=$item['no_invoice']?>"><?=$item['no_invoice']?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">
                            <?= $validation->getError('no_invoice'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="no_dokumen" class="col-sm-3 col-form-label font-weight-normal">
                        Nomor V-Legal
                        <sup class="text-danger">*</sup>
                    </label>
                    <div class="col-sm-9">
                        <input required minlength="24" maxlength="24" type="text" placeholder="<?= date('y') ?>.00000-00000.007.XX-XX" name="no_dokumen" id="no_dokumen" class="form-control <?= $validation->hasError('no_dokumen') ? 'is-invalid' : ''; ?>" value="<?= old('no_dokumen'); ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('no_dokumen'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="barcode" class="col-sm-3 col-form-label font-weight-normal">
                        Barcode
                        <sup class="text-danger">*</sup>
                    </label>
                    <div class="col-sm-9">
                        <input type="text" name="barcode" id="barcode" class="form-control <?= $validation->hasError('barcode') ? 'is-invalid' : ''; ?>" value="<?= old('barcode'); ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('barcode'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-secondary">Reset</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>
<?= form_close(); ?>
<?= $this->endSection(); ?>