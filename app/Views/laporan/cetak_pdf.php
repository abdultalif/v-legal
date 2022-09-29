<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan</title>
</head>

<style type="text/css">
table {
    font-family: Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

table td,
table th {
    border: 1px solid #ddd;
    padding: 6px;
    font-size: 12px;
}

table tr:nth-child(even) {
    background-color: #f2f2f2;
}

table tr:hover {
    background-color: #ddd;
}

table th {
    padding-top: 10px;
    padding-bottom: 10px;
    text-align: left;
    background-color: #4CAF50;
    color: white;
    font-size: 14px;
}

.text-center {
    text-align: center;
}

.text-uppercase {
    text-transform: uppercase;
}

h3{
    margin-bottom: 5px;
}

p{
    margin-top:0;
}
</style>

<body> 
    <h2 class="text-center">WEBSERVICE VLEGAL</h2>
    <h3 class="text-center">Laporan Permohonan Dokumen V-LEGAL</h3>
    <p class="text-center"><?= format_tanggal($input['tgl_awal'], 'd/m/Y')?> - <?= format_tanggal($input['tgl_akhir'], 'd/m/Y'); ?></p>
    <table class="table bg-primary">
        <tr>
            <th class="text-center">No.</th>
            <th>Nama Client</th>
            <th>Invoice</th>
            <th>Status</th>
            <th>Tanggal</th>
            <th>Keterangan</th>
        </tr>
        <?php
            if ($laporan):
                $no = 1;
                foreach ($laporan as $row): ?>
                <tr>
                    <td width="50">
                        <?= $no++; ?>
                    </td>
                    <td class="text-uppercase">
                        <?= $row['nama_client']; ?>
                    </td>
                    <td>
                        <?= $row['no_invoice']; ?>
                    </td>
                    <td>
                        <?php 
                        if($row['status_dokumen']=="diterima") {
                            echo "PENERBITAN";
                        } elseif($row['status_dokumen']=="dibatalkan") {
                            echo "PEMBATALAN";
                        }
                        ?>
                    </td>
                    <td>
                        <?= date('d/m/Y', strtotime($row['updated_at'])); ?>
                    </td>
                    <td width="100">
                        <?= $row['status_dokumen'] =="dibatalkan" ? $row['keterangan'] : "-"; ?>
                    </td>
                </tr>
        <?php endforeach; ?>
        <?php endif; ?>
    </table>
</body>

</html>