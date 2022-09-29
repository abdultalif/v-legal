<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="row">
    <div
        class="col-sm-4 <?= userdata('role') == 'admin' ? 'd-none' : ''; ?>">
        <?= form_open_multipart('lampiran/upload_lmk'); ?>
        <?= csrf_field(); ?>
        <input type="hidden" name="client_id"
            value="<?= clientdata(userdata('user_id'))['client_id']; ?>">
        <div class="card card-outline card-lightblue">
            <div class="card-header">
                <h3 class="card-title">
                    Form Upload LMK
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Bulan LMK</label>
                    <div class="input-group">
                        <select name="bulan_lmk" class="custom-select <?= $validation->hasError('bulan_lmk') ? 'is-invalid' : ''; ?>" id="bulan_lmk">
                            <option value="">Bulan</option>
                            <?php
                            $bulan = [1 => "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
                            for ($i = 1;$i <= 12;$i++) : ?>
                                <option value="<?= $i; ?>"><?= $bulan[$i]; ?></option>
                            <?php endfor; ?>
                        </select>
                        <select name="tahun_lmk" class="custom-select <?= $validation->hasError('tahun_lmk') ? 'is-invalid' : ''; ?>" id="tahun_lmk">
                            <option value="">Tahun</option>
                            <?php for ($th = 2015;$th <= date('Y');$th++): ?>
                                <option value="<?= $th; ?>"><?= $th; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="invalid-feedback">
                        <?= $validation->getError('bulan_lmk'); ?>
                        <?= $validation->getError('tahun_lmk'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="file_lmk">File LMK</label>
                    <div class="custom-file">
                        <input type="file"
                            class="custom-file-input <?= $validation->hasError('file_lmk') ? 'is-invalid' : ''; ?>"
                            name="file_lmk" id="file_lmk" accept=".jpeg,.jpg,.png,.pdf,.doc,.docx,.xls,.xlsx">
                        <label class="custom-file-label" for="file_lmk">Pilih File</label>
                    </div>
                </div>
                <div class="form-group mb-0">
                    <label for="ket_lmk">Keterangan</label>
                    <textarea
                        class="form-control <?= $validation->hasError('ket_lmk') ? 'is-invalid' : ''; ?>"
                        name="ket_lmk" id="ket_lmk" rows="2"
                        placeholder="Keterangan"><?= set_value('ket_lmk'); ?></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-block btn-primary">
                    <i class="fa fa-upload"></i>
                    Upload
                </button>
            </div>
        </div>
        <?= form_close(); ?>
    </div>
    <div class="col-sm">
        <div class="card card-outline card-lightblue">
            <div class="card-header">
                <h3 class="card-title">Dokumen LMK Terupload</h3>
                <div class="card-tools">
                    <?php if (!is_admin()): ?>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <?php else: ?>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-person-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                                </svg>
                            </span>
                        </div>
                        <select name="client_filter" class="form-control">
                            <option value="" selected>-- Client --</option>
                            <?php foreach ($client as $row) : ?>
                            <option
                                value="<?=$row['client_id']?>">
                                <?= $row['nama_client']; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm table-striped datatable w-100">
                    <thead>
                        <tr>
                            <th>LMK Bulan</th>
                            <th>Tanggal Upload</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($lmk as $row) : ?>
                        <tr>
                            <td>
                                <?= $bulan[$row['bulan_lmk']]; ?> <?= $row['tahun_lmk']; ?>
                            </td>
                            <td>
                                <?= $row['tgl_lmk']; ?>
                            </td>
                            <td>
                                <?= $row['ket_lmk']; ?>
                            </td>
                            <td>
                                <form
                                    action="<?= base_url() ?>/lampiran/delete_lmk/<?= $row['lmk_id']; ?>"
                                    post="post">
                                    <a class="btn btn-xs btn-primary" target="_blank"
                                        href="<?= base_url() ?>/uploads/lmk/<?= $row['file_lmk'] ?>">
                                        <i class="fa fa-download"></i>
                                    </a>
                                    <button type="submit" class="btn btn-xs btn-danger"
                                        onclick="return confirm('Yakin ingin hapus?')">
                                        <i class="fa fa-fw fa-times"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('addons'); ?>
<?= $this->endSection();
