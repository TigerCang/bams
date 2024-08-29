<?= $this->extend('layouts/template-login') ?>
<?= $this->section('content') ?>

<!-- Recover -->
<div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg position-relative py-sm-5 px-4 py-4">
    <div class="w-px-400 mx-auto pt-5 pt-lg-0">
        <h4 class="text-center mb-2"><?= lang('app.login pulih1') ?></h4>
        <p class="mb-4"><?= lang('app.login pulih2') ?></p>

        <form class="mb-3" action="/login/reset" method="POST">
            <div class="form-floating form-floating-outline mb-4">
                <input type="text" class="form-control" id="usernama" name="usernama" placeholder="<?= lang('app.usernama') ?>" />
                <label for="usernama"><?= lang('app.usernama') ?></label>
            </div>
            <div class="form-floating form-floating-outline mb-4">
                <input type="text" class="form-control" id="kode" name="kode" placeholder="<?= json('xcode') ?>" />
                <label for="kode"><?= lang('app.kode') ?></label>
            </div>

            <button class="<?= json('btn submit') ?> d-flex flex-grow-1"><?= lang('app.btn recover') ?></button>
        </form>

        <div class="text-center">
            <a href="/login" class="d-flex align-items-center justify-content-center"><i class="mdi mdi-chevron-left scaleX-n1-rtl mdi-24px"></i><?= lang('app.masuk kembali') ?></a>
        </div>
        <div class="divider divider-primary my-4">
            <div class="divider-text"><?= json('xversi') ?></div>
        </div>

    </div>
</div>
<!-- End Recover -->

<?= $this->endSection() ?>