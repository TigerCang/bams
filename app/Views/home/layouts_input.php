<?= $this->extend($template == 'vertical' ? 'layouts/template-vertical' : 'layouts/template-horizontal') ?>
<?= $this->section('content') ?>

<?= form_open('', ['class' => 'form-main']) ?>
<?= csrf_field() ?>

<div id="alertContainer4" class="mt-2"></div>
<div class="row g-2">
    <div class="col-12 col-md-6 col-lg-6">
        <div class="card mb-6">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0 me-2"><?= lang('app.dashboard') ?></h5>
            </div>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="board1" name="board1">
                            </select>
                            <label for="board1"><?= lang('app.card 1') ?></label>
                        </div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="board2" name="board2">
                            </select>
                            <label for="board2"><?= lang('app.card 2') ?></label>
                        </div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="board3" name="board3">
                            </select>
                            <label for="board3"><?= lang('app.card 3') ?></label>
                        </div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="board4" name="board4">
                            </select>
                            <label for="board4"><?= lang('app.card 4') ?></label>
                        </div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="board5" name="board5">
                            </select>
                            <label for="board5"><?= lang('app.card 5') ?></label>
                        </div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="board6" name="board6">
                            </select>
                            <label for="board6"><?= lang('app.card 6') ?></label>
                        </div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="board7" name="board7">
                            </select>
                            <label for="board7"><?= lang('app.card 7') ?></label>
                        </div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="board8" name="board8">
                            </select>
                            <label for="board8"><?= lang('app.card 8') ?></label>
                        </div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="board9" name="board9">
                            </select>
                            <label for="board9"><?= lang('app.card 9') ?></label>
                        </div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="board10" name="board10">
                            </select>
                            <label for="board10"><?= lang('app.card 10') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Card body  -->
        </div> <!--/ Card dashboard -->
    </div> <!--/ Column Left -->

    <div class="col-12 col-md-6 col-lg-6">
        <div class="card mb-6">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0 me-2"><?= lang('app.shortcut') ?></h5>
            </div>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="shortcut1" name="shortcut1">
                            </select>
                            <label for="shortcut1"><?= lang('app.shortcut 1') ?></label>
                        </div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="shortcut2" name="shortcut2">
                            </select>
                            <label for="shortcut2"><?= lang('app.shortcut 2') ?></label>
                        </div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="shortcut3" name="shortcut3">
                            </select>
                            <label for="shortcut3"><?= lang('app.shortcut 3') ?></label>
                        </div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="shortcut4" name="shortcut4">
                            </select>
                            <label for="shortcut4"><?= lang('app.shortcut 4') ?></label>
                        </div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="shortcut5" name="shortcut5">
                            </select>
                            <label for="shortcut5"><?= lang('app.shortcut 5') ?></label>
                        </div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="shortcut6" name="shortcut6">
                            </select>
                            <label for="shortcut6"><?= lang('app.shortcut 6') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Card body  -->
        </div> <!--/ Card Shortcut -->

        <div class="card mb-6">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0 me-2"><?= lang('app.default header') ?></h5>
            </div>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-12 col-md-8 col-lg-8 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="company" name="company">
                                <?= companyOptions($company, '', thisUser()) ?>
                            </select>
                            <div id="error" class="invalid-feedback err_company"></div>
                            <label for="company"><?= lang('app.company') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="object" name="object">
                                <?= objectOptions($selectObject, '', thisUser(), '') ?>
                            </select>
                            <label for="object"><?= lang('app.object') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="region" name="region">
                                <?= regionOptions($region, '', thisUser()) ?>
                            </select>
                            <div id="error" class="invalid-feedback err_region"></div>
                            <label for="region"><?= lang('app.region') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="division" name="division">
                                <?= divisionOptions($division, '', thisUser()) ?>
                            </select>
                            <div id="error" class="invalid-feedback err_division"></div>
                            <label for="division"><?= lang('app.division') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Card body  -->
        </div> <!--/ Card Company -->
    </div> <!--/ Column Right -->
</div> <!--/ Row  -->

<div class="row">
    <div class="col-12">
        <div class="card mb-6">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0 me-2"><?= lang('app.template') ?></h5>
            </div>
            <div class="card-body">
                <div class="row g-2">

                </div>

                <div class="card-footer">
                    <div class="row w-100">
                        <div class="col-12 col-md-6 col-lg-6 mb-4">
                        </div>
                        <div class="col-12 col-md-6 col-lg-6 ms-auto text-end">
                            <button type="button" class="<?= json('btn submit') ?> btn-submit"><?= json('submit') ?></button>
                        </div>
                    </div>
                </div> <!--/ Card Footer -->
            </div> <!--/ Card body  -->
        </div> <!--/ Card template -->
    </div> <!--/ Column -->
</div> <!--/ Row  -->
<?= form_close() ?>

<script>
    $('.btn-submit').click(function(e) {
        e.preventDefault();
        var form = $('.form-main')[0];
        var formData = new FormData(form);
        var getAction = $(this).val();
        var url = '<?= $link ?>/save';
        formData.append('postAction', getAction);
        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            dataType: "json",
            beforeSend: function() {
                $('.btn-submit').attr('disabled', 'disabled');
                $('.btn-submit').html('<i class="ri-loader-5-line ri-spin ri-24px"></i>');
            },
            complete: function() {
                $('.btn-submit').removeAttr('disabled');
                $('.btn-submit').each(function() {
                    $(this).html('<?= json('submit') ?>');
                });
            },
            success: function(response) {
                var alertHtml = `<div class="alert alert-primary alert-dismissible fade show" role="alert">${response.message}</div>`;
                $('#alertContainer4').html(alertHtml);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
        return false;
    })
</script>

<?= $this->endSection() ?>