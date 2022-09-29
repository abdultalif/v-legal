<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="row justify-content-center">
    <div class="col-md-4">
        <?= form_open('service/cekStatus'); ?>
        <div class="card card-outline card-lightblue">
            <div class="card-header">
                <h5 class="card-title mt-1">
                    Cek Dokumen
                </h5>
                <div class="card-tools">
                    <button type="submit" class="btn btn-sm btn-primary" onclick="this.disabled=true;this.innerHTML='<span class=\'spinner-border spinner-border-sm\'></span>';this.form.submit();">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <p class="text-muted">Cek nomor dokumen yang sudah terbit.</p>
                <div class="form-group mb-0">
                    <label for="no_dokumen">Nomor Dokumen</label>
                    <input value="<?= $status ? $status['no_dokumen'] : "" ?>" placeholder="00.00000-00000.007-XX-XX" type="text" name="no_dokumen" id="no_dokumen" class="form-control <?= $validation->hasError('no_dokumen') ? 'is-invalid' : ''; ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('no_dokumen'); ?>
                    </div>
                </div>
            </div>
        </div>
        <?= form_close(); ?>
    </div>
</div>

<?php if ($status): ?>
<div class="modal fade" id="modalStatus" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalStatusLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class=" modal-content shadow-none">
            <div class="modal-header bg-lightblue">
                <h5 class="modal-title" id="modalStatusLabel">Status Dokumen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="w-100">
                    <tr>
                        <td>No. Dokumen</td>
                        <td>:</td>
                        <td>
                            <?= $status['no_dokumen']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>No. Barcode</td>
                        <td>:</td>
                        <td>
                            <?= $status['barcode']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>:</td>
                        <td class="font-weight-bold">
                            <?= @$status['status'][0]['keterangan']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <td>:</td>
                        <td>
                            <?php
                            $tanggal = @$status['status'][0]['tanggal_log'];
                            $tgl = substr($tanggal, 0, 4).'-'.substr($tanggal, 4, 2).'-'.substr($tanggal, 6, 2);
                            echo format_tanggal($tgl, 'd/m/Y');
                            ?>
                        </td>
                    </tr>
                    <?php if (is_admin()): ?>
                    <tr>
                        <td colspan="3" class="pt-3">
                            <a target="_blank" href="<?= $status['link_cetak']; ?>" class="btn bg-lightblue btn-block">
                                <i class="fa fa-print"></i> Cetak Dokumen
                            </a>
                        </td>
                    </tr>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?= $this->endSection(); ?>

<?= $this->section('addons'); ?>
<script type="text/javascript">
$(function() {
    <?php if ($status): ?>
    $('#modalStatus').modal('show');
    <?php endif; ?>
});
</script>
<?= $this->endSection();
