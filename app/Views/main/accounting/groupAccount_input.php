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
                <input type="hidden" id="unique" name="unique" value="<?= ($groupAccount[0]->unique ?? '') ?>" />
                <input type="hidden" id="xParam" name="xParam" value="<?= ($groupAccount[0]->param ?? '') ?>" />
                <input type="hidden" id="xSubParam" name="xSubParam" value="<?= ($groupAccount[0]->sub_param ?? '') ?>" />
                <input type="hidden" id="askDelete" name="askDelete" />
                <div id="error" class="invalid-feedback alert alert-danger err_askDelete" role="alert"></div>
                <div class="row g-2">
                    <div class="col-8 col-md-8 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="group" name="group" <?= (isset($groupAccount[0]->adaptation[0]) && $groupAccount[0]->adaptation[0] == '1' ? 'disabled' : '') ?>>
                                <?php foreach ($selectGroup as $db1) : ?>
                                    <optgroup label="<?= lang('app.' . $db1->group) ?>">
                                        <?php foreach ($selectName as $db) : ?>
                                            <?php if ($db->group == $db1->group) : ?>
                                                <option value="<?= $db->name ?>" data-param="<?= $db1->group ?>" <?= (isset($groupAccount[0]->sub_param) && $groupAccount[0]->sub_param == $db->name ? 'selected' : '') ?>><?= lang('app.' . $db->name) ?></option>
                                            <?php endif ?>
                                        <?php endforeach ?>
                                    </optgroup>
                                <?php endforeach ?>
                            </select>
                            <div id="error" class="invalid-feedback err_group"></div>
                            <label for="group"><?= lang('app.group') ?></label>
                        </div>
                    </div>
                    <div class="col-4 col-md-4 col-lg-6 mb-4" id="zValue">
                        <div class="form-floating form-floating-outline">
                            <input type="number" step="0.01" class="form-control" id="value" name="value" placeholder="" value="<?= ($groupAccount[0]->value ?? '0') ?>" min="0" max="1000" />
                            <label for="value" id="zAge"><?= lang('app.age') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" <?= (isset($groupAccount[0]->adaptation[0]) && $groupAccount[0]->adaptation[0] == '1' ? 'readonly' : '') ?> class="form-control" id="description" name="description" placeholder="<?= lang('app.required') ?>" value="<?= ($groupAccount[0]->name ?? '') ?>" />
                            <label for="description"><?= lang('app.description') ?></label>
                            <div id="error" class="invalid-feedback err_description"></div>
                        </div>
                    </div>
                </div>
                <div class="row" id="zCompany">
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="company" name="company">
                                <?= companyOptions($company, $groupAccount, thisUser()) ?>
                            </select>
                            <div id="error" class="invalid-feedback err_company"></div>
                            <label for="company"><?= lang('app.company') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="account1" name="account1" data-allow-clear="true" data-placeholder="<?= lang('app.selectSearch') ?>">
                                <?php if ($account1) : ?>
                                    <option value="<?= $account1[0]->id ?>" selected><?= "{$account1[0]->code} &ensp;&emsp; {$account1[0]->name}" ?></option>
                                <?php endif ?>
                            </select>
                            <label for="account1" id="zLabel1"><?= lang('app.account number') ?></label>
                        </div>
                    </div>
                    <div class="col-12 mb-2" id="zAccount2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="account2" name="account2" data-allow-clear="true" data-placeholder="<?= lang('app.selectSearch') ?>">
                                <?php if ($account2) : ?>
                                    <option value="<?= $account2[0]->id ?>" selected><?= "{$account2[0]->code} &ensp;&emsp; {$account2[0]->name}" ?></option>
                                <?php endif ?>
                            </select>
                            <label for="account2" id="zLabel2"><?= lang('app.account number') ?></label>
                        </div>
                    </div>
                    <div class="col-12 mb-2" id="zAccount3">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="account3" name="account3" data-allow-clear="true" data-placeholder="<?= lang('app.selectSearch') ?>">
                                <?php if ($account3) : ?> <option value="<?= $account3[0]->id ?>" selected><?= "{$account3[0]->code} &ensp;&emsp; {$account3[0]->name}" ?></option><?php endif ?>
                            </select>
                            <label for="account3" id="zLabel3"><?= lang('app.road money') ?></label>
                        </div>
                    </div>
                    <div class="col-12 mb-4" id="zAccount4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="account4" name="account4" data-allow-clear="true" data-placeholder="<?= lang('app.selectSearch') ?>">
                                <?php if ($account4) : ?>
                                    <option value="<?= $account4[0]->id ?>" selected><?= "{$account4[0]->code} &ensp;&emsp; {$account4[0]->name}" ?></option>
                                <?php endif ?>
                            </select>
                            <label for="account4" id="zLabel4"><?= lang('app.cash receipt') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-100" id="notes" name="notes" placeholder=""><?= ($groupAccount[0]->notes ?? '') ?></textarea>
                            <label for="notes"><?= lang('app.notes') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Modal Body -->

            <div class="modal-footer">
                <div class="row w-100">
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.save by") ?> :</small>
                        <div class="form-text"><?= ($groupAccount[0]->saveBy ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.confirm by") ?> :</small>
                        <div class="form-text"><?= ($groupAccount[0]->confirmBy ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= $active_by ?> :</small>
                        <div class="form-text"><?= ($groupAccount[0]->activeBy ?? '') ?></div>
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
    $("#group").change(function() {
        $("#xSubParam").val($("#group").val());
        var link = "<?= $link ?>";
        var param = $("#group").find(':selected').data('param');
        $("#xParam").val(param);

        if (new URL(link).pathname === '/groupaccount') {
            switch (param) {
                case 'asset':
                    $('#zValue, #zAccount2').removeAttr('hidden');
                    $('#zAccount3, #zAccount4').attr('hidden', 'hidden');
                    $('#zLabel1').text('<?= lang('app.asset') ?>');
                    $('#zLabel2').text('<?= lang('app.depreciation') ?>');
                    break;
                case 'person':
                    $('#zValue').attr('hidden', 'hidden');
                    $('#zAccount2, #zAccount3, #zAccount4').removeAttr('hidden');
                    $('#zLabel1').text('<?= lang('app.advance payment') ?>');
                    $('#zLabel2').text('<?= lang('app.advance receipt') ?>');
                    break;
                case 'stock':
                    $('#zValue, #zAccount2, #zAccount3, #zAccount4').attr('hidden', 'hidden');
                    $('#zLabel1').text('<?= lang('app.stock') ?>');
                    break;
                default:
                    break;
            }
            $('#zAge').text('<?= lang('app.age') ?>');
        } else if (new URL(link).pathname === '/taxaccount') {
            $('#zAge').text('<?= lang('app.value') ?> (%)');
        }
    });

    function loadSubmenu() {
        var link = "<?= $link ?>";
        switch (new URL(link).pathname) {
            case '/taxaccount':
                $('#zCompany, #zAccount2, #zAccount3, #zAccount4').attr('hidden', 'hidden');
                $('#zValue').removeAttr('hidden');
                break;
            case '/cashaccount':
                $('#zCompany').removeAttr('hidden');
                $('#zValue, #zAccount2, #zAccount3, #zAccount4').attr('hidden', 'hidden');
                break;
            case '/groupaccount':
                $('#zCompany, #zValue, #zAccount2, #zAccount3, #zAccount4').attr('hidden', 'hidden');
                break;
            default:
                break;
        }
    }

    $(document).ready(function() {
        loadSubmenu();
        $("#group").trigger("change");
    });

    $('.modal').on('shown.bs.modal', function() {
        $('#account1, #account2, #account3, #account4').select2({
            dropdownParent: $('.modal'),
            ajax: {
                url: "/load/account",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        start: '',
                    };
                },
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            },
            <?= json('min input') ?>,
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
                $('#askDelete, #description').removeClass('is-invalid');
                $('.err_askDelete, .err_description').html('');
                if (response.error) {
                    handleFieldError('askDelete', response.error.askDelete);
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