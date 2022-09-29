<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>DRAFT #<?= $pengajuan['no_invoice']; ?></title>

    <style type="text/css">
        body{
            font-family: 'Arial', sans-serif;
            margin-top: 50px;
        }
        .page-title{
            font-size: 14px;
            font-weight: normal;
            padding: 4px 24px;
            border: 2px solid black;
            display: inline-block;
            margin-left:-1px;
        }
        table.row{
            border-colapse: collapse;
            width: 100%;
        }
        table.row tr td{
            border: 2px solid black;
            padding: 4px;
            vertical-align: top;
            font-size: 10px;
        }
        table.row tr td table tr td{
            border: none;
            padding: 0;
        }
        .cell-heading{
            display: block;
            margin-bottom: 5px;
        }
        .no{
            width: 15px;
            display: inline-block;
            vertical-align: top;
        }
        .cell-body{
            display: block;
            margin-left: 15px;
        }
        .cell-body .label, .cell-body .value{
            display: inline-block;
            vertical-align: top;
        }
        .cell-body .value{
            text-transform: uppercase;
            word-wrap: break-word;
        }
        .cell-body-1 .label{
            width: 20%;
        }
        .cell-body-1 .value{
            width: 80%;
        }
        .cell-body-2 .label{
            width: 40%;
        }
        .cell-body-2 .value{
            width: 60%;
        }
        .cell-body-3 .label{
            width: 30%;
        }
        .cell-body-3 .value{
            width: 70%;
        }

        /*********************************
         * DETAIL PAGE
         *********************************/
        .page_break { page-break-before: always; }

        .detail-wrap{
            border: 2px solid black;
            padding: 5px;
            font-size: 14px;
        }

        .detail-wrap .detail-head{
            padding: 20px 10px;
        }

        .detail-head .detail-title{
            display:block;
            margin-bottom: 40px;
        }

        .detail-head table{
            border: none;
            width: 100%;
        }

        .detail-head table tr td:nth-child(3){
            text-transform: uppercase;
        }

        .detail-body table{
            border-collapse: collapse;
            border: 1px solid black;
        }

        .detail-body table tr th, .detail-body table tr td{
            vertical-align: top;
            text-align: left;
            border: 1px solid black;
        }

        .detail-body table tbody td{
            padding: 5px;
            word-wrap: break-word;
        }

        .detail-body table tfoot th{
            text-align:center;
        }

        .detail-body table tfoot th, .detail-body table tfoot td{
            padding: 10px 5px;
        }

        .detail-footer{
            margin-top: 40px;
            font-size: 12px;
        }

        .detail-footer .footer-title{
            display:block;
            margin-left: 15px;
            margin-bottom: 40px;
        }

    </style>
