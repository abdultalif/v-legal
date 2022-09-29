<!-- Navbar -->

<nav class="main-header navbar navbar-expand navbar-dark bg-<?= env('theme.color') ?> border-bottom-0">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-md-inline-block">
            <span class="navbar-text">
                <i class="fa fa-clock"></i> Senin-Jumat <b>08:00-16:30</b> | Sabtu <b>08:00-13:00</b>
            </span>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <?php if (!is_admin() && !is_superadmin()): ?>
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="true">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge" id="notification-count"></span>
            </a>

            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" id="notification-body">

                <span class="dropdown-item dropdown-header">Notifikasi</span>

                <div class="dropdown-divider"></div>

                <?php if (!clientdata(userdata('user_id'))) : ?>

                <!-- Jika client belum melengkapi data klien -->

                <a href="<?= base_url('client/add'); ?>" class="dropdown-item">

                    <div class="row">

                        <div class="col-2 text-left">

                            <i class="fas fa-fw fa-edit"></i>

                        </div>

                        <div class="col small">

                            <p>

                                Lengkapi data anda agar bisa membuat permohonan!

                            </p>

                        </div>

                    </div>

                </a>

                <?php else: ?>

                <!-- Jika client sudah melengkapi data client lalu ini -->

                <?php if (count(cekLMK()) == 0): ?>

                <a href="<?= base_url('lampiran'); ?>" class="dropdown-item">

                    <div class="row">

                        <div class="col-2 text-left">

                            <i class="fas fa-fw fa-file-pdf"></i>

                        </div>

                        <div class="col small">

                            <p>

                                Anda belum upload LMK Bulan Lalu <br/> <small>(<?=date('M Y', strtotime("last month"))?>) (<?=count(cekLMK())?>)</small>

                            </p>

                        </div>

                    </div>

                </a>

                <?php endif; ?>

                <?php endif; ?>

                <?php if (countDraftClient() > 0) : ?>

                <a href="<?= base_url('pengajuan'); ?>" class="dropdown-item">

                    <div class="row">

                        <div class="col-2 text-left">

                            <i class="fas fa-fw fa-file-alt"></i>

                        </div>

                        <div class="col small">

                            <p>

                                <b><?= countDraftClient(); ?></b> permohonan belum dikirim

                            </p>

                        </div>

                    </div>

                </a>

                <?php endif; ?>

            </div>

        </li>
        <?php endif; ?>

        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                <i class="fab fa-fw fa-whatsapp"></i>
                <span class="badge badge-danger navbar-badge">3</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <?php require_once "contact.php" ?>
            </div>
        </li>

        <li class="nav-item">

            <a class="nav-link" data-widget="fullscreen" href="#" role="button">

                <i class="fas fa-expand-arrows-alt"></i>

            </a>

        </li>

        <li class="nav-item dropdown">

            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">

                <i class="fa fa-power-off fa-fw"></i>

            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown">

                <a href="<?= base_url('/profile'); ?>" class="dropdown-item">

                    <i class="fa fa-user-circle fa-fw mr-2"></i> Edit Akun

                </a>

                <div class="dropdown-divider"></div>

                <a href="#logoutModal" class="dropdown-item" data-toggle="modal">

                    <i class="fa fa-sign-out-alt fa-fw mr-2"></i> Logout

                </a>

            </div>

        </li>

        <li class="nav-item">

            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">

                <i class="fas fa-cog"></i>

            </a>

        </li>

    </ul>

</nav>

<!-- /.navbar -->



<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalTitle" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="logoutModalTitle">Logout</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

            <div class="modal-body">

                Apakah anda yakin ingin logout?

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>

                <a href="<?= base_url(); ?>/auth/logout" class="btn btn-primary">Ya, saya ingin logout</a>

            </div>

        </div>

    </div>

</div>