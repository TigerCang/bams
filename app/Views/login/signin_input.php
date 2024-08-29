<?= $this->extend('layouts/template-login') ?>
<?= $this->section('content') ?>

<!-- Sign In -->
<div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg position-relative py-sm-5 px-4 py-4">
    <div class="w-px-400 mx-auto pt-5 pt-lg-0">
        <h4 class="text-center mb-2"><?= lang('app.login mulai1') ?></h4>
        <p class="mb-4"><?= lang('app.login mulai2') ?></p>

        <form class="mb-3" action="/login/auth" method="POST">
            <?php if (session()->getFlashdata('pesan')) :
                echo json('alert gagal-1') . session()->getFlashdata('pesan') . json('alert sukses-2');
            endif ?>

            <div class="form-floating form-floating-outline mb-4">
                <input type="text" class="form-control" id="usernama" name="usernama" placeholder="<?= lang('app.usernama') ?>" autofocus />
                <label for="usernama"><?= lang('app.usernama') ?></label>
            </div>
            <div class="form-floating form-floating-outline mb-4">
                <input type="password" class="form-control" id="sandi" name="sandi" placeholder="<?= json('sandi') ?>" />
                <label for="sandi"><?= lang('app.sandi') ?></label>
            </div>
            <div class="d-flex justify-content-between mb-4 ">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="ingatkan" />
                    <label class="form-check-label" for="ingatkan"><?= lang('app.ingat saya') ?> </label>
                </div>
                <a href="/lupasandi" class="float-end mb-1"><span><?= lang('app.lupa sandi') ?></span></a>
            </div>

            <button class="<?= json('btn submit') ?> d-flex w-100"><?= lang('app.btn signin') ?></button>
        </form>

        <p class="text-center mt-2">
            <span><?= lang('app.tanya user') ?></span>
            <a href="/signup"><span><?= lang('app.buat user') ?></span></a>
        </p>
        <div class="divider divider-primary my-4">
            <div class="divider-text"><?= json('xversi') ?></div>
        </div>
    </div>
</div>
<!-- End Sign In -->

<?= $this->endSection() ?>