<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="card card-primary card-outline">
    <div class="card-header">
        <h5 class="card-title">List Produk</h5>
        <div class="card-tools">
            <a href="<?= base_url(); ?>/pengajuan/detail/<?= $detail['pengajuan_id']; ?>" class="btn btn-sm btn-default">
                <i class="fa fa-arrow-left"></i> Ke Detail
            </a>
            <!-- <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#staticBackdrop">
                <i class="fa fa-plus"></i> Tambah Data
            </button> -->
            <a href="<?= base_url(); ?>/lampiran/upload/<?=$detail['pengajuan_id']?>" class="btn btn-sm btn-dark">
                <i class="fa fa-file"></i> Upload Lampiran
            </a>
            <a href="<?= base_url(); ?>/detailpengajuan/add/<?=$detail['pengajuan_id']?>" class="btn btn-sm btn-primary">
                <i class="fa fa-plus"></i> Tambah Data
            </a>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered text-center table-striped w-100">
            <thead>
                <tr>
                    <th>Nomor HS</th>
                    <th>Nama Produk</th>
                    <th>Volume (m3)</th>
                    <th>Berat Bersih (kg)</th>
                    <th>Unit</th>
                    <th>Nilai</th>
                    <th>Mata Uang</th>
                    <th>Nama Ilmiah</th>
                    <th>Negara Panen</th>
                    <th>Hapus</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!$list_detail) : ?>
                <tr>
                    <td colspan="10">Belum ada data</td>
                </tr>
                <?php else: ?>
                <?php foreach ($list_detail as $row) : ?>
                <tr>
                    <td><?= $row['kode_hs']; ?></td>
                    <td><?= $row['nama_produk']; ?></td>
                    <td><?= round($row['volume'], 4); ?></td>
                    <td><?= round($row['berat'], 4); ?></td>
                    <td><?= $row['jumlah']; ?></td>
                    <td><?= number_format($row['nilai'], 2); ?></td>
                    <td><?= $row['mata_uang']; ?></td>
                    <td class="text-left">
                    <?php
                        $jenis = explode(';', $row['jenis_id']);
                        $nama_ilmiah = '';
                        foreach ($jenis as $jns) {
                            if ($nama_ilmiah!='') {
                                $nama_ilmiah = ';';
                            }
                            $nama_ilmiah .= $jenis_kayu->get($jns)['nama_jenis'];
                            echo $nama_ilmiah;
                        }
                    ?>
                    </td>
                    <td class="text-left">
                    <?php
                        $negaraId = explode(';', $row['negara_id']);
                        $negara_panen = '';
                        foreach ($negaraId as $ngr) {
                            if ($negara_panen!='') {
                                $negara_panen = ';';
                            }
                            $negara_panen .= $negara->get($ngr)['nama_negara'];
                            echo $negara_panen;
                        }
                    ?>
                    </td>
                    <td>
                        <div class="text-center">
                            <div class="btn-group">
                                <a href="<?= base_url(); ?>/detailpengajuan/edit/<?= $row['id']; ?>" class="btn btn-default btn-xs btn-edit">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <form action="<?= base_url(); ?>/detailpengajuan/delete/<?= $row['id']; ?>/<?= $row['pengajuan_id']; ?>" method="post">
                                    <?= csrf_field(); ?>
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-default btn-xs"
                                        onclick="return confirm('Confirm Delete ?');">
                                        <i class="fa fa-trash fa-fw"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2"></th>
                    <th><?= round($total['total_volume'], 4); ?></th>
                    <th><?= round($total['total_berat'], 4); ?></th>
                    <th><?= $total['total_jumlah']; ?></th>
                    <th><?= number_format($total['total_nilai'], 2); ?></th>
                    <th colspan="4"></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('addons'); ?>
<script>
    $(function() {
        $('body').addClass('sidebar-collapse');
    });
</script>
<?= $this->endSection();
