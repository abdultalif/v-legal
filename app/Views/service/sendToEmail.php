<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<?= form_open('service/proseskirim'); ?>
<?= csrf_field(); ?>
<div class="row">
    <div class="col-md-5">
        <div class="card card-outline card-lightblue">
            <div class="card-header">
                <h5 class="card-title mt-1">
                    Form Kirim Email
                </h5>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <a href="<?= base_url('/terkirim'); ?>" class="btn btn-sm btn-default"><i class="fa fa-arrow-left"></i> Kembali</a>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label for="no_vlegal" class="col-sm-3 col-form-label font-weight-normal">Nomor</label>
                    <div class="col-sm">
                        <input readonly value="<?=$no_vlegal?>" type="text" name="no_vlegal" id="no_vlegal" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="subject" class="col-sm-3 col-form-label font-weight-normal">Subject <sup class="text-danger">*</sup></label>
                    <div class="col-sm">
                        <input type="text" name="subject" id="subject" class="form-control <?= $validation->hasError('subject') ? 'is-invalid' : ''; ?>" value="<?= old('subject', $no_invoice); ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('subject'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-sm-3 col-form-label font-weight-normal">Email <sup class="text-danger">*</sup></label>
                    <div class="col-sm">
                        <input type="text" name="email" id="email" class="form-control <?= $validation->hasError('email') ? 'is-invalid' : ''; ?>" value="<?= old('email', $email); ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('email'); ?>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary" onclick="this.disabled=true;this.innerHTML='<span class=\'spinner-border spinner-border-sm\'></span> Loading...';this.form.submit();">
                        Kirim V-Legal
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>