<?= $this->extend('layout/auth'); ?>

<?= $this->section('content'); ?>
<?= session()->getFlashdata('pesan'); ?>
<p class="login-box-msg small">Masukkan password baru</p>
<?= form_open('auth/simpan', ['autocomplete'=>'off'], ['user_id'=>$user['user_id'],'token'=>$token]); ?>
<?= csrf_field(); ?>
<div class="form-group">
    <div class="input-group">
        <input type="password" name="password" class="form-control <?= $validation->hasError('password') ? 'is-invalid' : ''; ?>" placeholder="Password">
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-fw fa-lock"></span>
            </div>
        </div>
        <div class="invalid-feedback">
            <?= $validation->getError('password'); ?>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="input-group">
        <input type="password" name="password2" class="form-control <?= $validation->hasError('password2') ? 'is-invalid' : ''; ?>" placeholder="Konfirmasi Password">
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-fw fa-lock"></span>
            </div>
        </div>
        <div class="invalid-feedback">
            <?= $validation->getError('password2'); ?>
        </div>
    </div>
</div>
<button type="submit" class="btn bg-<?= env('theme.color') ?> btn-block">Ganti Password</button>
<p class="small text-center text-muted pt-2">
    <a href="<?= base_url('auth'); ?>">Login</a>
</p>
<?= form_close(); ?>
<?= $this->endSection(); ?>