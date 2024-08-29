<?= $this->extend('layouts/template-login') ?>
<?= $this->section('content') ?>

<!-- Sign UP -->
<div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg position-relative py-sm-5 px-4 py-4">
    <div class="w-px-400 mx-auto pt-5 pt-lg-0">
        <h4 class="text-center mb-2"><?= lang('app.login buat1') ?></h4>
        <p class="mb-4"><?= lang('app.login buat2') ?></p>

        <form class="mb-3" action="/login/signup" method="POST" id="signupForm">
            <?php if (session()->getFlashdata('pesan')) :
                echo json('alert gagal-1') . session()->getFlashdata('pesan') . json('alert sukses-2');
            endif ?>
            <?php if (session()->getFlashdata('pesan sukses')) :
                echo json('alert sukses-1') . session()->getFlashdata('pesan sukses') . json('alert sukses-2');
            endif ?>

            <div class="form-floating form-floating-outline mb-4">
                <input type="text" class="form-control" id="usernama" name="usernama" placeholder="<?= json('usernama') ?>" />
                <label for="usernama"><?= lang('app.usernama') ?></label>
            </div>
            <div class="form-floating form-floating-outline mb-4">
                <input type="text" class="form-control text-uppercase" id="token" name="token" placeholder="<?= json('acak') ?>" />
                <label for="token"><?= lang('app.token') ?></label>
            </div>
            <div class="mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="kebijakan" name="kebijakan" />
                    <label class="form-check-label" for="kebijakan"><?= lang('app.saya setuju') ?><a href="javascript:void(0);"><?= lang('app.kebijakan') ?></a></label>
                </div>
            </div>
            <button class="<?= json('btn submit') ?> d-flex w-100"><?= lang('app.btn signup') ?></button>
        </form>

        <p class="text-center mt-2">
            <span><?= lang('app.tanya user2') ?></span>
            <a href="/login"><span><?= lang('app.buat masuk') ?></span></a>
        </p>
        <div class="divider divider-primary my-4">
            <div class="divider-text"><?= json('xversi') ?></div>
        </div>

    </div>
</div>
<!-- End Sign Up -->

<script>
    document.getElementById('signupForm').addEventListener('submit', function(event) {
        var checkbox = document.getElementById('kebijakan');

        if (!checkbox.checked) {
            alert("<?= lang('app.tanda cek') ?>");
            event.preventDefault(); // Mencegah form dari pengiriman
        }
    });
</script>
<?= $this->endSection() ?>