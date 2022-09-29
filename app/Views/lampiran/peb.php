<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="row">
    <div class="col-sm-4">
        <?= form_open_multipart('lampiran/save'); ?>
        <?= csrf_field(); ?>
        <input type="hidden" name="tgl_lampiran"
            value="<?=date('Y-m-d')?>">
        <input type="hidden" name="jenis_file"
            value="peb">
        <input type="hidden" name="pengajuan_id"
            value="<?=$pengajuan['pengajuan_id']?>">
        <div class="card card-outline card-lightblue">
            <div class="card-header">
                <h3 class="card-title">
                    Form Upload PEB
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group mb-0">
                    <label for="file_lampiran">File Lampiran</label>
                    <div class="custom-file">
                        <input type="file"
                            class="custom-file-input <?= $validation->hasError('file_lampiran') ? 'is-invalid' : ''; ?>"
                            name="file_lampiran" id="file_lampiran" accept=".jpeg,.jpg,.png,.pdf,.doc,.docx,.xls,.xlsx">
                        <label class="custom-file-label" for="file_lampiran">Pilih File</label>
                    </div>
                    <small class="form-text text-muted">
                        file size max. 2MB
                    </small>
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
                <h3 class="card-title">Dokumen Terupload</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
                <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-sm w-100 table-hover">
                    <thead>
                        <tr>
                            <th>Dokumen</th>
                            <th>Size</th>
                            <th>Tanggal Upload</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($lampiran as $item): ?>
                        <?php if ($item['jenis_file']=="peb"): ?>
                        <tr>
                            <td>
                                <a
                                    href="<?= base_url(); ?>/lampiran/download/<?= $item['lampiran_id']; ?>">
                                    <i class="fa fa-fw fa-download"></i>
                                    <?= $item['jenis_file']; ?>
                                </a>
                            </td>
                            <td>
                                <?= smarty_filesize($item['size_file']); ?>
                            </td>
                            <td>
                                <?= format_tanggal($item['tgl_lampiran'], 'd F Y'); ?>
                            </td>
                            <td>
                                <form
                                    action="<?= base_url() ?>/lampiran/delete/<?= $item['lampiran_id']; ?>"
                                    post="post">
                                    <button type="submit" class="btn btn-sm btn-link"
                                        onclick="return confirm('Yakin ingin hapus?')">
                                        <i class="fa fa-fw fa-times text-danger"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>

<?= $this->endSection(); ?>