<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="card">
    <div class="card-header">
        <a href="<?= base_url(); ?>/pejabat/add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah</a>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-sm table-striped datatable w-100">
            <thead>
                <th>No. </th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Status</th>
                <th>Aksi</th>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($pejabat as $row) :
                ?>
                <tr>
                    <td width="100"><?= $no++; ?></td>
                    <td><?= $row['kode_pejabat']; ?></td>
                    <td><?= $row['nama_pejabat']; ?></td>
                    <td>
                        <?php if ($row['status']): ?>
                        <span class="badge badge-success">Aktif</span>
                        <?php else: ?>
                        <span class="badge badge-danger">Nonaktif</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="btn-group">
                            <a href="<?= base_url(); ?>/pejabat/edit/<?= $row['pejabat_id']; ?>" class="btn btn-default btn-xs">
                                <i class="fa fa-edit"></i>
                            </a>
                            <form action="/pejabat/delete/<?= $row['pejabat_id']; ?>" method="post">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-default btn-xs" onclick="return confirm('Confirm Delete ?');">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection(); ?>