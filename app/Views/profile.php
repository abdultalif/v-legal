<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<?= form_open_multipart('home/save_profile'); ?>
<?= csrf_field(); ?>
<div class="row row-cols-1 row-cols-md-2">
    <div class="col-md-4">
        <!-- Profile Image -->
        <div class="card card-primary card-outline h-100">
            <div class="card-body box-profile">
                <div class="text-center mb-3">
                    <img class="profile-user-img img-fluid img-circle" src="<?= base_url(); ?>/img/user/<?= userdata('foto'); ?>" alt="User profile picture">
                </div>
                <h3 class="profile-username text-center"><?= userdata('name'); ?></h3>
                <p class="text-muted text-center text-capitalize"><?= userdata('role'); ?></p>
                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="foto" id="foto" aria-describedby="inputGroupFileAddon01">
                            <label class="custom-file-label" for="foto">Ganti Foto</label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <b>Bergabung sejak</b> <a class="float-right"><?= format_tanggal(userdata('created_at'), 'M/Y'); ?></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card card-primary card-outline h-100">
            <div class="card-header">
                <h3 class="card-title">Edit Profile</h3>
                <div class="card-tools">
                    <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </div>
            <div class="card-body box-profile">
                <form class="form-horizontal">
                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input value="<?= old('name', userdata('name')); ?>" type="text" class="form-control <?= $validation->hasError('name') ? 'is-invalid' : ''; ?>" name="name" id="name" placeholder="Name">
                            <div class="invalid-feedback">
                                <?= $validation->getError('name'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input value="<?= old('email', userdata('email')); ?>" type="text" class="form-control <?= $validation->hasError('email') ? 'is-invalid' : ''; ?>" name="email" id="email" placeholder="Email">
                            <div class="invalid-feedback">
                                <?= $validation->getError('email'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="username" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                            <input value="<?= old('username', userdata('username')); ?>" type="text" class="form-control <?= $validation->hasError('username') ? 'is-invalid' : ''; ?>" name="username" id="username" placeholder="Username">
                            <div class="invalid-feedback">
                                <?= $validation->getError('username'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                            <small class="text-muted">Kosongkan jika tidak ingin ubah</small>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= form_close(); ?>
<?= $this->endSection(); ?>