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
                    <a href="<?= base_url(); ?>/supplier" class="btn btn-sm btn-default">Kembali</a>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <?= form_open('supplier/save', '', ['user_id'=>userdata('user_id')]); ?>
                <?= csrf_field(); ?>
                <div class="form-group">
                    <label for="negara_id">Negara</label>
                    <select class="form-control select2 <?= $validation->hasError('negara_id') ? 'is-invalid' : ''; ?>" name="negara_id" id="negara_id">
                        <option value="" selected></option>
                        <?php foreach ($negara as $n) : ?>
                        <option value="<?= $n['negara_id']; ?>" <?= set_select('negara_id', $n['negara_id']); ?>>[<?= $n['kode_negara']; ?>] <?= $n['nama_negara']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">
                        <?= $validation->getError('negara_id'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="nama_supplier">Nama Supplier</label>
                    <input class="form-control <?= $validation->hasError('nama_supplier') ? 'is-invalid' : ''; ?>" value="<?= old('nama_supplier'); ?>" type="text" name="nama_supplier" id="nama_supplier">
                    <div class="invalid-feedback">
                        <?= $validation->getError('nama_supplier'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="alamat_supplier">Alamat Supplier</label>
                    <textarea name="alamat_supplier" id="alamat_supplier" class="form-control <?= $validation->hasError('alamat_supplier') ? 'is-invalid' : ''; ?>"><?= old('alamat_supplier'); ?></textarea>
                    <div class="invalid-feedback">
                        <?= $validation->getError('alamat_supplier'); ?>
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