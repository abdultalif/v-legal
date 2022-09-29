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
                    <a href="<?= base_url(); ?>/negara" class="btn btn-sm btn-default">Kembali</a>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <?= form_open('negara/save'); ?>
                <?= csrf_field(); ?>
                <div class="form-group">
                    <label for="kode_negara">Kode Negara</label>
                    <input class="form-control <?= $validation->hasError('kode_negara') ? 'is-invalid' : ''; ?>" value="<?= old('kode_negara'); ?>" type="text" name="kode_negara" id="kode_negara">
                    <div class="invalid-feedback">
                        <?= $validation->getError('kode_negara'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="nama_negara">Nama Negara</label>
                    <input class="form-control <?= $validation->hasError('nama_negara') ? 'is-invalid' : ''; ?>" value="<?= old('nama_negara'); ?>" type="text" name="nama_negara" id="nama_negara">
                    <div class="invalid-feedback">
                        <?= $validation->getError('nama_negara'); ?>
                    </div>
                </div>
                <button type="submit" class="btn btn-block btn-primary">Simpan</button>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>