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

    <!-- Menu waves for no-customizer fix -->
    <link rel="stylesheet" href="<?= base_url('libraries') ?>/vendor/libs/node-waves/node-waves.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?= base_url('libraries') ?>/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="<?= base_url('libraries') ?>/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />

    <!-- Page -->
    <link rel="stylesheet" href="<?= base_url('libraries') ?>/vendor/css/pages/page-auth.css" />
</head>

<body style="margin: 0; overflow: hidden;" oncontextmenu="return false" onkeydown="return false;" onmousedown="return false;">
    <div class="authentication-wrapper authentication-cover">
        <div class="authentication-inner row m-0">
            <div class="d-flex col-12 align-items-center authentication-bg position-relative">
                <div class="w-100 h-100 position-absolute top-0 start-0">
                    <video id="errorVideo" src="<?= base_url('assets') ?>/image/illustration/404 Error.mp4" alt="misc-error" class="w-100 h-100" autoplay muted></video>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
    const video = document.getElementById('errorVideo');
    video.addEventListener('ended', function() {
        setTimeout(function() {
            video.play();
        }, 5000); // 1000 millisecond = 1 second
    });

    function goBack() {
        window.history.back();
    }
</script>

</html>