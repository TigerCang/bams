<div class="modal fade" id="modal-input" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header <?= json('modal input') ?>">
                <h4 class="modal-title title-modal"><?= ($t_modal ?? '') ?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <?= form_open('', ['class' => 'form-main']) ?>
            <?= csrf_field() ?>
            <div class="modal-body">
                <input type="hidden" id="unique" name="unique" value="<?= ($file[0]->unique ?? '') ?>" />
                <input type="hidden" id="askDelete" name="askDelete" />
                <div id="error" class="invalid-feedback alert alert-danger err_askDelete" role="alert"></div>
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" readonly class="form-control" id="param" name="param" placeholder="" value="<?= lang('app.' . $param)  ?>" />
                            <label for="param"></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2" <?= $cHid ?>>
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control text-uppercase" id="code" name="code" maxlength="5" placeholder="" value="<?= ($file[0]->name2 ?? '') ?>" />
                            <label for="code"><?= lang('app.code') ?></label>
                            <div id="error" class="invalid-feedback err_code"></div>
                        </div>
                    </div>
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" <?= (isset($file[0]->adaptation[0]) && $file[0]->adaptation[0] == '1' ? 'readonly' : '') ?> class="form-control" id="description" name="description" placeholder="<?= lang('app.required') ?>" value="<?= ($file[0]->name ?? '') ?>" />
                            <label for="description"><?= lang('app.description') ?></label>
                            <div id="error" class="invalid-feedback err_description"></div>
                        </div>
                    </div>
                </div>
                <div class="row g-2" <?= $cHid ?>>
                    <div class="col-6 col-md-4 col-lg-3 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="number" class="form-control" id="day" name="day" placeholder="<?= lang('app.required') ?>" value="<?= ($file[0]->value ?? '0') ?>" min="0" max="356" />
                            <label for="day"><?= lang('app.day') ?></label>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-3 mb-2">
                        <input type="checkbox" id="cutoff" name="cutoff" data-toggle="toggle" data-width="100%" <?= (isset($file[0]->set_default) && $file[0]->set_default == '1' ? 'checked' : '') ?> />
                    </div>
                </div>
                <div class="row g-2" <?= $rHid ?>>
                    <div class="col-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="company" name="company" <?= (isset($tool[0]->adaptation[0]) && $tool[0]->adaptation[0] == '1' ? 'disabled' : '') ?>>
                                <?= companyOptions($company, $file, thisUser()) ?>
                            </select>
                            <label for="company"><?= lang('app.company') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="region" name="region" <?= (isset($tool[0]->adaptation[0]) && $tool[0]->adaptation[0] == '1' ? 'disabled' : '') ?>>
                                <?= regionOptions($region, $file, thisUser()) ?>
                            </select>
                            <label for="region"><?= lang('app.region') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="division" name="division" <?= (isset($tool[0]->adaptation[0]) && $tool[0]->adaptation[0] == '1' ? 'disabled' : '') ?>>
                                <?= divisionOptions($division, $file, thisUser()) ?>
                            </select>
                            <label for="division"><?= lang('app.division') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Modal Body -->

            <div class="modal-footer">
                <div class="row w-100">
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.save by") ?> :</small>
                        <div class="form-text"><?= ($file[0]->saveBy ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.confirm by") ?> :</small>
                        <div class="form-text"><?= ($file[0]->confirmBy ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= $active_by ?> :</small>
                        <div class="form-text"><?= ($file[0]->activeBy ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 ms-auto text-end">
                        <div class="btn-group" id="dropdown-icon">
                            <button type="button" class="<?= json('btn submit') ?> btn-submit dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><?= json('submit') ?></button>
                            <ul class="dropdown-menu">
                                <li><button type="button" name="action" value="save" class="dropdown-item d-flex align-items-center btn-save" <?= $button['save'] ?>><?= lang('app.btn save') ?></button></li>
                                <li><button type="button" name="action" value="confirm" class="dropdown-item d-flex align-items-center btn-save" <?= $button['confirm'] ?>><?= lang('app.btn confirm') ?></button></li>
                                <li><button type="button" name="action" value="delete" class="dropdown-item d-flex align-items-center btn-save" <?= $button['delete'] ?>><?= lang('app.btn delete') ?></button></li>
                                <li><button type="button" name="action" value="active" class="dropdown-item d-flex align-items-center btn-save" <?= $button['active'] ?>><?= $btn_active ?></button></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div> <!--/ Modal Footer -->
            <?= form_close() ?>

        </div> <!--/ Modal Content -->
    </div> <!--/ Modal Dialog -->
</div> <!--/ Modal fade -->

<script src="<?= base_url('libraries') ?>/cang/js/select2.js"></script>
<script src="<?= base_url('libraries') ?>/cang/js/extra.js"></script>
<script>
    $('#modal-input').on('shown.bs.modal', function() {
        $('#cutoff').bootstrapToggle({
            onlabel: '<?= lang('app.cut leave') ?>',
            offlabel: '<?= lang('app.cut leave') ?>',
            onstyle: 'danger',
        });
    });

    $('.btn-save').click(function(e) {
        e.preventDefault();
        var getAction = $(this).val();
        if (getAction === 'delete') {
            askConfirmation("<?= lang('app.sure') ?>", "<?= lang('app.confirm delete') ?>").then((result) => {
                if (result.isConfirmed) {
                    submitForm(getAction);
                } else {
                    return;
                }
            });
        } else {
            submitForm(getAction);
        }
    })

    function submitForm(getAction) {
        var form = $('.form-main')[0];
        var formData = new FormData(form);
        var url = '<?= $link ?>/save';
        formData.append('postAction', getAction);
        $.ajax({
            type: 'post',
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
                $('#askDelete, #code, #description').removeClass('is-invalid');
                $('.err_askDelete, .err_code, .err_description').html('');
                if (response.error) {
                    handleFieldError('askDelete', response.error.askDelete);
                    handleFieldError('code', response.error.code);
                    handleFieldError('description', response.error.description);
                } else {
                    window.location.href = response.redirect;
                }

                function handleFieldError(field, error) {
                    if (error) {
                        $('#' + field).addClass('is-invalid');
                        $('.err_' + field).html(error);
                    } else {
                        $('#' + field).removeClass('is-invalid');
                    }
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
        return false;
    }
</script>