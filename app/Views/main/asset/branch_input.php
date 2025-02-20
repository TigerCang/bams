<?= $this->extend($template == 'vertical' ? 'layouts/template-vertical' : 'layouts/template-horizontal') ?>
<?= $this->section('content') ?>

<?= form_open('', ['class' => 'form-main']) ?>
<?= csrf_field() ?>
<div class="row">
    <div class="col-12">
        <div class="card mb-6">
            <div class="card-body">
                <input type="hidden" id="unique" name="unique" value="<?= ($branch[0]->unique ?? '') ?>" />
                <input type="hidden" id="askDelete" name="askDelete" />
                <div id="error" class="invalid-feedback alert alert-danger err_askDelete" role="alert"></div>
                <div class="row g-2">
                    <div class="col-12 col-md-4 col-lg-3 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control text-uppercase" <?= (isset($branch[0]->adaptation[0]) && $branch[0]->adaptation[0] == '1') ? 'readonly' : '' ?> id="code" name="code" placeholder="<?= lang('app.required') ?>" maxlength="10" value="<?= ($branch[0]->code ?? '') ?>" />
                            <label for="code"><?= lang('app.code') ?></label>
                            <div id="error" class="invalid-feedback err_code"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-8 col-lg-9 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="description" name="description" <?= ((isset($branch[0]->adaptation[0]) && $branch[0]->adaptation[0] == '1') ? (thisUser()['act_access'][8] == '1' ? '' : 'readonly') : '') ?> placeholder="<?= lang('app.required') ?>" value="<?= ($branch[0]->name ?? '') ?>" />
                            <label for="description"><?= lang('app.description') ?></label>
                            <div id="error" class="invalid-feedback err_description"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="company" name="company" <?= (isset($branch[0]->adaptation[0]) && $branch[0]->adaptation[0] == '1' ? 'disabled' : '') ?>>
                                <?= companyOptions($company, $branch, thisUser()) ?>
                            </select>
                            <div id="error" class="invalid-feedback err_company"></div>
                            <label for="company"><?= lang('app.company') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="region" name="region" <?= (isset($branch[0]->adaptation[0]) && $branch[0]->adaptation[0] == '1' ? 'disabled' : '') ?>>
                                <?= regionOptions($region, $branch, thisUser()) ?>
                            </select>
                            <div id="error" class="invalid-feedback err_region"></div>
                            <label for="region"><?= lang('app.region') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="division" name="division" <?= (isset($branch[0]->adaptation[0]) && $branch[0]->adaptation[0] == '1' ? 'disabled' : '') ?>>
                                <?= divisionOptions($division, $branch, thisUser()) ?>
                            </select>
                            <div id="error" class="invalid-feedback err_division"></div>
                            <label for="division"><?= lang('app.division') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-100" id="address" name="address" placeholder=""><?= ($branch[0]->address ?? '') ?></textarea>
                            <label for="address"><?= lang('app.address') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-100" id="notes" name="notes" placeholder=""><?= ($branch[0]->notes ?? '') ?></textarea>
                            <label for="notes"><?= lang('app.notes') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Card body  -->

            <div class="card-footer">
                <div class="row w-100">
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.save by") ?> :</small>
                        <div class="form-text"><?= ($branch[0]->saveBy ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.confirm by") ?> :</small>
                        <div class="form-text"><?= ($branch[0]->confirmBy ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= $active_by ?> :</small>
                        <div class="form-text"><?= ($branch[0]->activeBy ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 ms-auto text-end">
                        <div class="btn-group" id="dropdown-icon" <?= $buttonHidden ?>>
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
            </div> <!--/ Card Footer -->
        </div> <!--/ Card -->
    </div> <!--/ Column -->
</div> <!--/ Row-->

<div class="row">
    <div class="col-12">
        <div class="card mb-6">
            <div class="card-header pb-0 mb-4">
                <div class="d-flex justify-content-between align-items-center row py-0 gap-3 gap-md-0">
                    <div class="col-4 col-md-9 col-lg-10">
                        <button type="button" class="<?= json('btn create') ?> input-attachment <?= ($branch ? '' : 'disabled') ?>" <?= (thisUser()['act_button'][0] == '0' ? 'disabled' : '') ?>><?= lang('app.btn add') ?></button>
                    </div>
                </div>
                <div id="alertContainer4" class="mt-2"></div>
            </div><!--/ Card Header -->
            <div class="card-datatable table-responsive viewTable4"></div>
        </div><!--/ Card -->
    </div><!--/ Col -->
</div><!--/ Row -->
<?= form_close() ?>
<div class="modal-input" style="display: none;"></div>

<script>
    $(document).ready(function() {
        callAttachment();
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
                $('#askDelete, #company, #region, #division, #code, #description').removeClass('is-invalid');
                $('.err_askDelete, .err_company, .err_region, .err_division, .err_code, .err_description').html('');
                if (response.error) {
                    handleFieldError('askDelete', response.error.askDelete);
                    handleFieldError('company', response.error.company);
                    handleFieldError('region', response.error.region);
                    handleFieldError('division', response.error.division);
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

    $('.input-attachment').click(function(e) {
        e.preventDefault();
        var getUnique = $('#unique').val();
        $.ajax({
            url: "/attachment/modal",
            data: {
                unique: getUnique,
                object: 'branch',
                ska: '0',
            },
            dataType: "json",
            success: function(response) {
                $('.modal-input').html(response.data).show();
                $('#modal-input').modal('show')
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    })

    function callAttachment() {
        var getUnique = $("#unique").val();
        $.ajax({
            url: "/attachment/table",
            data: {
                unique: getUnique,
                object: 'branch',
                table: 'm_branch',
            },
            dataType: "json",
            success: function(response) {
                $('.viewTable4').html(response.data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }
</script>

<?= $this->endSection() ?>