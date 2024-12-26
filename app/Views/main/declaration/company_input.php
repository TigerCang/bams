<?= $this->extend($template == 'vertical' ? 'layouts/template-vertical' : 'layouts/template-horizontal') ?>
<?= $this->section('content') ?>

<?= form_open('', ['class' => 'form-main']) ?>
<?= csrf_field() ?>
<div class="row">
    <div class="col-12 col-md-12 col-lg-8">
        <div class="card mb-6">
            <div class="card-body">
                <input type="hidden" id="unique" name="unique" value="<?= ($company[0]->unique ?? '') ?>" />
                <input type="hidden" name="pictureName" value="<?= ($company[0]->picture ?? 'default.png') ?>" />
                <input type="hidden" id="askDelete" name="askDelete" />
                <div id="error" class="invalid-feedback alert alert-danger err_askDelete" role="alert"></div>
                <div class="row g-2">
                    <div class="col-12 col-md-7 col-lg-7 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" <?= (isset($company[0]->adaptation[0]) && $company[0]->adaptation[0] == '1') ? 'readonly' : '' ?> class="form-control" id="code" name="code" placeholder="<?= lang('app.required') ?>" value="<?= ($company[0]->code ?? '') ?>" />
                            <label for="code"><?= lang('app.code') ?></label>
                            <div id="error" class="invalid-feedback err_code"></div>
                        </div>
                    </div>
                    <div class="col-7 col-md-3 col-lg-3 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control text-uppercase" id="initial" name="initial" <?= ((isset($company[0]->adaptation[0]) && $company[0]->adaptation[0] == '1') ? (thisUser()['act_access'][8] == '1' ? '' : 'readonly') : '') ?> maxlength="3" placeholder="<?= lang('app.required') ?>" value="<?= ($company[0]->initial ?? '') ?>" />
                            <label for="initial"><?= lang('app.initial') ?></label>
                            <div id="error" class="invalid-feedback err_initial"></div>
                        </div>
                    </div>
                    <div class="col-5 col-md-2 col-lg-2 mb-2">
                        <div class="d-flex align-items-center">
                            <input type="checkbox" id="tax" name="tax" data-toggle="toggle" data-width="100%" <?= (isset($company[0]->is_tax) && $company[0]->is_tax == '1' ? 'checked' : '') ?> data-onlabel="<?= lang('app.tax') ?>" data-offlabel="<?= lang('app.tax') ?>" data-onstyle="success" />
                        </div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="description" name="description" <?= ((isset($company[0]->adaptation[0]) && $company[0]->adaptation[0] == '1') ? (thisUser()['act_access'][8] == '1' ? '' : 'readonly') : '') ?> placeholder="<?= lang('app.required') ?>" value="<?= ($company[0]->name ?? '') ?>" />
                            <label for="description"><?= lang('app.description') ?></label>
                            <div id="error" class="invalid-feedback err_description"></div>
                        </div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-150" id="law1" name="law1" placeholder=""><?= ($company[0]->law1 ?? '') ?></textarea>
                            <label for="law1"><?= lang('app.legal foundation 1') ?></label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-150" id="law2" name="law2" placeholder=""><?= ($company[0]->law2 ?? '') ?></textarea>
                            <label for="law2"><?= lang('app.legal foundation 2') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Card body  -->

            <div class="card-footer">
                <div class="row w-100">
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.save by") ?> :</small>
                        <div class="form-text"><?= ($company[0]->saveBy ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.confirm by") ?> :</small>
                        <div class="form-text"><?= ($company[0]->confirmBy ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= $active_by ?> :</small>
                        <div class="form-text"><?= ($company[0]->activeBy ?? '') ?></div>
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
            </div> <!--/ Card Footer -->
        </div> <!--/ Card Init -->
    </div> <!--/ Right Column -->

    <div class="col-12 col-md-12 col-lg-4">
        <div class="card mb-6">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 mb-2">
                        <img class="img-fluid img-preview" src="/assets/picture/company/<?= ($company ? $company[0]->picture : 'default.png') ?>">
                    </div>
                    <div class="col-12 mb-2">
                        <input type="file" class="form-control" id="picture" name="picture" onchange="previewImage()" />
                        <div id="error" class="invalid-feedback err_picture"></div>
                    </div>
                    <span><?= ($company[0]->picture ?? '') ?></span>
                </div>
            </div> <!--/ Card body  -->
        </div> <!--/ Card action -->
    </div> <!--/ Column -->
</div> <!--/ Row-->

<div class="row">
    <div class="col-12">
        <div class="card mb-6">
            <div class="card-header pb-0 mb-4">
                <div class="d-flex justify-content-between align-items-center row py-0 gap-3 gap-md-0">
                    <div><button type="button" class="<?= json('btn create') ?> btn-input <?= ($company ? '' : 'disabled') ?>" data-action="action1" <?= (thisUser()['act_button'][0] == '0' ? 'disabled' : '') ?>><?= lang('app.btn add') ?></button></div>
                </div>
                <div id="alertContainer1" class="mt-2"></div>
            </div><!--/ Card Header -->
            <div class="card-datatable table-responsive viewTable1"></div>
        </div><!--/ Card -->
    </div><!--/ Col -->
</div><!--/ Row -->

<div class="row">
    <div class="col-12">
        <div class="card mb-6">
            <div class="card-header pb-0 mb-4">
                <div class="d-flex justify-content-between align-items-center row py-0 gap-3 gap-md-0">
                    <div>
                        <button type="button" class="<?= json('btn create') ?> btn-input <?= ($company ? '' : 'disabled') ?>" data-action="action2" <?= (thisUser()['act_button'][0] == '0' ? 'disabled' : '') ?>><?= lang('app.btn add') ?></button>
                    </div>
                </div>
                <div id="alertContainer2" class="mt-2"></div>
            </div><!--/ Card Header -->
            <div class="card-datatable table-responsive viewTable2"></div>
        </div><!--/ Card -->
    </div><!--/ Col -->
</div><!--/ Row -->

<div class="row">
    <div class="col-12">
        <div class="card mb-6">
            <div class="card-header pb-0 mb-4">
                <div class="d-flex justify-content-between align-items-center row py-0 gap-3 gap-md-0">
                    <div class="col-4 col-md-9 col-lg-10">
                        <button type="button" class="<?= json('btn create') ?> btn-input <?= ($company ? '' : 'disabled') ?>" data-action="action3" <?= (thisUser()['act_button'][0] == '0' ? 'disabled' : '') ?>><?= lang('app.btn add') ?></button>
                    </div>
                    <div class="col-6 col-md-3 col-lg-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control autonumber" data-a-sep="." data-a-dec="," id="stockPrice" name="stockPrice" placeholder="" value="<?= $priceStock ?>" />
                            <label for="stock Price"><?= lang('app.stock price') ?></label>
                        </div>
                    </div>
                </div>
                <div id="alertContainer3" class="mt-2"></div>
            </div><!--/ Card Header -->
            <div class="card-datatable table-responsive viewTable3"></div>
        </div><!--/ Card -->
    </div><!--/ Col -->
</div><!--/ Row -->

<div class="row">
    <div class="col-12">
        <div class="card mb-6">
            <div class="card-header pb-0 mb-4">
                <div class="d-flex justify-content-between align-items-center row py-0 gap-3 gap-md-0">
                    <div class="col-4 col-md-9 col-lg-10">
                        <button type="button" class="<?= json('btn create') ?> btn-input <?= ($company ? '' : 'disabled') ?>" data-action="action4" <?= (thisUser()['act_button'][0] == '0' ? 'disabled' : '') ?>><?= lang('app.btn add') ?></button>
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
        callCompany();
        callAttachment();
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
        // for (var pair of formData.entries()) console.log(pair[0] + ': ' + pair[1]);
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
                $('#askDelete, #code, #initial, #description, #picture').removeClass('is-invalid');
                $('.err_askDelete, .err_code, .err_initial, .err_description, .err_picture').html('');
                if (response.error) {
                    handleFieldError('askDelete', response.error.askDelete);
                    handleFieldError('code', response.error.code);
                    handleFieldError('initial', response.error.initial);
                    handleFieldError('description', response.error.description);
                    handleFieldError('picture', response.error.picture);
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

    $(document).on('click', '.btn-input', function(e) {
        e.preventDefault();
        var getUnique = $('#unique').val();
        var getPrice = $('#stockPrice').val();
        var getAction = $(this).data('action'); // Get data-action from button
        var url = "";

        if (getAction === 'action1') {
            url = "<?= $link ?>/inputmodal/1";
        } else if (getAction === 'action2') {
            url = "<?= $link ?>/inputmodal/2";
        } else if (getAction === 'action3') {
            url = "<?= $link ?>/inputmodal/3";
        } else if (getAction === 'action4') {
            url = "/attachment/modal";
        }

        $.ajax({
            url: url,
            data: {
                unique: getUnique,
                price: getPrice,
                object: 'company',
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

    function callCompany() {
        var getUnique = $("#unique").val();
        var url = "";
        $.ajax({
            url: "<?= $link ?>/tablemodal",
            data: {
                unique: getUnique,
            },
            dataType: "json",
            success: function(response) {
                $('.viewTable1').html(response.table1);
                $('.viewTable2').html(response.table2);
                $('.viewTable3').html(response.table3);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    function callAttachment() {
        var getUnique = $("#unique").val();
        $.ajax({
            url: "/attachment/table",
            data: {
                unique: getUnique,
                object: 'company',
                table: 'm_company',
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