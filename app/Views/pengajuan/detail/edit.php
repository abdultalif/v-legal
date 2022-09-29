<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<?= form_open('detailpengajuan/save', ['id'=>'form-detail','autocomplete'=>'off']); ?>
<?= csrf_field(); ?>
<div class="card">
    <div class="card-header">
        <div class="card-title">Form Edit Detail</div>
        <div class="card-tools">
            <a href="<?= base_url(); ?>/detailpengajuan/detail/<?=$pengajuan['pengajuan_id']?>" class="btn btn-sm btn-default"><i class="fa fa-chevron-left"></i> Batal</a>
            <button type="button" onclick="simpanDetail()" class="btn btn-primary btn-sm">
                <i class="fa fa-save"></i> Update
            </button>
        </div>
    </div>
    <div class="card-body">
        <input type="hidden" name="pengajuan_id" value="<?= set_value('pengajuan_id', $pengajuan['pengajuan_id']); ?>">
        <input type="hidden" name="id" id="id" value="<?= set_value('id', $detail['id']); ?>">
        <div class="form-group">
            <label for="produk_id">
                Produk
                <a href="<?=base_url()?>/produk" class="badge badge-primary text-white" target="_blank">+ Tambah Produk</a>
            </label>
            <select class="form-control select2 <?= $validation->hasError('produk_id') ? 'is-invalid' : ''; ?>" name="produk_id" id="produk_id">
                <option value="" selected>- Pilih Produk -</option>
                <?php foreach ($produk as $p) : ?>
                <option <?= selected($p['produk_id'], $detail['produk_id']); ?> value="<?= $p['produk_id']; ?>" <?= set_select('produk_id', $p['produk_id']); ?>>
                    <?= $p['kode_hs']; ?> | <?= $p['nama_produk']; ?>
                </option>
                <?php endforeach; ?>
            </select>
            <div class="invalid-feedback">
                <?= $validation->getError('produk_id'); ?>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-sm-2">
            <div class="col">
                <div class="form-group">
                    <div class="d-flex justify-content-between">
                        <div>
                            <label for="jenis_id">
                                Jenis Kayu
                            </label>
                        </div>
                        <div>
                            <button type="button" onclick="pilihJenis()" class="btn btn-sm btn-secondary">Pilih Jenis <i class="fa fa-search"></i></button>
                        </div>
                    </div>
                    <ul id="jenis-wrapper" class="list-group list-group-flush">
                        <?php
                            $jenis = explode(';', $detail['jenis_id']);
                            foreach ($jenis as $jns) :
                                $nama_ilmiah = '';
                                $id_jns = $jenis_kayu->get($jns)['jenis_id'];
                                $nm_jns = $jenis_kayu->get($jns)['nama_jenis'];
                        ?>
                        <li id="jenis-{$id_jns}" class="list-group-item pl-0 selected-jenis">
                            <?= $nm_jns; ?>
                            <button onclick="$(this).parent().remove();" type="button" class="close" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <input type="hidden" class="input-jenis" value="<?= $id_jns; ?>" name="jenis_id[]"/>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="small text-danger">
                        <?= $validation->getError('jenis_id'); ?>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <div class="d-flex justify-content-between">
                        <div>
                            <label for="negara_id">
                                Negara Panen
                            </label>
                        </div>
                        <div>
                            <button type="button" onclick="pilihNegara()" class="btn btn-sm btn-secondary">Pilih Negara <i class="fa fa-search"></i></button>
                        </div>
                    </div>
                    <ul id="negara-wrapper" class="list-group list-group-flush">
                        <?php
                            $Negara = explode(';', $detail['negara_id']);
                            foreach ($Negara as $ngr) :
                                $nama_ilmiah = '';
                                $id_ngr = $negara->get($ngr)['negara_id'];
                                $nm_ngr = $negara->get($ngr)['nama_negara'];
                        ?>
                        <li id="negara-{$id_ngr}" class="list-group-item pl-0 selected-negara">
                            <?= $nm_ngr; ?>
                            <button onclick="$(this).parent().remove();" type="button" class="close" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <input type="hidden" class="input-negara" value="<?= $id_ngr; ?>" name="negara_id[]"/>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="small text-danger">
                        <?= $validation->getError('negara_id'); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="jumlah">Jumlah Unit</label>
                    <input placeholder="Unit" class="form-control <?= $validation->hasError('jumlah') ? 'is-invalid' : ''; ?>" value="<?= old('jumlah', $detail['jumlah']); ?>" type="text" name="jumlah" id="jumlah">
                    <div class="invalid-feedback">
                        <?= $validation->getError('jumlah'); ?>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="volume">Volume (m3)</label>
                    <input placeholder="Volume (m3)" class="form-control <?= $validation->hasError('volume') ? 'is-invalid' : ''; ?>" value="<?= old('volume', $detail['volume']); ?>" type="text" name="volume" id="volume">
                    <div class="invalid-feedback">
                        <?= $validation->getError('volume'); ?>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="berat">Berat Bersih (kg)</label>
                    <input placeholder="Berat (kg)" class="form-control <?= $validation->hasError('berat') ? 'is-invalid' : ''; ?>" value="<?= old('berat', $detail['berat']); ?>" type="text" name="berat" id="berat">
                    <div class="invalid-feedback">
                        <?= $validation->getError('berat'); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="nilai">Nilai</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"> <?= $pengajuan['mata_uang']; ?></span>
                </div>
                <input placeholder="Nilai" class="form-control <?= $validation->hasError('nilai') ? 'is-invalid' : ''; ?>" value="<?= old('nilai', $detail['nilai']); ?>" type="text" name="nilai" id="nilai">
                <div class="invalid-feedback">
                    <?= $validation->getError('nilai'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= form_close(); ?>

<div class="modal fade" id="modalJenis" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content shadow-none">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Jenis Kayu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input placeholder="Cari Jenis Kayu..." id="search-jenis" type="text" class="form-control mb-3">
                <div id="list-jenis" class="list-group" style="max-height: 200px;overflow-y:auto;">
                    <?php foreach ($kayu as $k) : ?>
                    <button data-id="<?= $k['jenis_id']; ?>" data-name="<?= $k['nama_jenis']; ?>" type="button" class="list-group-item list-group-item-action item-jenis">
                        <?= $k['nama_jenis']; ?>
                    </button>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalNegara" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content shadow-none">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Negara Panen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input placeholder="Cari Negara..." id="search-negara" type="text" class="form-control mb-3">
                <div id="list-negara" class="list-group" style="max-height: 200px;overflow-y:auto;">
                    <?php foreach ($getNegara as $n) : ?>
                    <button data-id="<?= $n['negara_id']; ?>" data-name="<?= $n['nama_negara']; ?>" type="button" class="list-group-item list-group-item-action item-negara">
                        <?= $n['nama_negara']; ?>
                    </button>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('addons'); ?>
<script>
    function pilihJenis(){
        if($('.selected-jenis').length >= 3){
            alert('Maksimal 3 :)');
        } else {
            $('#modalJenis').modal('show');
        }
    }

    function pilihNegara(){
        if($('.selected-negara').length >= 3){
            alert('Maksimal 3 :)');
        } else {
            $('#modalNegara').modal('show');
        }
    }

    function simpanDetail(){
        let jenis = $('.input-jenis').length;
        let negara = $('.input-negara').length;
        console.log(jenis + ' + ' + negara);

        if(jenis == negara){
            $('#form-detail').submit();
        } else {
            alert('Jumlah jenis kayu dan negara panen tidak sama.');
        }
    }

    $('#modalJenis .item-jenis').on('click', function() {
        $('#modalJenis .item-jenis').attr("disabled", "true");
        let id = $(this).data('id');
        let name = $(this).data('name');
        let option = `<li id="jenis-${id}" class="list-group-item pl-0 selected-jenis">
            ${name}
            <button onclick="$(this).parent().remove();" type="button" class="close" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <input type="hidden" class="input-jenis" value="${id}" name="jenis_id[]"/>
        </li>`;
        $('#jenis-wrapper').append(option);
        $('#modalJenis').modal('hide');
    });

    $('#modalNegara .item-negara').on('click', function() {
        $('#modalNegara .item-negara').attr("disabled", "true");
        let id = $(this).data('id');
        let name = $(this).data('name');
        let option = `<li id="negara-${id}" class="list-group-item pl-0 selected-negara">
            ${name}
            <button onclick="$(this).parent().remove();" type="button" class="close" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <input type="hidden" class="input-negara" value="${id}" name="negara_id[]"/>
        </li>`;
        $('#negara-wrapper').append(option);
        $('#modalNegara').modal('hide');
    });

    $('#modalJenis').on('shown.bs.modal', function () {
        $('#search-jenis').focus();
    });

    $('#modalNegara').on('shown.bs.modal', function () {
        $('#search-negara').focus();
    });

    $('#modalJenis').on('hidden.bs.modal', function () {
        $('#search-jenis').val('');
        $('#search-jenis').trigger("keyup");
        if($('.selected-jenis').length <= 3){
            $('#modalJenis .item-jenis').removeAttr('disabled');
        }
    });

    $('#modalNegara').on('hidden.bs.modal', function () {
        $('#search-negara').val('');
        $('#search-negara').trigger("keyup");
        if($('.selected-negara').length <= 3){
            $('#modalNegara .item-negara').removeAttr('disabled');
        }
    });

    $(document).ready(function(){
        $("#search-jenis").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#list-jenis .list-group-item").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        $("#search-negara").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#list-negara .list-group-item").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
<?= $this->endSection(); ?>