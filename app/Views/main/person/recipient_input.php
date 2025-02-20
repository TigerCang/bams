<div class="modal fade" id="modal-input" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header <?= json('modal input') ?>">
                <h4 class="modal-title title-modal"><?= ($t_modal ?? '') ?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <?= form_open('', ['class' => 'form-main']) ?>
            <?= csrf_field() ?>
            <div class="modal-body">
                <input type="hidden" id="unique" name="unique" value="<?= ($recipient[0]->unique ?? '') ?>" />
                <input type="hidden" id="askDelete" name="askDelete" />
                <div id="error" class="invalid-feedback alert alert-danger err_askDelete" role="alert"></div>
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control text-uppercase" id="code" name="code" <?= (isset($recipient[0]->adaptation[0]) && ($recipient[0]->adaptation[0] == '1' || $recipient[0]->is_alias[3] == '1')  ? 'readonly' : '') ?> maxlength="16" placeholder="<?= lang('app.required') ?>" value="<?= ($recipient[0]->code ?? '') ?>" />
                            <label for="code"><?= lang('app.code') ?></label>
                            <div id="error" class="invalid-feedback err_code"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-tokenizer form-select" id="category" name="category" data-allow-clear="true" data-placeholder="<?= lang('app.selectCreate') ?>">
                                <option value="" <?= (isset($recipient[0]->category) && $recipient[0]->category == '' ? 'selected' : '') ?>></option>
                                <?php foreach ($category as $db) : ?>
                                    <option value="<?= $db->category ?>" <?= (isset($recipient[0]->category) && $recipient[0]->category == $db->category ? 'selected' : '') ?>><?= $db->category ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="category"><?= lang('app.category') ?></label>
                            <div id="error" class="invalid-feedback err_category"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" <?= (isset($recipient[0]->adaptation[0]) && ($recipient[0]->adaptation[0] == '1' || $recipient[0]->is_alias[3] == '1') ? 'readonly' : '') ?> class="form-control" id="description" name="description" placeholder="<?= lang('app.required') ?>" value="<?= ($recipient[0]->name ?? '') ?>" />
                            <label for="description"><?= lang('app.description') ?></label>
                            <div id="error" class="invalid-feedback err_description"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" <?= (isset($recipient[0]->adaptation[0]) && $recipient[0]->is_alias[3] == '1' ? 'readonly' : '') ?> class="form-control" id="email" name="email" placeholder="" value="<?= ($recipient[0]->email ?? '') ?>" />
                            <label for="email"><?= lang('app.email') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-100" <?= (isset($recipient[0]->adaptation[0]) && $recipient[0]->is_alias[3] == '1' ? 'readonly' : '') ?> id="address" name="address" placeholder=""><?= ($recipient[0]->address ?? '') ?></textarea>
                            <label for="address"><?= lang('app.address') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-100" <?= (isset($recipient[0]->adaptation[0]) && $recipient[0]->is_alias[3] == '1' ? 'readonly' : '') ?> id="contact" name="contact" placeholder=""><?= ($recipient[0]->contact ?? '') ?></textarea>
                            <label for="contact"><?= lang('app.contact') ?></label>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2 mb-2">
                        <input type="checkbox" id="customer" name="customer" data-toggle="toggle" data-width="90%" <?= (isset($recipient[0]->is_alias) && $recipient[0]->is_alias[0] == '1' ? 'checked' : '') ?> />
                    </div>
                    <div class="col-12 col-md-8 col-lg-4 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="groupAccount1" name="groupAccount1" data-allow-clear="true" data-placeholder="<?= lang('app.select-') ?>">
                                <option value="" <?= (isset($recipient[0]->group_account_customer) && $recipient[0]->group_account_customer == '' ? 'selected' : '') ?>></option>
                                <?php foreach ($selectGroup1 as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (isset($recipient[0]->group_account_customer) && $recipient[0]->group_account_customer == $db->id ? 'selected' : '') ?>><?= $db->name ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="groupAccount1"><?= lang('app.group account') ?></label>
                            <div id="error" class="invalid-feedback err_groupAccount1"></div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2 mb-2">
                        <input type="checkbox" id="supplier" name="supplier" data-toggle="toggle" data-width="90%" <?= (isset($recipient[0]->is_alias) && $recipient[0]->is_alias[1] == '1' ? 'checked' : '') ?> />
                    </div>
                    <div class="col-12 col-md-8 col-lg-4 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="groupAccount2" name="groupAccount2" data-allow-clear="true" data-placeholder="<?= lang('app.select-') ?>">
                                <option value="" <?= (isset($recipient[0]->group_account_supplier) && $recipient[0]->group_account_supplier == '' ? 'selected' : '') ?>></option>
                                <?php foreach ($selectGroup2 as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (isset($recipient[0]->group_account_supplier) && $recipient[0]->group_account_supplier == $db->id ? 'selected' : '') ?>><?= $db->name ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="groupAccount2"><?= lang('app.group account') ?></label>
                            <div id="error" class="invalid-feedback err_groupAccount2"></div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2 mb-2">
                        <input type="checkbox" id="subcontractor" name="subcontractor" data-toggle="toggle" data-width="90%" <?= (isset($recipient[0]->is_alias) && $recipient[0]->is_alias[2] == '1' ? 'checked' : '') ?> />
                    </div>
                    <div class="col-12 col-md-8 col-lg-4 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="groupAccount3" name="groupAccount3" data-allow-clear="true" data-placeholder="<?= lang('app.select-') ?>">
                                <option value="" <?= (isset($recipient[0]->group_account_partner) && $recipient[0]->group_account_partner == '' ? 'selected' : '') ?>></option>
                                <?php foreach ($selectGroup3 as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (isset($recipient[0]->group_account_partner) && $recipient[0]->group_account_partner == $db->id ? 'selected' : '') ?>><?= $db->name ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="groupAccount3"><?= lang('app.group account') ?></label>
                            <div id="error" class="invalid-feedback err_groupAccount3"></div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2 mb-2">
                        <input type="checkbox" id="employee" name="employee" data-toggle="toggle" data-width="90%" <?= (isset($recipient[0]->is_alias) && $recipient[0]->is_alias[3] == '1' ? 'checked' : '') ?> disabled />
                    </div>
                    <div class="col-12 col-md-8 col-lg-4 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="groupAccount4" name="groupAccount4" data-allow-clear="true" data-placeholder="<?= lang('app.select-') ?>" disabled>
                                <option value="" <?= (isset($recipient[0]->group_account_employee) && $recipient[0]->group_account_employee == '' ? 'selected' : '') ?>></option>
                                <?php foreach ($selectGroup4 as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (isset($recipient[0]->group_account_employee) && $recipient[0]->group_account_employee == $db->id ? 'selected' : '') ?>><?= $db->name ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="groupAccount4"><?= lang('app.group account') ?></label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-100" <?= (isset($recipient[0]->adaptation[0]) && $recipient[0]->is_alias[3] == '1' ? 'readonly' : '') ?> id="notes" name="notes" placeholder=""><?= ($recipient[0]->notes ?? '') ?></textarea>
                            <label for="notes"><?= lang('app.notes') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Modal Body -->

            <div class="modal-footer">
                <div class="row w-100">
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.save by") ?> :</small>
                        <div class="form-text"><?= ($recipient[0]->saveBy ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.confirm by") ?> :</small>
                        <div class="form-text"><?= ($recipient[0]->confirmBy ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= $active_by ?> :</small>
                        <div class="form-text"><?= ($recipient[0]->activeBy ?? '') ?></div>
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
    function initializeBsToggle(selector, onLabel, offLabel, onStyle) {
        $(selector).bootstrapToggle({
            onlabel: onLabel,
            offlabel: offLabel,
            onstyle: onStyle
        });
    }

    $('#modal-input').on('shown.bs.modal', function() {
        initializeBsToggle('#customer', '<?= lang('app.customer') ?>', '<?= lang('app.customer') ?>', 'primary');
        initializeBsToggle('#supplier', '<?= lang('app.supplier') ?>', '<?= lang('app.supplier') ?>', 'primary');
        initializeBsToggle('#subcontractor', '<?= lang('app.subcontractor') ?>', '<?= lang('app.subcontractor') ?>', 'primary');
        initializeBsToggle('#employee', '<?= lang('app.employee') ?>', '<?= lang('app.employee') ?>', 'primary');
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
                $('#askDelete, #code, #description, #category, #groupAccount1, #groupAccount2, #groupAccount3').removeClass('is-invalid');
                $('.err_askDelete, .err_code, .err_description, .err_category, .err_groupAccount1, .err_groupAccount2, .err_groupAccount3').html('');
                if (response.error) {
                    handleFieldError('askDelete', response.error.askDelete);
                    handleFieldError('code', response.error.code);
                    handleFieldError('description', response.error.description);
                    handleFieldError('category', response.error.category);
                    handleFieldError('groupAccount1', response.error.groupAccount1);
                    handleFieldError('groupAccount2', response.error.groupAccount2);
                    handleFieldError('groupAccount3', response.error.groupAccount3);
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