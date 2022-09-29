<?= $this->extend('layout/auth'); ?>

<?= $this->section('content'); ?>
<?= session()->getFlashdata('pesan'); ?>
<p class="login-box-msg small">Masukkan email untuk mengirim password</p>
<?= form_open('auth/send', ['autocomplete'=>'off'], ['captcha_code'=>$captcha]); ?>
<?= csrf_field(); ?>
<div class="form-group">
    <div class="input-group">
        <input value="<?= old('email') ?>" autofocus onfocus="this.select()" name="email" type="text" class="form-control <?= $validation->hasError('email') ? 'is-invalid' : ''; ?>" placeholder="Email">
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-envelope"></span>
            </div>
        </div>
        <div class="invalid-feedback">
            <?= $validation->getError('email'); ?>
        </div>
    </div>
</div>
<div id="captcha-form" class="bg-light mb-3 p-2 border rounded user-select-none">
    <div class="row mb-0">
        <div class="col-5 d-flex justify-content-center">
            <span id="captcha-text" class="text-<?= env('theme.color') ?> font-weight-bold align-self-center"><?= $captcha; ?></span>
        </div>
        <div class="col-7">
            <input name="captcha" type="text" class="form-control form-control-sm <?= $validation->hasError('captcha') ? 'is-invalid' : ''; ?>" placeholder="Ketik kata disamping">
        </div>
    </div>
</div>
<button type="submit" class="btn bg-<?= env('theme.color') ?> btn-block">Kirim</button>
<p class="small text-center text-muted pt-2">
    <a href="<?= base_url('auth'); ?>">Kembali</a>
</p>
<?= form_close(); ?>
<?= $this->endSection(); ?>