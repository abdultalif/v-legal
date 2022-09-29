<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<?php if (!is_admin() && !is_superadmin()): ?>
<?php require_once "home-client.php"; ?>
<?php else: ?>
<div class="row">
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-info">
                <i class="fas fa-users"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Active Clients</span>
                <span class="info-box-number">
                    <?= $total['client']; ?>
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-success">
                <i class="fas fa-tree"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Products</span>
                <span class="info-box-number">
                    <?= $total['produk']; ?>
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-warning">
                <i class="far fa-paper-plane"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Submissions</span>
                <span class="info-box-number">
                    <?= $total['pengajuan']; ?>
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-danger">
                <i class="fas fa-ship"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Buyers</span>
                <span class="info-box-number">
                    <?= $total['buyer']; ?>
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
</div>
<div class="card">
    <div class="card-header border-0">
        <h3 class="card-title mt-1">Grafik Penerbitan Dokumen V-Legal</h3>
        <form action="" class="card-tools" method="post">
            <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                    <div class="input-group-text small">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar2-week-fill" viewBox="0 0 16 16">
                            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zM8.5 7a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zM3 10.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1z" />
                        </svg>
                    </div>
                </div>
                <select name="tahun_grafik" class="custom-select custom-select-sm" role="button" tabindex="0" onchange="this.form.submit()">
                    <?php for ($i=2020;$i<=date('Y');$i++) : ?>
                    <option value="<?= $i; ?>" <?= $year==$i?"selected":""; ?>>
                        <?= $i; ?>
                    </option>
                    <?php endfor; ?>
                </select>
            </div>
        </form>
    </div>
    <div class="card-body pt-0">
        <div class="position-relative mb-4">
            <div class="chartjs-size-monitor">
                <div class="chartjs-size-monitor-expand">
                    <div class="">
                    </div>
                </div>
                <div class="chartjs-size-monitor-shrink">
                    <div class="">
                    </div>
                </div>
            </div>
            <canvas id="vlegal-chart" height="200" width="487" class="chartjs-render-monitor" style="display: block; width: 487px; height: 200px;">
            </canvas>
        </div>
        <div class="d-flex flex-row justify-content-end small text-muted">
            <span class="mr-2">
                <i class="fas fa-square text-primary"></i> TERBIT
            </span>
            <span>
                <i class="fas fa-square text-danger"></i> PEMBATALAN
            </span>
        </div>
    </div>
</div>
<?php endif; ?>
<?= $this->endSection(); ?>
<?= $this->section('addons'); ?>
<?php if (is_admin() || is_superadmin()): ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.1.0/dist/chart.min.js"></script>
<script type="text/javascript">
$(function() {
    'use strict'
    var ticksStyle = {
        fontColor: '#495057',
        fontStyle: 'bold'
    }
    var mode = 'index'
    var intersect = true
    var $vlegalChart = $('#vlegal-chart')
    var vlegalChart = new Chart($vlegalChart, {
        data: {
            labels: [
                'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu',
                'Sep', 'Okt', 'Nov', 'Des'
            ],
            datasets: [{
                    label: 'TERBIT',
                    type: 'line',
                    data: JSON.parse(
                        "<?= json_encode($diterima); ?>"
                    ),
                    backgroundColor: 'transparent',
                    borderColor: '#007bff',
                    pointBorderColor: '#007bff',
                    pointBackgroundColor: '#007bff',
                    fill: false,
                },
                {
                    label: 'PEMBATALAN',
                    type: 'line',
                    data: JSON.parse(
                        "<?= json_encode($dibatalkan); ?>"
                    ),
                    backgroundColor: 'transparent',
                    borderColor: '#dc3545',
                    pointBorderColor: '#dc3545',
                    pointBackgroundColor: '#dc3545',
                    fill: false,
                }
            ]
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                mode: mode,
                intersect: intersect
            },
            hover: {
                mode: mode,
                intersect: intersect
            },
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    // display: false,
                    gridLines: {
                        display: true,
                        lineWidth: '4px',
                        color: 'rgba(0, 0, 0, .2)',
                        zeroLineColor: 'transparent'
                    },
                    ticks: $.extend({
                        beginAtZero: true,
                        suggestedMax: 200,
                    }, ticksStyle)
                }],
                xAxes: [{
                    display: true,
                    gridLines: {
                        display: false
                    },
                    ticks: ticksStyle
                }]
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Permohonan Tahun <?=$year?>'
                }
            },
        },
    })
})
</script>
<?php endif; ?>
<?= $this->endSection();
