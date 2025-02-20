<?= $this->extend($template == 'vertical' ? 'layouts/template-vertical' : 'layouts/template-horizontal') ?>
<?= $this->section('content') ?>

<?= form_open('', ['class' => 'form-main']) ?>
<?= csrf_field() ?>
<div class="row">
    <div class="col-12 col-md-12 col-lg-8">
        <div class="card mb-6">
            <div class="card-body">
                <input type="hidden" id="unique" name="unique" value="<?= ($inventory[0]->unique ?? '') ?>" />
                <input type="hidden" name="pictureName" value="<?= ($inventory[0]->picture ?? 'default.png') ?>" />
                <input type="hidden" id="age" name="age" />
                <input type="hidden" id="remain" name="remain" value="<?= ($inventory[0]->remain ?? '0') ?>" />
                <input type="hidden" id="askDelete" name="askDelete" />
                <div id="error" class="invalid-feedback alert alert-danger err_askDelete" role="alert"></div>
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control text-uppercase inventory" id="code" name="code" <?= (isset($inventory[0]->adaptation[0]) && $inventory[0]->adaptation[0] == '1' ? 'readonly' : '') ?> placeholder="<?= lang('app.required') ?>" maxlength="17" value="<?= ($inventory[0]->code ?? '') ?>" data-mask="aaa-a-aaa-999.999" />
                            <label for="code"><?= lang('app.code') ?></label>
                            <div id="error" class="invalid-feedback err_code"></div>
                        </div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="description" name="description" <?= (isset($inventory[0]->adaptation[0]) && $inventory[0]->adaptation[0] == '1' ? 'readonly' : '') ?> placeholder="<?= lang('app.required') ?>" value="<?= ($inventory[0]->name ?? '') ?>" />
                            <label for="description"><?= lang('app.description') ?></label>
                            <div id="error" class="invalid-feedback err_description"></div>
                        </div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="company" name="company" <?= (isset($inventory[0]->adaptation[0]) && $inventory[0]->adaptation[0] == '1' ? 'disabled' : '') ?>>
                                <?= companyOptions($company, $inventory, thisUser()) ?>
                            </select>
                            <div id="error" class="invalid-feedback err_company"></div>
                            <label for="company"><?= lang('app.company') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="region" name="region" <?= (isset($inventory[0]->adaptation[0]) && $inventory[0]->adaptation[0] == '1' ? 'disabled' : '') ?>>
                                <?= regionOptions($region, $inventory, thisUser()) ?>
                            </select>
                            <div id="error" class="invalid-feedback err_region"></div>
                            <label for="region"><?= lang('app.region') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="division" name="division" <?= (isset($inventory[0]->adaptation[0]) && $inventory[0]->adaptation[0] == '1' ? 'disabled' : '') ?>>
                                <?= divisionOptions($division, $inventory, thisUser()) ?>
                            </select>
                            <div id="error" class="invalid-feedback err_division"></div>
                            <label for="division"><?= lang('app.division') ?></label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="branch" name="branch" data-allow-clear="true" data-placeholder="<?= lang('app.selectSearch') ?>">
                                <?php if ($branch1) : ?>
                                    <option value="<?= $branch1[0]->id ?>" selected><?= "{$branch1[0]->code} &ensp;&emsp; {$branch1[0]->name}" ?></option>
                                <?php endif ?>
                            </select>
                            <div id="error" class="invalid-feedback err_branch"></div>
                            <label for="branch"><?= lang('app.branch') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Card body  -->
        </div> <!--/ Card init -->
    </div> <!--/ Column left -->

    <div class="col-12 col-md-12 col-lg-4">
        <div class="card mb-6">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 mb-2">
                        <img class="img-fluid img-preview" src="/assets/picture/inventory/<?= ($inventory ? $inventory[0]->picture : 'default.png') ?>">
                    </div>
                    <div class="col-12 mb-2">
                        <input type="file" class="form-control" id="picture" name="picture" onchange="previewImage()" />
                        <div id="error" class="invalid-feedback err_picture"></div>
                    </div>
                    <span><?= ($inventory[0]->picture ?? '') ?></span>
                </div>
            </div> <!--/ Card body  -->
        </div> <!--/ Card picture -->
    </div> <!--/ Column right -->
</div> <!--/ Row-->

