<!doctype html>
<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default" data-assets-path="<?= base_url('libraries') ?>/" data-template="vertical-menu-template" data-style="light">

<head>
    <title><?= json('xcode') ?> | <?= json('xdesk') ?></title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="#" />
    <meta name="keywords" content="BAMS WebApp" />
    <meta name="author" content="#" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" sizes="32x32" href="<?= base_url('assets') ?>/image/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="<?= base_url('libraries') ?>/cang/fonts/remixicon-4.3/remixicon.css" />
    <link rel="stylesheet" href="<?= base_url('libraries') ?>/cang/fonts/fontawesome-6.5.2/css/all.min.css" />
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
    <link rel="stylesheet" href="<?= base_url('libraries') ?>/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="<?= base_url('libraries') ?>/vendor/libs/tagify/tagify.css" />
    <link rel="stylesheet" href="<?= base_url('libraries') ?>/vendor/libs/bootstrap-select/bootstrap-select.css" />
    <link rel="stylesheet" href="<?= base_url('libraries') ?>/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="<?= base_url('libraries') ?>/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="<?= base_url('libraries') ?>/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
    <link rel="stylesheet" href="<?= base_url('libraries') ?>/vendor/libs/apex-charts/apex-charts.css" />
    <link rel="stylesheet" href="<?= base_url('libraries') ?>/vendor/libs/swiper/swiper.css" />
    <link rel="stylesheet" href="<?= base_url('libraries') ?>/vendor/libs/sweetalert2/sweetalert2.css" />
    <link rel="stylesheet" href="<?= base_url('libraries') ?>/vendor/libs/jstree/jstree.css" />

    <!-- Multi Select css -->
    <link rel="stylesheet" href="<?= base_url('libraries') ?>/cang/multiselect/css/multi-select.css">

    <!-- Row Group CSS -->
    <link rel="stylesheet" href="<?= base_url('libraries') ?>/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css" />

    <!-- Page CSS mau dibuang-->
    <link rel="stylesheet" href="<?= base_url('libraries') ?>/vendor/css/pages/cards-statistics.css" />

    <!-- jQuery -->
    <script src="<?= base_url('libraries') ?>/vendor/libs/jquery/jquery.js"></script>
    <script src="<?= base_url('libraries') ?>/vendor/libs/select2/select2.min.js"></script>

    <!-- Helpers -->
    <script src="<?= base_url('libraries') ?>/vendor/js/helpers.js"></script>
    <script src="<?= base_url('libraries') ?>/vendor/js/template-customizer.js"></script>
    <script src="<?= base_url('libraries') ?>/js/config.js"></script>

    <!-- cang extra css -->
    <link rel="stylesheet" href="<?= base_url('libraries') ?>/cang/css/extra.css">
    <link rel="stylesheet" href="<?= base_url('libraries') ?>/cang/css/select2.css">
    <link rel="stylesheet" href="<?= base_url('libraries') ?>/cang/css/datatable.css">
    <link rel="stylesheet" href="<?= base_url('libraries') ?>/cang/bootstrap5-toggle/css/bootstrap5-toggle.min.css">
    <!-- <link href="<?= base_url('libraries') ?>/cang/css/paper.css"> -->
    <script src="<?= base_url('libraries') ?>/cang/js/select2.js"></script>
</head>

