<!DOCTYPE html>
<html lang="en-us" class="no-js">

<head>
    <title><?= lang('app.xprojek') ?> | <?= lang('app.xdesc') ?></title>
    <meta charset="utf-8">
    <meta name="description" content="404 Error Page">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="#s">

    <!-- Favicon -->
    <link rel="icon" href="<?= base_url('assets') ?>/images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="<?= base_url('libraries') ?>/404/css/style.css">
</head>

<!-- <body class="bubble"> -->

<body>
    <canvas id="canvasbg"></canvas>
    <canvas id="canvas"></canvas>
    <a class="logo-link btn btn-outline-light" onclick="goBack()"><i class="fa fa-arrow-circle-left"></i> <?= lang('app.back') ?></a>

    <div class="content">
        <div class="content-box">
            <div class="big-content">
                <div class="list-square">
                    <?php for ($i = 0; $i < 3; $i++) {
                        echo "<span class='square'></span>";
                    } ?>
                </div>
                <div class="list-line">
                    <?php for ($i = 0; $i < 6; $i++) {
                        echo "<span class='line'></span>";
                    } ?>
                </div>
                <i class="fa fa-search" aria-hidden="true"></i>
                <div class="clear"></div>
            </div>
            <!-- Your text -->
            <h1><?= lang('app.err404') ?>.</h1>
            <p><?= lang('app.haltiada') ?>.</p>
        </div>
    </div>

    <script src="<?= base_url('libraries') ?>/404/js/jquery.min.js"></script>
    <script src="<?= base_url('libraries') ?>/404/js/bootstrap.min.js"></script>
    <!-- Particles plugin -->
    <script src="<?= base_url('libraries') ?>/404/js/bubble.js"></script>
</body>

<script>
    function goBack() {
        window.history.back();
    }
</script>

</html>