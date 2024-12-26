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
                <input type="hidden" id="unique" name="unique" value="<?= ($cost[0]->unique ?? '') ?>" />
                <input type="hidden" id="askDelete" name="askDelete" />
                <div id="error" class="invalid-feedback alert alert-danger err_askDelete" role="alert"></div>
                <div class="row g-2">
                    <div class="col-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" <?= (isset($cost[0]->adaptation[0]) && $cost[0]->adaptation[0] == '1') ? 'readonly' : '' ?> class="form-control text-uppercase" id="code" name="code" maxlength="8" placeholder="<?= lang('app.required') ?>" value="<?= ($cost[0]->code ?? '') ?>" />
                            <label for="code"><?= lang('app.code') ?></label>
                            <div id="error" class="invalid-feedback err_code"></div>
                        </div>
                    </div>
                    <div class="col-6 mb-2" <?= $mpHid ?>>
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="payCode" name="payCode" placeholder="" value="<?= ($cost[0]->pay_code ?? '') ?>" />
                            <label for="payCode"><?= lang('app.pay code') ?></label>
                        </div>
                    </div>
                    <div class="col-6 mb-2" <?= $jlHid ?>>
                        <input type="checkbox" id="volumeCount" name="volumeCount" data-toggle="toggle" data-width="100%" <?= (isset($cost[0]->is_total) && $cost[0]->is_total == '1' ? 'checked' : '') ?> />
                    </div>
                    <div class="col-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="description" name="description" <?= ((isset($cost[0]->adaptation[0]) && $cost[0]->adaptation[0] == '1') ? (thisUser()['act_access'][8] == '1' ? '' : 'readonly') : '') ?> placeholder="<?= lang('app.required') ?>" value="<?= ($cost[0]->name ?? '') ?>" />
                            <label for="description"><?= lang('app.description') ?></label>
                            <div id="error" class="invalid-feedback err_description"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2" <?= $kHid ?>>
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="category" name="category">
                                <?php foreach ($category as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (isset($cost[0]->category_id) && $cost[0]->category_id == $db->id ? 'selected' : '') ?>><?= $db->name ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="category"><?= lang('app.category') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="unit" name="unit" data-allow-clear="true" data-placeholder="<?= lang('app.select-') ?>">
                                <option value="" <?= (isset($cost[0]->unit) && $cost[0]->unit == '' ? 'selected' : '') ?>></option>
                                <?php foreach ($unit as $db) : ?>
                                    <option value="<?= $db->name ?>" <?= (isset($cost[0]->unit) && $cost[0]->unit == $db->name ? 'selected' : '') ?>><?= $db->name ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="unit"><?= lang('app.unit') ?></label>
                            <div id="error" class="invalid-feedback err_unit"></div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4" <?= $aHid ?>>
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-subtext form-select" id="account" name="account" data-allow-clear="true" data-placeholder="<?= lang('app.selectSearch') ?>" <?= ((isset($cost[0]->adaptation[0]) && $cost[0]->adaptation[0] == '1') ? (thisUser()['act_access'][8] == '1' ? '' : 'disabled') : '') ?>>
                                <?php if ($account1) : ?> <option value="<?= $account1[0]->id ?>" selected data-subtext="<?= $account1[0]->name ?>"><?= $account1[0]->code ?></option><?php endif ?>
                            </select>
                            <label for="account"><?= lang('app.account number') ?></label>
                            <div id="error" class="invalid-feedback err_account"></div>
                        </div>
                    </div>
                </div>
            </div> <!--/ Modal Body -->

            <div class="modal-footer">
                <div class="row w-100">
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.save by") ?> :</small>
                        <div class="form-text"><?= ($cost[0]->saveBy ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.confirm by") ?> :</small>
                        <div class="form-text"><?= ($cost[0]->confirmBy ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= $active_by ?> :</small>
                        <div class="form-text"><?= ($cost[0]->activeBy ?? '') ?></div>
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
    $("#account").on("change", () => $("#xAccount").val($("#account").val()));
    $('.modal').on('shown.bs.modal', function() {
        $('#volumeCount').bootstrapToggle({
            onlabel: '<?= lang('app.volume+') ?>',
            offlabel: '<?= lang('app.volume+') ?>',
            onstyle: 'success',
        });

        $('#account').select2({
            dropdownParent: $('.modal'),
            ajax: {
                url: "/load/account",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        start: '5,6,8',
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
            <?= json('template 1') ?>,
            <?= json('template 2') ?>,
        });
    });

    $('.btn-save').click(function(e) {
        e.preventDefault();
        var getAction = $(this).val();
        if (getAction === 'delete') {
            deleteConfirmation("<?= lang('app.sure') ?>").then((result) => {
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
                $('#askDelete, #code, #description, #unit, #account').removeClass('is-invalid');
                $('.err_askDelete, .err_code, .err_description, .err_unit, .err_account').html('');
                if (response.error) {
                    handleFieldError('askDelete', response.error.askDelete);
                    handleFieldError('code', response.error.code);
                    handleFieldError('description', response.error.description);
                    handleFieldError('unit', response.error.unit);
                    handleFieldError('account', response.error.account);
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