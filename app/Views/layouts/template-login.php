<!doctype html>
<html lang="en" class="light-style layout-wide customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="<?= base_url('libraries') ?>/" data-template="vertical-menu-template" data-style="light">

<head>
    <title><?= json('xCode') ?> | <?= json('xDescription') ?></title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="#" />
    <meta name="keywords" content="BAMS WebApp" />
    <meta name="author" content="#" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets') ?>/image/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="<?= base_url('libraries') ?>/cang/fonts/fontawesome-6.5.2/css/all.min.css" />

    <!-- Menu waves for no-customizer fix -->
    <link rel="stylesheet" href="<?= base_url('libraries') ?>/vendor/libs/node-waves/node-waves.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?= base_url('libraries') ?>/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="<?= base_url('libraries') ?>/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />

    <!-- Page -->
    <link rel="stylesheet" href="<?= base_url('libraries') ?>/vendor/css/pages/page-auth.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="<?= base_url('libraries') ?>/vendor/libs/sweetalert2/sweetalert2.css" />

    <!-- cang extra css -->
    <link rel="stylesheet" href="<?= base_url('libraries') ?>/cang/css/extra.css">
</head>

<body>
    <!-- <body oncontextmenu="return false" onkeydown="return false;" onmousedown="return false;"> -->
    <div class="authentication-wrapper authentication-cover">
        <div class="authentication-inner row m-0">
            <!-- Picture -->
            <div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center justify-content-center p-5 pb-2">
                <img src="<?= base_url('assets') ?>/image/illustration/login-bg.png" class="auth-cover-illustration w-100" alt="auth-illustration" />
                <img src="<?= base_url('assets') ?>/image/illustration/login-mask-light.png" class="authentication-image" alt="mask" />
            </div>

            <!-- Content -->
            <?= $this->renderSection('content') ?>
        </div>
    </div>

    <!-- Core JS -->
    <script src="<?= base_url('libraries') ?>/vendor/libs/jquery/jquery.js"></script>
    <script src="<?= base_url('libraries') ?>/vendor/libs/popper/popper.js"></script>
    <script src="<?= base_url('libraries') ?>/vendor/js/bootstrap.js"></script>
    <script src="<?= base_url('libraries') ?>/vendor/libs/node-waves/node-waves.js"></script>
    <script src="<?= base_url('libraries') ?>/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="<?= base_url('libraries') ?>/vendor/libs/hammer/hammer.js"></script>
    <script src="<?= base_url('libraries') ?>/vendor/libs/i18n/i18n.js"></script>
    <script src="<?= base_url('libraries') ?>/vendor/libs/typeahead-js/typeahead.js"></script>
    <script src="<?= base_url('libraries') ?>/vendor/js/menu.js"></script>

    <!-- Vendors JS -->
    <script src="<?= base_url('libraries') ?>/vendor/libs/@form-validation/popular.js"></script>
    <script src="<?= base_url('libraries') ?>/vendor/libs/@form-validation/bootstrap5.js"></script>
    <script src="<?= base_url('libraries') ?>/vendor/libs/@form-validation/auto-focus.js"></script>
    <script src="<?= base_url('libraries') ?>/vendor/libs/sweetalert2/sweetalert2.js"></script>

    <!-- cang extra js -->
    <script src="<?= base_url('libraries') ?>/cang/js/extra.js"></script>
</body>

</html>