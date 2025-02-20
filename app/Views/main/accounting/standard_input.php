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
                <input type="hidden" id="unique" name="unique" value="<?= ($standard[0]->unique ?? '') ?>" />
                <input type="hidden" id="xCategory" name="xCategory" value="<?= ($standard[0]->category ?? 'document reference') ?>" />
                <input type="hidden" id="askDelete" name="askDelete" />
                <div id="error" class="invalid-feedback alert alert-danger err_askDelete" role="alert"></div>
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="category" name="category" <?= (isset($standard[0]->adaptation[0]) && $standard[0]->adaptation[0] == '1' ? 'disabled' : '') ?>>
                                <?php foreach ($selectCategory as $db) : ?>
                                    <option value="<?= $db->name ?>" <?= (isset($standard[0]->param) && $standard[0]->param == $db->name ? 'selected' : '') ?>><?= lang('app.' . $db->name) ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="category"><?= lang('app.category') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-4" id="zMode1">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control text-uppercase" <?= ((isset($standard[0]->adaptation[0]) && $standard[0]->adaptation[0] == '1') ? 'readonly' : '') ?> id="code" name="code" placeholder="" maxlength="5" value="<?= ($standard[0]->code ?? '') ?>" />
                            <label for="code"><?= lang('app.code') ?></label>
                            <div id="error" class="invalid-feedback err_code"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-4" id="zMode2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control taxObject" <?= ((isset($standard[0]->adaptation[0]) && $standard[0]->adaptation[0] == '1') ? 'readonly' : '') ?> id="code2" name="code2" placeholder="" value="<?= ($standard[0]->code ?? '') ?>" data-mask="99-999-99" />
                            <label for="code2"><?= lang('app.code') ?></label>
                            <div id="error" class="invalid-feedback err_code2"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="description" name="description" <?= ((isset($standard[0]->adaptation[0]) && $standard[0]->adaptation[0] == '1') ? (thisUser()['act_access'][8] == '1' ? '' : 'readonly') : '') ?> placeholder="" value="<?= ($standard[0]->name ?? '') ?>" />
                            <label for="description"><?= lang('app.description') ?></label>
                            <div id="error" class="invalid-feedback err_description"></div>
                        </div>
                    </div>
                </div>
                <div class="row" id="zMode3">
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="tax" name="tax">
                                <?php foreach ($selectGroup as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (isset($standard[0]->tax_id) && $standard[0]->tax_id == $db->id ? 'selected' : '') ?>><?= "{$db->name} &ensp;&emsp; {$db->value} %" ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="tax"><?= lang('app.tax') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Modal Body -->

            <div class="modal-footer">
                <div class="row w-100">
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.save by") ?> :</small>
                        <div class="form-text"><?= ($standard[0]->saveBy ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.confirm by") ?> :</small>
                        <div class="form-text"><?= ($standard[0]->confirmBy ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= $active_by ?> :</small>
                        <div class="form-text"><?= ($standard[0]->activeBy ?? '') ?></div>
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

<script src="<?= base_url('libraries') ?>/cang/form-masking/form-mask.js"></script>
<script src="<?= base_url('libraries') ?>/cang/js/select2.js"></script>
<script src="<?= base_url('libraries') ?>/cang/js/extra.js"></script>
<script>
    $(document).ready(function() {
        $("#category").trigger("change")
    });

    $("#category").change(function() {
        $("#xCategory").val($(this).val());
        $('#zMode1, #zMode2, #zMode3').removeAttr('hidden');
        if ($("#xCategory").val() == '' || $("#xCategory").val() == 'document reference') {
            $('#zMode1, #zMode2, #zMode3').attr('hidden', 'hidden');
        } else if ($("#xCategory").val() == 'tax object') {
            $('#zMode1').attr('hidden', 'hidden');
        } else if ($("#xCategory").val() == 'code standard') {
            $('#zMode2, #zMode3').attr('hidden', 'hidden');
        }
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
                $('#askDelete, #code, #code2, #description').removeClass('is-invalid');
                $('.err_askDelete, .err_code, .err_code2, .err_description').html('');
                if (response.error) {
                    handleFieldError('askDelete', response.error.askDelete);
                    handleFieldError('code', response.error.code);
                    handleFieldError('code2', response.error.code2);
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