</head>
<body>
    <h1 class="page-title">DRAFT #<?= $pengajuan['no_invoice']; ?></h1>
    <table class="row" cellspacing="0">
        <tr>
            <td width="50%">
                <div class="cell-heading">
                    <b><span class="no">1</span>Issuing authority</b>
                </div>
                <div class="cell-body cell-body-1" style="margin-bottom: 20px">
                    <span class="label">Name</span>
                    <span class="value"><?= env('ls.name'); ?></span>
                </div>
                <div class="cell-body cell-body-1" style="margin-bottom: 20px">
                    <span class="label">Address</span>
                    <span class="value"><?= env('draft.lsAddress'); ?></span>
                </div>
                <div class="cell-body cell-body-2" style="margin-bottom: 20px">
                    <span class="label">Authority registration number</span>
                    <span class="value"><?= env('draft.lsNumber'); ?></span>
                </div>
            </td>
            <td width="50%">
                <div class="cell-heading">
                    <b><span class="no">2</span>Importer</b>
                </div>
                <div class="cell-body cell-body-1" style="margin-bottom: 5px">
                    <span class="label">Name</span>
                    <span class="value"><?= $pengajuan['nama_buyer']; ?></span>
                </div>
                <div class="cell-body cell-body-1" style="margin-bottom: 10px">
                    <span class="label">Address</span>
                    <span class="value"><?= $pengajuan['alamat_buyer']; ?></span>
                </div>
                <div class="cell-body" style="margin-bottom: 5px">
                    <span class="label">Country of destination and ISO Code</span> <span class="value"><?= $pengajuan['nama_negara']; ?> - <?= $pengajuan['kode_negara']; ?></span>
                </div>
                <div class="cell-body cell-body-3" style="margin-bottom: 5px">
                    <span class="label">Port of loading</span>
                    <span class="value"><?= $pengajuan['nama_loading']; ?></span>
                </div>
                <div class="cell-body cell-body-3" style="margin-bottom: 5px">
                    <span class="label">Port of discharge</span>
                    <span class="value"><?= $pengajuan['nama_discharge']; ?></span>
                </div>
                <div class="cell-body cell-body-3" style="margin-bottom: 5px">
                    <span class="label">Value (USD)</span>
                    <span class="value"><?= $totalNilai; ?></span>
                </div>
            </td>
        </tr>
    </table>
    <table class="row" cellspacing="0">
        <tr>
            <td width="50%">
                <div class="cell-heading">
                    <b><span class="no">3</span>V-Legal/licence number</b>
                </div>
                <div class="cell-body" style="margin-bottom: 10px">
                    <span class="value">-</span>
                </div>
            </td>
            <td width="50%">
                <div class="cell-heading">
                    <b><span class="no">4</span>Date of Expiry</b>
                </div>
                <div class="cell-body" style="margin-bottom: 10px">
                    <span class="value">
                        <table style="border: 2px solid black;">
                            <tr>
                                <td style="padding: 0 4px">--</td>
                                <td style="padding: 0 4px">--</td>
                                <td style="padding: 0 4px">----</td>
                            </tr>
                        </table>
                    </span>
                </div>
            </td>
        </tr>
    </table>
    <table class="row" cellspacing="0">
        <tr>
            <td width="50%">
                <div class="cell-heading">
                    <b><span class="no">5</span>Country of export</b>
                </div>
                <div class="cell-body" style="margin-bottom: 10px">
                    <span class="value"><?= $pengajuan['nama_negara']; ?></span>
                </div>
            </td>
            <td width="50%" rowspan="2">
                <div class="cell-heading">
                    <b><span class="no">7</span>Means of transport</b>
                </div>
                <div class="cell-body" style="margin-bottom: 10px">
                    <?php
                        $alat_angkut = [1 => 'By Sea','By Air','By Land'];
                    ?>
                    <span class="value"><?= $alat_angkut[$pengajuan['alat_angkut']]; ?></span>
                </div>
            </td>
        </tr>
        <tr>
            <td width="50%">
                <div class="cell-heading">
                    <b><span class="no">6</span>ISO Code</b>
                </div>
                <div class="cell-body" style="margin-bottom: 10px">
                    <span class="value"><?= $pengajuan['kode_negara']; ?></span>
                </div>
            </td>
        </tr>
    </table>
    <table class="row" cellspacing="0">
        <tr>
            <td>
                <div class="cell-heading">
                    <b><span class="no">8</span>Licensee</b>
                </div>
                <table width="100%">
                    <tr>
                        <td width="50%">
                            <div class="cell-body cell-body-1" style="margin-bottom: 5px">
                                <span class="label">Name</span>
                                <span class="value"><?= $pengajuan['nama_client']; ?></span>
                            </div>
                            <div class="cell-body cell-body-1" style="margin-bottom: 5px">
                                <span class="label">Address</span>
                                <span class="value"><?= $pengajuan['alamat_client']; ?></span>
                            </div>
                        </td>
                        <td width="50%">
                            <div class="cell-body cell-body-3" style="margin-bottom: 5px">
                                <span class="label">ETPIK Number</span>
                                <span class="value">N/A</span>
                            </div>
                            <div class="cell-body cell-body-3" style="margin-bottom: 5px">
                                <span class="label">Tax Payer Number</span>
                                <span class="value"><?= getFormatedNPWP($pengajuan['npwp']); ?></span>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table class="row" cellspacing="0">
        <tr>
            <td width="70%">
                <div class="cell-heading">
                    <b><span class="no">9</span>Commercial description of the timber products</b>
                </div>
                <div class="cell-body" style="margin-bottom: 10px">
                    <span class="value">
                        <?= count($detail) > 1 ? 'ENCLOSED' : $detail[0]['nama_produk']; ?>
                    </span>
                </div>
            </td>
            <td width="30%">
                <div class="cell-heading">
                    <b><span class="no">10</span>HS-Heading</b>
                </div>
                <div class="cell-body" style="margin-bottom: 10px">
                    <span class="value"><?= count($detail) > 1 ? 'ENCLOSED' : $detail[0]['kode_hs']; ?></span>
                </div>
            </td>
        </tr>
    </table>
    <table class="row" cellspacing="0">
        <tr>
            <td width="55%">
                <div class="cell-heading">
                    <b><span class="no">11</span>Common and Scientific Names</b>
                </div>
                <div class="cell-body" style="margin-bottom: 10px">
                    <span class="value"><?= $nm_jns; ?></span>
                </div>
            </td>
            <td width="25%">
                <div class="cell-heading">
                    <b><span class="no">12</span>Country of harvest</b>
                </div>
                <div class="cell-body" style="margin-bottom: 10px">
                    <span class="value"><?= $nm_ngr; ?></span>
                </div>
            </td>
            <td width="20%">
                <div class="cell-heading">
                    <b><span class="no">13</span>ISO Codes</b>
                </div>
                <div class="cell-body" style="margin-bottom: 10px">
                    <span class="value"><?= $kd_ngr; ?></span>
                </div>
            </td>
        </tr>
    </table>
    <table class="row" cellspacing="0">
        <tr>
            <td width="33.33%">
                <div class="cell-heading">
                    <b><span class="no">14</span>Volume (m3)</b>
                </div>
                <div class="cell-body" style="margin-bottom: 10px">
                    <span class="value"><?= $totalVol; ?></span>
                </div>
            </td>
            <td width="33.33%">
                <div class="cell-heading">
                    <b><span class="no">15</span>Net Weight (kg)</b>
                </div>
                <div class="cell-body" style="margin-bottom: 10px">
                    <span class="value"><?= $totalBerat; ?></span>
                </div>
            </td>
            <td width="33.33%">
                <div class="cell-heading">
                    <b><span class="no">16</span>Number of units</b>
                </div>
                <div class="cell-body" style="margin-bottom: 10px">
                    <span class="value"><?= $totalUnit; ?></span>
                </div>
            </td>
        </tr>
    </table>
    <table class="row" cellspacing="0">
        <tr>
            <td>
                <div class="cell-heading">
                    <b><span class="no">17</span>Distinguishing marks</b>
                </div>
                <div class="cell-body" style="margin-bottom: 10px">
                    <span class="value">INVOICE: <?= $pengajuan['no_invoice']; ?> ISSUED <?= date('d F Y', strtotime($pengajuan['tgl_invoice'])); ?></span>
                </div>
            </td>
        </tr>
    </table>
    <table class="row" cellspacing="0">
        <tr>
            <td>
                <div class="cell-heading" style="margin-bottom: 50px">
                    <b><span class="no">18</span>Signature and stamp of issuing authority</b>
                </div>
                <div class="cell-body cell-body-1" style="margin-bottom: 10px">
                    <span class="label">Name</span>
                    <span class="value"><?= env('draft.signName'); ?></span>
                </div>
                <div class="cell-body cell-body-1" style="margin-bottom: 10px">
                    <span class="label">Place and date</span>
                    <span class="value">-</span>
                </div>
            </td>
        </tr>
    </table>

    <?php if (count($detail) > 1) : ?>
    <div class="page_break"></div>

    <div class="detail-wrap">
        <div class="detail-head">
            <span class="detail-title">ATTACHMENT V-LEGAL DOCUMENT</span>
            <table>
                <tr>
                    <td width="35%">V-Legal/FLEGT license number</td>
                    <td width="2%">:</td>
                    <td width="63%">-</td>
                </tr>
                <tr>
                    <td width="35%">Date of Expiry</td>
                    <td width="2%">:</td>
                    <td width="63%">-</td>
                </tr>
                <tr>
                    <td width="35%">Issuing authority</td>
                    <td width="2%">:</td>
                    <td width="63%"><?= env('ls.name'); ?> / <?= env('draft.lsNumber'); ?></td>
                </tr>
                <tr>
                    <td width="35%">Licensee</td>
                    <td width="2%">:</td>
                    <td width="63%"><?= $pengajuan['nama_client']; ?></td>
                </tr>
                <tr>
                    <td width="35%">Importer</td>
                    <td width="2%">:</td>
                    <td width="63%"><?= $pengajuan['nama_buyer']; ?></td>
                </tr>
            </table>
        </div>
        <div class="detail-body">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Commercial Description of The Timber Products</th>
                        <th>HS-Heading</th>
                        <th>Common and Scientific Names</th>
                        <th>Countries of Harvest</th>
                        <th>ISO Codes</th>
                        <th>Volume (m3)</th>
                        <th>Net Weight (Kg)</th>
                        <th>Number of Units</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($detail as $row) :
                        $negaraId = explode(';', $row['negara_id']);
                        $nm_ngr = '';
                        $kd_ngr = '';
                        foreach ($negaraId as $n) {
                            $nm_ngr .= $negara->get($n)['nama_negara'] . ";";
                            $kd_ngr .= $negara->get($n)['kode_negara'] . ";";
                        }

                        $jenisId = explode(';', $row['jenis_id']);
                        $nm_jns = '';
                        foreach ($jenisId as $j) {
                            $nm_jns .= $kayu->get($j)['nama_jenis'] . ";";
                        }
                    ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $row['nama_produk'] ?></td>
                            <td><?= $row['kode_hs'] ?></td>
                            <td><?= $nm_jns ?></td>
                            <td><?= $nm_ngr ?></td>
                            <td><?= $kd_ngr ?></td>
                            <td><?= $row['volume'] ?></td>
                            <td><?= $row['berat'] ?></td>
                            <td><?= $row['jumlah'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="6">TOTAL</th>
                        <td><?= $totalVol; ?></td>
                        <td><?= $totalBerat; ?></td>
                        <td><?= $totalUnit; ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="detail-footer">
            <span class="footer-title">
                Signature and stamp of issuing authority
            </span>
            <div class="cell-body cell-body-1" style="margin-bottom: 10px">
                <span class="label">Name</span>
                <span class="value"><?= env('draft.signName'); ?></span>
            </div>
            <div class="cell-body cell-body-1" style="margin-bottom: 10px">
                <span class="label">Place and date</span>
                <span class="value">-</span>
            </div>
        </div>
    </div>
    <?php endif; ?>
</body>
</html>