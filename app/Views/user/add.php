<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="row justify-content-center">
    <div class="col-md-4">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h5 class="card-title">
                    Form <?= $title; ?>
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
                <?= form_open('user/save'); ?>
                <?= csrf_field(); ?>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input placeholder="Username" class="form-control <?= $validation->hasError('username') ? 'is-invalid' : ''; ?>" value="<?= old('username'); ?>" type="text" name="username" id="username">
                    <div class="invalid-feedback">
                        <?= $validation->getError('username'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input placeholder="Password" class="form-control <?= $validation->hasError('password') ? 'is-invalid' : ''; ?>" value="<?= old('password'); ?>" type="password" name="password" id="password">
                    <div class="invalid-feedback">
                        <?= $validation->getError('password'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name">Nama</label>
                    <input placeholder="Nama User" class="form-control <?= $validation->hasError('name') ? 'is-invalid' : ''; ?>" value="<?= old('name'); ?>" type="text" name="name" id="name">
                    <div class="invalid-feedback">
                        <?= $validation->getError('name'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input placeholder="Email" class="form-control <?= $validation->hasError('email') ? 'is-invalid' : ''; ?>" value="<?= old('email'); ?>" type="text" name="email" id="email">
                    <div class="invalid-feedback">
                        <?= $validation->getError('email'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="role">Role</label>
                    <select class="custom-select <?= $validation->hasError('role') ? 'is-invalid' : ''; ?>" name="role" id="role">
                        <option value="" selected>-- Pilih Role --</option>
                        <option value="admin" <?= set_select('role', 'admin'); ?>>Admin</option>
                        <option value="client" <?= set_select('role', 'client'); ?>>Client</option>
                        <option value="superadmin" <?= set_select('role', 'superadmin'); ?>>Super Admin</option>
                    </select>
                    <div class="invalid-feedback">
                        <?= $validation->getError('role'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="custom-select <?= $validation->hasError('status') ? 'is-invalid' : ''; ?>" name="status" id="status">
                        <option value="" selected>-- Pilih Status --</option>
                        <option value="1" <?= set_select('status', '1'); ?>>Aktif</option>
                        <option value="0" <?= set_select('status', '0'); ?>>Nonaktif</option>
                    </select>
                    <div class="invalid-feedback">
                        <?= $validation->getError('status'); ?>
                    </div>
                </div>
                <button type="submit" class="btn btn-block btn-primary">Simpan
                </button>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>