<?= $this->extend('layout/auth'); ?>

<?= $this->section('content'); ?>
<?= $this->extend('layout/auth'); ?>

<?= $this->section('content'); ?>
<p class="login-box-msg small">Lengkapi form dibawah ini</p>
<?= form_open('auth/save', ['autocomplete'=>'off']); ?>
<?= csrf_field(); ?>
<div class="form-group">
    <div class="input-group">
        <input value="<?= old('name') ?>" autofocus onfocus="this.select()" name="name" type="text" class="form-control <?= $validation->hasError('name') ? 'is-invalid' : ''; ?>" placeholder="Nama">
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="far fa-fw fa-user"></span>
            </div>
        </div>
        <div class="invalid-feedback">
            <?= $validation->getError('name'); ?>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="input-group">
        <input value="<?= old('email') ?>" name="email" type="text" class="form-control <?= $validation->hasError('email') ? 'is-invalid' : ''; ?>" placeholder="Email">
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-fw fa-envelope"></span>
            </div>
        </div>
        <div class="invalid-feedback">
            <?= $validation->getError('email'); ?>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="input-group">
        <input value="<?= old('username') ?>" name="username" type="text" class="form-control <?= $validation->hasError('username') ? 'is-invalid' : ''; ?>" placeholder="Username">
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-fw fa-user"></span>
            </div>
        </div>
        <div class="invalid-feedback">
            <?= $validation->getError('username'); ?>
        </div>
    </div>
</div>
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
<button type="submit" class="btn bg-<?= env('theme.color') ?> btn-block">Daftar</button>
<p class="small text-center text-muted pt-2">
    Sudah punya akun ? <br>
    <a href="<?= base_url('auth/index'); ?>">Login</a>
</p>
<?= form_close(); ?>
<?= $this->endSection(); ?>