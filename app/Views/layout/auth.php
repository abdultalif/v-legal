<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VLEGAL SIC - <?= $title; ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url(); ?>/plugins/fontawesome-free/css/all.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?= base_url(); ?>/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url(); ?>/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>/dist/css/custom.css">
    <link rel="stylesheet" href="<?= base_url(); ?>/dist/css/particle.css">
    
    <link rel="icon" href="https://sarbisertifikasi.com/wp-content/uploads/2021/06/cropped-circle-cropped-32x32.png" sizes="32x32" />
    <link rel="icon" href="https://sarbisertifikasi.com/wp-content/uploads/2021/06/cropped-circle-cropped-192x192.png" sizes="192x192" />
    <link rel="apple-touch-icon" href="https://sarbisertifikasi.com/wp-content/uploads/2021/06/cropped-circle-cropped-180x180.png" />
    <meta name="msapplication-TileImage" content="https://sarbisertifikasi.com/wp-content/uploads/2021/06/cropped-circle-cropped-270x270.png" />
</head>

<body class="hold-transition login-page accent-<?= env('theme.color') ?>">
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__wobble" src="<?= base_url(); ?>/img/<?= env('theme.preloadLogo') ?>" alt="Logo <?= env('ls.alias'); ?>" height="60" width="auto">
    </div>

    <?php if (env('theme.particle')) : ?>
    <div class="particle purple"></div>
    <div class="particle medium-blue"></div>
    <div class="particle light-blue"></div>
    <div class="particle red"></div>
    <div class="particle orange"></div>
    <div class="particle yellow"></div>
    <div class="particle cyan"></div>
    <div class="particle light-green"></div>
    <div class="particle lime"></div>
    <div class="particle magenta"></div>
    <div class="particle lightish-red"></div>
    <div class="particle pink"></div>
    <?php endif; ?>
    
    <div class="login-box">
        <div class="card card-outline card-<?= env('theme.color') ?>">
            <div class="card-header text-center">
                <img src="<?= base_url(); ?>/img/<?=env('theme.loginLogo')?>" alt="Logo SIC" class="mw-100" style="height:50px">
                <div class="small text-center mt-2">
                    <?= env('ls.alamat'); ?>
                </div>
            </div>
            <div class="card-body pb-2">
                <p class="text-center font-weight-bold mb-0">APLIKASI PENERBITAN V-LEGAL</p>
                <?php $this->renderSection('content'); ?>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        <div class="small text-center mt-2">
            &copy; <?= date('Y'); ?> &bull; 
            <a href="<?= env('ls.website'); ?>" rel="dofollow"><?= env('ls.name'); ?></a>
        </div>
    </div>

    <!-- jQuery -->
    <script src="<?= base_url(); ?>/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url(); ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="<?= base_url(); ?>/plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url(); ?>/dist/js/adminlte.min.js"></script>

    <script type="text/javascript">
    function darkmode() {
        $("#switch-dark").attr("checked", "checked");
        $('body').addClass('dark-mode');
        $('nav.main-header').removeClass('bg-lightblue');
        // Brand Logo
        $('a.brand-link').removeClass('navbar-light');
        $('a.brand-link').removeClass('bg-lightblue');
        $('a.brand-link').addClass('navbar-dark');
        // Sidebar
        $('aside.main-sidebar').removeClass('sidebar-light-lightblue');
        $('aside.main-sidebar').addClass('sidebar-dark-lightblue');
        localStorage.setItem("mode", "dark");
    }

    function lightmode() {
        $("#switch-dark").removeAttr("checked");
        $('body').removeClass('dark-mode');
        $('nav.main-header').addClass('bg-lightblue');
        // Brand Logo
        $('a.brand-link').addClass('navbar-light');
        $('a.brand-link').addClass('bg-lightblue');
        $('a.brand-link').removeClass('navbar-dark');
        // Sidebar
        $('aside.main-sidebar').removeClass('sidebar-dark-lightblue');
        $('aside.main-sidebar').addClass('sidebar-light-lightblue');
        localStorage.setItem("mode", "light");
    }

    $(function() {
        if (localStorage.getItem("mode") == "dark") {
            darkmode();
        } else {
            lightmode();
        }

        // SwalToast
        var Toast = Swal.mixin({
            toast: true,
            position: 'top',
            showConfirmButton: false,
            timer: 3000
        });

        // Memanggil fungsi toast pada helper 
        <?= session()->getFlashdata('toast'); ?>
    });
    </script>
</body>

</html>