<div class="row">
    <div class="col-12">
        <div class="card mb-6">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="groupAccount" name="groupAccount">
                                <?php foreach ($selectGroup as $db) : ?>
                                    <option value="<?= $db->id ?>" data-age="<?= formatComa($db->value, 0) ?>" <?= (isset($inventory[0]->group_account) && $inventory[0]->group_account == $db->id ? 'selected' : '') ?>><?= $db->name ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="groupAccount"><?= lang('app.group account') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-tokenizer form-select" id="category" name="category" data-allow-clear="true" data-placeholder="<?= lang('app.selectCreate') ?>">
                                <option value="" <?= (isset($inventory[0]->category) && $inventory[0]->category == '' ? 'selected' : '') ?>></option>
                                <?php foreach ($selectCategory as $db) : ?>
                                    <option value="<?= $db->category ?>" <?= (isset($inventory[0]->category) && $inventory[0]->category == $db->category ? 'selected' : '') ?>><?= $db->category ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="category"><?= lang('app.category') ?></label>
                            <div id="error" class="invalid-feedback err_category"></div>
                        </div>
                    </div>
                    <div class="col-6 col-md-8 col-lg-8 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="invoice" name="invoice" placeholder="" value="<?= ($inventory[0]->invoice ?? '') ?>" />
                            <label for="invoice"><?= lang('app.invoice') ?></label>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-4 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="date" class="form-control" id="purchaseDate" name="purchaseDate" value="<?= ($inventory[0]->purchase_date ?? '') ?>" />
                            <label for="purchaseDate"><?= lang('app.date') ?></label>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-4 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control autonumber" data-a-sep="." data-a-dec="," id="purchaseValue" name="purchaseValue" placeholder="" value="<?= ($inventory[0]->purchase_value ?? '') ?>" onchange="countDepreciation()" />
                            <label for="purchaseValue"><?= lang('app.purchase value') ?></label>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-4 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control autonumber" data-a-sep="." data-a-dec="," id="residualValue" name="residualValue" placeholder="" value="<?= ($inventory[0]->residual_value ?? '') ?>" />
                            <label for="residualValue"><?= lang('app.residual value') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" readonly class="form-control" id="invoiceLink" name="invoiceLink" placeholder="" value="<?= ($inventory[0]->invoice_link ?? '') ?>" />
                            <label for="invoiceLink"><?= lang('app.invoice link') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="depreciationMode" name="depreciationMode">
                                <?php foreach ($selectDepreciation as $db) : ?>
                                    <option value="<?= $db->name ?>" <?= (isset($inventory[0]->depreciation_mode) && $inventory[0]->depreciation_mode == $db->name ? 'selected' : '') ?>><?= lang('app.' . $db->name) ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="depreciationMode"><?= lang('app.depreciation mode') ?></label>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control autonumber" data-a-sep="." data-a-dec="," id="depreciationValue" name="depreciationValue" placeholder="" value="<?= ($inventory[0]->depreciation_value ?? '') ?>" />
                            <label for="depreciationValue"><?= lang('app.depreciation value') ?></label>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" readonly class="form-control" id="remainAge" placeholder="" />
                            <label for="remainAge"><?= lang('app.age') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Card body  -->
        </div> <!--/ Card finance -->
    </div> <!--/ Col-->
</div> <!--/ Row-->

<div class="row">
    <div class="col-12">
        <div class="card mb-6">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-tokenizer form-select" id="location" name="location" data-allow-clear="true" data-placeholder="<?= lang('app.selectCreate') ?>">
                                <option value="" <?= (isset($inventory[0]->location) && $inventory[0]->location == '' ? 'selected' : '') ?>></option>
                                <?php foreach ($selectLocation as $db) : ?>
                                    <option value="<?= $db->location ?>" <?= (isset($inventory[0]->location) && $inventory[0]->location == $db->location ? 'selected' : '') ?>><?= $db->location ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="location"><?= lang('app.location') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="employee" name="employee" data-allow-clear="true" data-placeholder="<?= lang('app.selectSearch') ?>">
                                <?php if ($employee1) : ?>
                                    <option value="<?= $employee1[0]->id ?>" selected><?= "{$employee1[0]->code} &ensp;&emsp; {$employee1[0]->name}" ?></option>
                                <?php endif ?>
                            </select>
                            <div id="error" class="invalid-feedback err_employee"></div>
                            <label for="employee"><?= lang('app.employee') ?></label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-100" id="notes" name="notes" placeholder=""><?= ($inventory[0]->notes ?? '') ?></textarea>
                            <label for="notes"><?= lang('app.notes') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Card body  -->

            <div class="card-footer">
                <div class="row w-100">
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.save by") ?> :</small>
                        <div class="form-text"><?= ($inventory[0]->saveBy ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.confirm by") ?> :</small>
                        <div class="form-text"><?= ($inventory[0]->confirmBy ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= $active_by ?> :</small>
                        <div class="form-text"><?= ($inventory[0]->activeBy ?? '') ?></div>
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
        </div> <!--/ End Card -->
    </div> <!--/ Col-->
</div> <!--/ Row-->
<?= form_close() ?>

<script>
    function countDepreciation() {
        document.getElementById('purchaseValue').value = document.getElementById('purchaseValue').value || '0,00';
        var purchaseValue = formatAmount(document.getElementById('purchaseValue').value, 'nol');
        var age = formatAmount(document.getElementById('age').value, 'nol');
        var depreciationValue = parseFloat(purchaseValue) / parseFloat(age);
        $('#depreciationValue').val(formatAmount(depreciationValue, 'rp'));
    }

    $("#groupAccount").change(function() {
        $("#age").val($(this).find(':selected').data('age'));
        $("#remainAge").val($("#remain").val() + " / " + $(this).find(':selected').data('age'));
    });

    $(document).ready(function() {
        $("#groupAccount").trigger("change");

        $('#branch').select2({
            ajax: {
                url: "/load/branch",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
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

        $('#employee').select2({
            ajax: {
                url: "/load/person",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        choose: '00010',
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
                $('#askDelete, #company, #region, #division, #code, #description, #category, #picture').removeClass('is-invalid');
                $('.err_askDelete, .err_company, .err_region, .err_division, .err_code, .err_description, .err_category, .err_picture').html('');
                if (response.error) {
                    handleFieldError('askDelete', response.error.askDelete);
                    handleFieldError('company', response.error.company);
                    handleFieldError('region', response.error.region);
                    handleFieldError('division', response.error.division);
                    handleFieldError('code', response.error.code);
                    handleFieldError('description', response.error.description);
                    handleFieldError('category', response.error.category);
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
</script>

<?= $this->endSection() ?>