<body>
    <!-- <body oncontextmenu="return false" onkeydown="return false;" onmousedown="return false;">  -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu bar -->
            <?= $this->include('layouts/menubar-vertical') ?>

            <div class="layout-page">
                <!-- Navbar -->
                <?= $this->include('layouts/navbar-vertical') ?>

                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <?php if (!empty($t_judul)) : ?>
                            <h4 class="mb-1"><?= htmlspecialchars($t_judul, ENT_QUOTES, 'UTF-8') ?></h4>
                        <?php endif ?>
                        <?php if (!empty($t_span)) : ?>
                            <p class="mb-4"><?= htmlspecialchars($t_span, ENT_QUOTES, 'UTF-8') ?></p>
                        <?php endif ?>
                        <?php if (!empty($t_prec)) : ?>
                            <?= $this->include('layouts/precontent') ?>
                        <?php endif ?>

                        <!-- Content -->
                        <?= $this->renderSection('content') ?>
                    </div>

                    <!-- Footer -->
                    <?= $this->include('layouts/footer') ?>

                    <div class="content-backdrop fade"></div>
                </div> <!--/ Content wrapper -->
            </div> <!--/ Layout page -->
        </div> <!--/ Content container -->

        <div class="layout-overlay layout-menu-toggle"></div>
        <div class="drag-target"></div>
    </div> <!--/ Layout wrapper -->

    <!-- Core JS -->
    <script src="<?= base_url('libraries') ?>/vendor/libs/popper/popper.js"></script>
    <script src="<?= base_url('libraries') ?>/vendor/js/bootstrap.js"></script>
    <script src="<?= base_url('libraries') ?>/vendor/libs/node-waves/node-waves.js"></script>
    <script src="<?= base_url('libraries') ?>/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="<?= base_url('libraries') ?>/vendor/libs/hammer/hammer.js"></script>
    <script src="<?= base_url('libraries') ?>/vendor/libs/i18n/i18n.js"></script>
    <script src="<?= base_url('libraries') ?>/vendor/libs/typeahead-js/typeahead.js"></script>
    <script src="<?= base_url('libraries') ?>/vendor/js/menu.js"></script>

    <!-- Vendors JS -->
    <script src="<?= base_url('libraries') ?>/vendor/libs/tagify/tagify.js"></script>
    <script src="<?= base_url('libraries') ?>/vendor/libs/bootstrap-select/bootstrap-select.js"></script>
    <script src="<?= base_url('libraries') ?>/vendor/libs/bloodhound/bloodhound.js"></script>
    <script src="<?= base_url('libraries') ?>/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="<?= base_url('libraries') ?>/vendor/libs/apex-charts/apexcharts.js"></script>
    <script src="<?= base_url('libraries') ?>/vendor/libs/swiper/swiper.js"></script>
    <script src="<?= base_url('libraries') ?>/vendor/libs/sweetalert2/sweetalert2.js"></script>
    <script src="<?= base_url('libraries') ?>/vendor/libs/jstree/jstree.js"></script>

    <!-- Main JS -->
    <script src="<?= base_url('libraries') ?>/js/main.js"></script>

    <!-- Page JS -->
    <script src="<?= base_url('libraries') ?>/js/app-ecommerce-dashboard.js"></script>

    <!-- Masking js -->
    <script src="<?= base_url('libraries') ?>/cang/form-masking/inputmask.js"></script>
    <script src="<?= base_url('libraries') ?>/cang/form-masking/jquery.inputmask.js"></script>
    <script src="<?= base_url('libraries') ?>/cang/form-masking/autoNumeric.js"></script>
    <script src="<?= base_url('libraries') ?>/cang/form-masking/form-mask.js"></script>

    <!-- Multi Select css -->
    <script src="<?= base_url('libraries') ?>/cang/multiselect/js/jquery.multi-select.js"></script>
    <script src="<?= base_url('libraries') ?>/cang/multiselect/js/jquery.quicksearch.js"></script>
    <script src="<?= base_url('libraries') ?>/cang/multiselect/js/select2-custom.js"></script>

    <!-- cang extra js -->
    <script src="<?= base_url('libraries') ?>/cang/js/extra.js"></script>
    <script src="<?= base_url('libraries') ?>/cang/js/datatable.js"></script>
    <script src="<?= base_url('libraries') ?>/cang/bootstrap5-toggle/js/bootstrap5-toggle.jquery.min.js"></script>
    <script src="<?= base_url('libraries') ?>/cang/js/treeview.js"></script>
    <!-- <script src="<?= base_url('libraries') ?>/cang/js/kursor.js"></script> -->
</body>

</html>