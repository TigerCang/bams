<?= $this->extend($template == 'vertical' ? 'layouts/template-vertical' : 'layouts/template-horizontal') ?>
<?= $this->section('content') ?>

<div class="row mb-6 g-2">
    <div class="col-12 col-md-6 col-lg-4">
        <div class="card mb-6">
            <div class="row">
                <div class="col-5">
                    <div class="d-flex align-items-end h-100 justify-content-center">
                        <img src="<?= base_url('assets') ?>/image/illustration/add-new-role-illustration.png" class="img-fluid" alt="Image" width="70" />
                    </div>
                </div>
                <div class="col-7">
                    <div class="card-body text-sm-end text-center ps-sm-0">
                        <p class="mb-1">Total <?= $totUser ?> <?= lang('app.users') ?></p>
                        <button type="button" class="<?= json('btn create') ?> btn-input" <?= (thisUser()['act_button'][0] == '0' ? 'disabled' : '') ?>><?= lang('app.btn create') ?></button>
                        <div class="mt-3">
                            <?php if (session()->getFlashdata('message')) :
                                echo json('alert success-1') . session()->getFlashdata('message') . json('alert success-2');
                            endif ?>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!--/ Card -->
    </div> <!--/ Col -->

    <!-- Data Role -->
    <?php foreach ($role as $index => $db) :
        $label = labelBadge('main', ($db->adaptation)) ?>
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card mb-6">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <p class="mb-0">Total <?= $db->sumUser ?> <?= lang('app.users') ?></p>
                        <div class="list-unstyled d-flex align-items-center avatar-group mb-0">
                            <label class="label <?= $label['class'] ?>"><?= $label['text'] ?></label>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="role-heading">
                            <?= ($db->xLog == '' ? "<h6 class='mb-1'>" . $db->name . "</h6>" : "<h7 class='mb-1'>" . $db->name . "</h7>") ?>
                            <?php if (thisUser()['act_button'][1] == '1') : ?>
                                <a href="javascript:void(0);" class="btn-input" data-unique="<?= $db->unique ?? '' ?>">
                                    <p class="mb-0"><?= lang('app.detail') ?></p>
                                </a>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            </div> <!-- Card role -->
        </div> <!--/ Col -->
    <?php endforeach ?>
</div> <!--/ Row -->

<script>
    $(document).on('click', '.btn-input', function(e) {
        e.preventDefault();
        var getUnique = $(this).data('unique') || '';
        var url = '<?= $link ?>/input?search=' + getUnique;
        window.location.href = url;
    })
</script>

<?= $this->endSection() ?>