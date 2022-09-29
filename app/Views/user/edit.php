<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="row justify-content-center">
    <div class="col-md-4">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h5 class="card-title">
                    Form
                    <?= $title; ?>
                </h5>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <a href="<?= base_url(); ?>/user" class="btn btn-sm btn-default">Kembali</a>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <?= form_open('user/update', '', ['user_id'=>$user['user_id']]); ?>
                <?= csrf_field(); ?>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input class="form-control <?= $validation->hasError('username') ? 'is-invalid' : ''; ?>" value="<?= old('username', $user['username']); ?>" type="text" name="username" id="username">
                    <div class="invalid-feedback">
                        <?= $validation->getError('username'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input class="form-control <?= $validation->hasError('password') ? 'is-invalid' : ''; ?>" value="<?= old('password'); ?>" type="password" name="password" id="password">
                    <span class="text-muted small">Kosongkan jika tidak ingin mengubah password.</span>
                    <div class="invalid-feedback">
                        <?= $validation->getError('password'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name">Nama</label>
                    <input class="form-control <?= $validation->hasError('name') ? 'is-invalid' : ''; ?>" value="<?= old('name', $user['name']); ?>" type="text" name="name" id="name">
                    <div class="invalid-feedback">
                        <?= $validation->getError('name'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input class="form-control <?= $validation->hasError('email') ? 'is-invalid' : ''; ?>" value="<?= old('email', $user['email']); ?>" type="text" name="email" id="email">
                    <div class="invalid-feedback">
                        <?= $validation->getError('email'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="role">Role</label>
                    <select class="form-control <?= $validation->hasError('role') ? 'is-invalid' : ''; ?>" name="role" id="role">
                        <option value="" selected></option>
                        <option <?= selected('admin', $user['role']); ?> value="admin" <?= set_select('role', 'admin'); ?>>Admin</option>
                        <option <?= selected('client', $user['role']); ?> value="client" <?= set_select('role', 'client'); ?>>Client</option>
                        <option <?= selected('superadmin', $user['role']); ?> value="superadmin" <?= set_select('role', 'superadmin'); ?>>Super Admin</option>
                    </select>
                    <div class="invalid-feedback">
                        <?= $validation->getError('role'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control <?= $validation->hasError('status') ? 'is-invalid' : ''; ?>" name="status" id="status">
                        <option value="" selected></option>
                        <option <?= selected('1', $user['status']); ?> value="1" <?= set_select('status', '1'); ?>>Aktif</option>
                        <option <?= selected('0', $user['status']); ?> value="0" <?= set_select('status', '0'); ?>>Nonaktif</option>
                    </select>
                    <div class="invalid-feedback">
                        <?= $validation->getError('status'); ?>
                    </div>
                </div>
                <button type="submit" class="btn btn-block btn-primary">Simpan</button>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>