<!DOCTYPE html>
<html lang="en-us" class="no-js">

<head>
    <title><?= lang('app.xprojek') ?> | <?= lang('app.xdesc') ?></title>
    <meta charset="utf-8">
    <meta name="description" content="404 Error Page">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="#s">

    <!-- Favicon x-icon-->
    <link rel="icon" href="<?= base_url('assets') ?>/images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="<?= base_url('libraries') ?>/404/css/style.css">
</head>

<body>
    <canvas id="dotty"></canvas>
    <a class="logo-link btn btn-outline-light" onclick="goBack()"><i class="fa fa-arrow-circle-left"></i> <?= lang('app.back') ?></a>

    <div class="content">
        <div class="content-box">
            <h1>Access Denied</h1>
            <!-- Your text -->
            <h1><?= lang('app.err403') ?>.</h1>
            <p><?= lang('app.hallarang') ?>.</p>
        </div>
    </div>

    <script src="<?= base_url('libraries') ?>/404/js/jquery.min.js"></script>
    <script src="<?= base_url('libraries') ?>/404/js/bootstrap.min.js"></script>
    <!-- Mozaic plugin -->
    <script src="<?= base_url('libraries') ?>/404/js/mozaic.js"></script>
</body>

<script>
    function goBack() {
        window.history.back();
    }
</script>

</html>