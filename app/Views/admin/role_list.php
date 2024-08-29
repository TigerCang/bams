<?= $this->extend($tampilan == 'vertical' ? 'layouts/template-vertical' : 'layouts/template-horizontal') ?>
<?= $this->section('content') ?>

<div class="row mb-6 g-2">
    <!-- Create New -->
    <div class="col-12 col-md-6 col-lg-4">
        <div class="card mb-6">
            <div class="row">
                <div class="col-5">
                    <div class="d-flex align-items-end h-100 justify-content-center">
                        <img src="<?= base_url('assets') ?>/image/ilustrasi/add-new-role-illustration.png" class="img-fluid" alt="Image" width="70" />
                    </div>
                </div>
                <div class="col-7">
                    <div class="card-body text-sm-end text-center ps-sm-0">
                        <p class="mb-1">Total 0 <?= lang('app.pemakai') ?></p>
                        <button type="button" class="<?= json('btn create') ?> btninput" <?= ($tuser['act_button'][0] == '0' ? 'disabled' : '') ?>><?= lang('app.btn create') ?></button>
                        <div class="mt-3">
                            <?php if (session()->getFlashdata('pesan')) :
                                echo json('alert sukses-1') . session()->getFlashdata('pesan') . json('alert sukses-2');
                            endif ?>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!--/ Card -->
    </div> <!--/ Col -->

    <!-- Data Role -->
    <?php foreach ($role as $index => $db) :
        $label = labelBadge('main', ($db->kondisi)) ?>
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card mb-6">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <p class="mb-0">Total <?= $db->jluser ?> <?= lang('app.pemakai') ?></p>
                        <div class="list-unstyled d-flex align-items-center avatar-group mb-0">
                            <label class="label <?= $label['class'] ?>"><?= $label['text'] ?></label>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="role-heading">
                            <?= ($db->xlog == '' ? "<h6 class='mb-1'>{$db->nama}</h6>" : "<h7 class='mb-1'>{$db->nama}</h7>") ?>
                            <?php if ($tuser['act_button'][1] == '1') : ?>
                                <a href="javascript:void(0);" class="btninput" data-idunik="<?= $db->idunik ?? '' ?>">
                                    <p class="mb-0"><?= lang('app.detil') ?></p>
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
    $(document).ready(function() {
        $(document).on('click', '.btninput', function(e) {
            e.preventDefault();
            var getIdu = $(this).data('idunik') || '';
            var url = '<?= $link ?>/input?datakey=' + getIdu;
            window.location.href = url;
        })
    });
</script>

<?= $this->endSection() ?>