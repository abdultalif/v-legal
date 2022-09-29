<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="row justify-content-center">
    <div class="col-md-4">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h5 class="card-title">Form <?= $title; ?>
                </h5>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <a href="<?= base_url(); ?>/jenis"
                        class="btn btn-sm btn-default">Kembali</a>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <?= form_open('jenis/update', '', ['jenis_id'=>$jenis['jenis_id']]); ?>
                <?= csrf_field(); ?>
                <div class="form-group">
                    <label for="nama_jenis">Nama Provinsi</label>
                    <input
                        class="form-control <?= $validation->hasError('nama_jenis') ? 'is-invalid' : ''; ?>"
                        value="<?= old('nama_jenis', $jenis['nama_jenis']); ?>"
                        type="text" name="nama_jenis" id="nama_jenis">
                    <div class="invalid-feedback">
                        <?= $validation->getError('nama_jenis'); ?>
                    </div>
                </div>
                <button type="submit" class="btn btn-block btn-primary">Simpan</button>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection();
