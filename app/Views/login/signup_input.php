<?= $this->extend('layouts/template-login') ?>
<?= $this->section('content') ?>

<!-- Sign UP -->
<div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg position-relative py-sm-5 px-4 py-4">
    <div class="w-px-400 mx-auto pt-5 pt-lg-0">
        <h4 class="text-center mb-2"><?= lang('app.login create1') ?></h4>
        <p class="mb-4"><?= lang('app.login create2') ?></p>

        <form class="mb-3" action="/login/signup" method="POST" id="signupForm">
            <?php if (session()->getFlashdata('message')) :
                echo json('alert failed-1') . session()->getFlashdata('message') . json('alert success-2');
            endif ?>
            <?php if (session()->getFlashdata('success message')) :
                echo json('alert success-1') . session()->getFlashdata('success message') . json('alert success-2');
            endif ?>

            <div class="form-floating form-floating-outline mb-4">
                <input type="text" class="form-control" id="username" name="username" placeholder="<?= json('username') ?>" />
                <label for="username"><?= lang('app.username') ?></label>
            </div>
            <div class="form-floating form-floating-outline mb-4">
                <input type="text" class="form-control text-uppercase" id="token" name="token" placeholder="<?= json('token') ?>" />
                <label for="token"><?= lang('app.token') ?></label>
            </div>
            <div class="mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="policy" name="policy" />
                    <label class="form-check-label" for="policy"><?= lang('app.agree me') ?><a href="javascript:void(0);"><?= lang('app.policy') ?></a></label>
                </div>
            </div>
            <button class="<?= json('btn submit') ?> d-flex w-100"><?= lang('app.btn signup') ?></button>
        </form>

        <p class="text-center mt-2">
            <span><?= lang('app.ask user2') ?></span>
            <a href="/login"><span><?= lang('app.please login') ?></span></a>
        </p>
        <div class="divider divider-primary my-4">
            <div class="divider-text"><?= json('xVersion') ?></div>
        </div>

    </div>
</div>
<!-- End Sign Up -->

<script>
    document.getElementById('signupForm').addEventListener('submit', function(event) {
        var checkbox = document.getElementById('policy');

        if (!checkbox.checked) {
            Swal.fire({
                icon: "warning",
                position: "top-end",
                title: "<?= lang('app.check mark') ?>",
                showConfirmButton: false,
            });
            event.preventDefault(); // Prevent form from submitting
        }
    });
</script>
<?= $this->endSection() ?>