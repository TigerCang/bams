<!doctype html>
<html lang="en" class="light-style layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default" data-assets-path="<?= base_url('libraries') ?>/" data-template="horizontal-menu-template">

<head>
    <title><?= json('xCode') ?> | <?= json('xdesk') ?></title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="#" />
    <meta name="keywords" content="BAMS WebApp" />
    <meta name="author" content="#" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= base_url('libraries') ?>/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="<?= base_url('libraries') ?>/vendor/fonts/materialdesignicons.css" />
    <link rel="stylesheet" href="<?= base_url('libraries') ?>/vendor/fonts/flag-icons.css" />

    <!-- Menu waves for no-customizer fix -->
    <link rel="stylesheet" href="<?= base_url('libraries') ?>/vendor/libs/node-waves/node-waves.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?= base_url('libraries') ?>/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="<?= base_url('libraries') ?>/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="<?= base_url('libraries') ?>/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="<?= base_url('libraries') ?>/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="<?= base_url('libraries') ?>/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="<?= base_url('libraries') ?>/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="<?= base_url('libraries') ?>/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="<?= base_url('libraries') ?>/vendor/libs/apex-charts/apex-charts.css" />
    <link rel="stylesheet" href="<?= base_url('libraries') ?>/vendor/libs/swiper/swiper.css" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="<?= base_url('libraries') ?>/vendor/css/pages/cards-statistics.css" />

    <!-- Helpers -->
    <script src="<?= base_url('libraries') ?>/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="<?= base_url('libraries') ?>/vendor/js/template-customizer.js"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="<?= base_url('libraries') ?>/js/config.js"></script>
</head>

<body>
    <!-- <body oncontextmenu="return false" onkeydown="return false;" onmousedown="return false;">  -->
    <div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
        <div class="layout-container">
            <!-- Navbar -->
            <?= $this->include('layouts/navbar-horizontal') ?>

            <div class="layout-page">
                <div class="content-wrapper">
                    <!-- Menu bar -->
                    <?= $this->include('layouts/menubar-horizontal') ?>

                    <div class="container-xxl w-100 container-p-y">
                        <!-- <div class="container-fluid w-100 container-p-y"> -->
                        <?php if (!empty($t_judul)) : ?>
                            <h4 class="mb-1"><?= htmlspecialchars($tjudul, ENT_QUOTES, 'UTF-8') ?></h4>
                        <?php endif; ?>
                        <?php if (!empty($t_span)) : ?>
                            <p class="mb-4"><?= htmlspecialchars($tspan, ENT_QUOTES, 'UTF-8') ?></p>
                        <?php endif; ?>
                        <?php if (!empty($t_prec)) : ?>
                            <?= $this->include('layouts/precontent') ?>
                        <?php endif; ?>

                        <!-- Content -->
                        <?= $this->renderSection('content') ?>
                    </div>

                    <!-- Footer -->
                    <?= $this->include('layouts/footer') ?>

                    <div class="content-backdrop fade"></div>
                </div> <!--/ Content wrapper -->
            </div> <!--/ Layout page -->
        </div> <!--/ Content container -->

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
    </div> <!--/ Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script type="text/javascript" src="<?= base_url('libraries') ?>/bower_components/jquery-ui/js/jquery-ui.min.js"></script>
    <script src="<?= base_url('libraries') ?>/vendor/libs/jquery/jquery.js"></script>
    <script src="<?= base_url('libraries') ?>/vendor/libs/popper/popper.js"></script>
    <script src="<?= base_url('libraries') ?>/vendor/js/bootstrap.js"></script>
    <script src="<?= base_url('libraries') ?>/vendor/libs/node-waves/node-waves.js"></script>
    <script src="<?= base_url('libraries') ?>/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="<?= base_url('libraries') ?>/vendor/libs/hammer/hammer.js"></script>
    <script src="<?= base_url('libraries') ?>/vendor/libs/i18n/i18n.js"></script>
    <script src="<?= base_url('libraries') ?>/vendor/libs/typeahead-js/typeahead.js"></script>
    <script src="<?= base_url('libraries') ?>/vendor/js/menu.js"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="<?= base_url('libraries') ?>/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="<?= base_url('libraries') ?>/vendor/libs/apex-charts/apexcharts.js"></script>
    <script src="<?= base_url('libraries') ?>/vendor/libs/swiper/swiper.js"></script>

    <!-- Main JS -->
    <script src="<?= base_url('libraries') ?>/js/main.js"></script>

    <!-- Page JS -->
    <script src="<?= base_url('libraries') ?>/js/app-ecommerce-dashboard.js"></script>
</body>

</html>