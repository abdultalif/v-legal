<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="row justify-content-center">
    <div class="col-md-4">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h5 class="card-title">Form <?= $title; ?></h5>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <a href="<?= base_url(); ?>/provinsi" class="btn btn-sm btn-default">Kembali</a>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <?= form_open('provinsi/save'); ?>
                <?= csrf_field(); ?>
                <div class="form-group">
                    <label for="kode_provinsi">Kode Provinsi</label>
                    <input class="form-control <?= $validation->hasError('kode_provinsi') ? 'is-invalid' : ''; ?>" value="<?= old('kode_provinsi'); ?>" type="text" name="kode_provinsi" id="kode_provinsi">
                    <div class="invalid-feedback">
                        <?= $validation->getError('kode_provinsi'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="nama_provinsi">Nama Provinsi</label>
                    <input class="form-control <?= $validation->hasError('nama_provinsi') ? 'is-invalid' : ''; ?>" value="<?= old('nama_provinsi'); ?>" type="text" name="nama_provinsi" id="nama_provinsi">
                    <div class="invalid-feedback">
                        <?= $validation->getError('nama_provinsi'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control <?= $validation->hasError('status') ? 'is-invalid' : ''; ?>" name="status" id="status">
                        <option value="" selected></option>
                        <option value="1" <?= set_select('status', '1'); ?>>Aktif</option>
                        <option value="0" <?= set_select('status', '0'); ?>>Nonaktif</option>
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