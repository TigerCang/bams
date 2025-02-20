<?= $this->extend($template == 'vertical' ? 'layouts/template-vertical' : 'layouts/template-horizontal') ?>
<?= $this->section('content') ?>

<?= form_open('', ['class' => 'form-main']) ?>
<?= csrf_field() ?>
<div class="row">
    <div class="col-12 col-md-12 col-lg-8">
        <div class="card mb-6">
            <div class="card-body">
                <input type="hidden" id="unique" name="unique" value="<?= ($project[0]->unique ?? '') ?>" />
                <input type="hidden" id="askDelete" name="askDelete" />
                <div id="error" class="invalid-feedback alert alert-danger err_askDelete" role="alert"></div>
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control text-uppercase" id="code" name="code" <?= (isset($project[0]->adaptation[0]) && $project[0]->adaptation[0] == '1' ? 'readonly' : '') ?> placeholder="<?= lang('app.required') ?>" maxlength="10" value="<?= ($project[0]->code ?? '') ?>" />
                            <label for="code"><?= lang('app.code') ?></label>
                            <div id="error" class="invalid-feedback err_code"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="category" name="category">
                                <?php foreach ($category as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (isset($cost[0]->category_id) && $cost[0]->category_id == $db->id ? 'selected' : '') ?>><?= $db->name ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="category"><?= lang('app.category') ?></label>
                        </div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="projectName" name="projectName" <?= ((isset($project[0]->adaptation[0]) && $project[0]->adaptation[0] == '1') ? (thisUser()['act_access'][8] == '1' ? '' : 'readonly') : '') ?> placeholder="<?= lang('app.required') ?>" value="<?= ($project[0]->project_name ?? '') ?>" />
                            <label for="projectName"><?= lang('app.project name') ?></label>
                            <div id="error" class="invalid-feedback err_projectName"></div>
                        </div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="packageName" name="packageName" <?= ((isset($project[0]->adaptation[0]) && $project[0]->adaptation[0] == '1') ? (thisUser()['act_access'][8] == '1' ? '' : 'readonly') : '') ?> placeholder="<?= lang('app.required') ?>" value="<?= ($project[0]->package_name ?? '') ?>" />
                            <label for="packageName"><?= lang('app.package name') ?></label>
                            <div id="error" class="invalid-feedback err_packageName"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="onName" name="onName" placeholder="" value="<?= ($project[0]->on_name ?? '') ?>" />
                            <label for="onName"><?= lang('app.on name') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="location" name="location" placeholder="" value="<?= ($project[0]->location ?? '') ?>" />
                            <label for="location"><?= lang('app.location') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="owner" name="owner" placeholder="" value="<?= ($project[0]->owner ?? '') ?>" />
                            <label for="owner"><?= lang('app.owner') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="scope" name="scope" placeholder="" value="<?= ($project[0]->scope ?? '') ?>" />
                            <label for="scope"><?= lang('app.scope') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-tokenizer form-select" id="province" name="province" data-allow-clear="true" data-placeholder="<?= lang('app.selectCreate') ?>" onchange="loadDistrict()">
                                <option value="" <?= (isset($project[0]->province) && $project[0]->province == '' ? 'selected' : '') ?>></option>
                                <?php foreach ($province as $db) : ?>
                                    <option value="<?= $db->province ?>" <?= (isset($project[0]->province) && $project[0]->province == $db->province ? 'selected' : '') ?>><?= $db->province ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="province"><?= lang('app.province') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-tokenizer form-select" id="district" name="district" data-allow-clear="true" data-placeholder="<?= lang('app.selectCreate') ?>">
                                <option value="" <?= (isset($project[0]->district) && $project[0]->district == '' ? 'selected' : '') ?>></option>
                            </select>
                            <label for="district"><?= lang('app.district') ?></label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="payMethod" name="payMethod" placeholder="" value="<?= ($project[0]->pay_method ?? '') ?>" />
                            <label for="payMethod"><?= lang('app.pay method') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Card body  -->
        </div> <!--/ Card init -->

        <div class="card mb-6">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-6 col-md-4 col-lg-4 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="date" class="form-control" id="contractDate" name="contractDate" value="<?= ($project[0]->contract_date ?? '') ?>" />
                            <label for="contractDate"><?= lang('app.contract date') ?></label>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-4 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="date" class="form-control" id="phoDate" name="phoDate" value="<?= ($project[0]->pho_date ?? '') ?>" />
                            <label for="pho_date">PHO</label>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-4 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="date" class="form-control" id="fhoDate" name="fhoDate" value="<?= ($project[0]->fho_date ?? '') ?>" />
                            <label for="fho_date">FHO</label>
                        </div>
                    </div>
                    <div class="col-3 col-md-2 col-lg-2 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="number" class="form-control" id="period1" name="period1" placeholder="" value="<?= ($project[0]->period_1 ?? '0') ?>" min="2025" max="2100" />
                            <label for="period1"><?= lang('app.period') ?></label>
                        </div>
                    </div>
                    <div class="col-3 col-md-2 col-lg-2 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="number" class="form-control" id="period2" name="period2" placeholder="" value="<?= ($project[0]->period_2 ?? '0') ?>" min="2025" max="2100" />
                            <label for="period2"><?= lang('app.period') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-8 col-lg-8 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="standard" name="standard" data-allow-clear="true" data-placeholder="<?= lang('app.select-') ?>">
                                <?php if ($standard1) : ?> <option value="<?= $standard1[0]->id ?>" selected><?= "{$standard1[0]->code} &ensp;&emsp; {$standard1[0]->name}" ?></option><?php endif ?>
                            </select>
                            <label for="standard"><?= lang('app.standard code') ?></label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-100" id="finance" name="finance" placeholder=""><?= decrypt($project[0]->finance ?? '') ?></textarea>
                            <label for="finance"><?= lang('app.finance') ?></label>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/ Card date -->
    </div><!--/ Column left -->

    <div class="col-12 col-md-12 col-lg-4">
        <div class="card mb-6">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="company" name="company" <?= (isset($project[0]->adaptation[0]) && $project[0]->adaptation[0] == '1' ? 'disabled' : '') ?>>
                                <?= companyOptions($company, $project, thisUser()) ?>
                            </select>
                            <div id="error" class="invalid-feedback err_company"></div>
                            <label for="company"><?= lang('app.company') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="region" name="region" <?= ((isset($project[0]->adaptation[0]) && $project[0]->adaptation[0] == '1') ? (thisUser()['act_access'][8] == '1' ? '' : 'disabled') : '') ?>>
                                <?= regionOptions($region, $project, thisUser()) ?>
                            </select>
                            <div id="error" class="invalid-feedback err_region"></div>
                            <label for="region"><?= lang('app.region') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="division" name="division" <?= (isset($project[0]->adaptation[0]) && $project[0]->adaptation[0] == '1' ? 'disabled' : '') ?>>
                                <?= divisionOptions($division, $project, thisUser()) ?>
                            </select>
                            <div id="error" class="invalid-feedback err_division"></div>
                            <label for="division"><?= lang('app.division') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Card body  -->
        </div> <!--/ Card company-->

        <div class="card mb-6">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control autonumber" data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="contractValue" name="contractValue" placeholder="" value="<?= ($project[0]->contract_value ?? '') ?>" onchange="countVAT()" />
                            <label for="contractValue"><?= lang('app.contract value') ?></label>
                            <div id="error" class="invalid-feedback err_contractValue"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control autonumber" data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="additionalValue" name="additionalValue" placeholder="" value="<?= ($project[0]->additional_value ?? '') ?>" onchange="countVAT()" />
                            <label for="additionalValue"><?= lang('app.additional value') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control autonumber" data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="extraValue" name="extraValue" placeholder="" value="<?= ($project[0]->extra_value ?? '') ?>" onchange="countVAT()" />
                            <label for="extraValue"><?= lang('app.extra value') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" readonly class="form-control autonumber" data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="grossValue" name="grossValue" placeholder="" value="<?= ($project[0]->gross_value ?? '') ?>" />
                            <label for="grossValue"><?= lang('app.gross value') ?></label>
                        </div>
                    </div>
                    <div class="col-4 col-md-2 col-lg-4 mb-2">
                        <div class="form-group row">
                            <div class="form-floating form-floating-outline">
                                <input type="number" step="0.01" class="form-control" id="vat" name="vat" placeholder="" value="<?= ($project[0]->vat ?? '0') ?>" min="0" max="100" onchange="countVAT()" />
                                <label for="vat"><?= lang('app.vat') ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-8 col-md-4 col-lg-8 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control autonumber" data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="vatValue" name="vatValue" placeholder="" value="<?= ($project[0]->vat_value ?? '') ?>" onchange="countVAT2()" />
                            <label for="vatValue"><?= lang('app.vat value') ?></label>
                        </div>
                    </div>
                    <div class="col-4 col-md-2 col-lg-4 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="number" step="0.01" class="form-control" id="incomeTax" name="incomeTax" placeholder="" value="<?= ($project[0]->income_tax ?? '0') ?>" min="0" max="100" onchange="countVAT()" />
                            <label for="incomeTax"><?= lang('app.income tax') ?></label>
                        </div>
                    </div>
                    <div class="col-8 col-md-4 col-lg-8 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control autonumber" data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="incomeTaxValue" name="incomeTaxValue" placeholder="" value="<?= ($project[0]->income_tax_value ?? '') ?>" onchange="countVAT2()" />
                            <label for="incomeTaxValue"><?= lang('app.income tax value') ?></label>
                        </div>
                    </div>
                    <!-- <div class="col-0 col-md-6 col-lg-0"></div> -->
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="form-floating form-floating-outline">
                            <input type="text" readonly class="form-control autonumber" data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="netValue" name="netValue" placeholder="" value="<?= ($project[0]->net_value ?? '') ?>" />
                            <label for="netValue"><?= lang('app.net value') ?></label>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- End card -->
    </div> <!--/ Column Right -->
</div> <!--/ Row-->

<div class="row">
    <div class="col-12">
        <div class="card mb-6">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-100" id="consultant" name="consultant" placeholder=""><?= ($project[0]->consultant ?? '') ?></textarea>
                            <label for="consultant"><?= lang('app.consultant') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-100" id="insurance" name="insurance" placeholder=""><?= ($project[0]->insurance ?? '') ?></textarea>
                            <label for="insurance"><?= lang('app.insurance') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-100" id="implementation" name="implementation" placeholder=""><?= ($project[0]->implementation ?? '') ?></textarea>
                            <label for="implementation"><?= lang('app.implementation') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-100" id="notes" name="notes" placeholder=""><?= ($project[0]->notes ?? '') ?></textarea>
                            <label for="notes"><?= lang('app.notes') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Card body  -->

            <div class="card-footer">
                <div class="row w-100">
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.save by") ?> :</small>
                        <div class="form-text"><?= ($project[0]->saveBy ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.confirm by") ?> :</small>
                        <div class="form-text"><?= ($project[0]->confirmBy ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= $active_by ?> :</small>
                        <div class="form-text"><?= ($project[0]->activeBy ?? '') ?></div>
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
    </div>
</div> <!--/ Row-->

<div class="row">
    <div class="col-12">
        <div class="card mb-6">
            <div class="card-header pb-0 mb-4">
                <div class="d-flex justify-content-between align-items-center row py-0 gap-3 gap-md-0">
                    <div class="col-4 col-md-9 col-lg-10">
                        <button type="button" class="<?= json('btn create') ?> input-attachment <?= ($project ? '' : 'disabled') ?>" <?= (thisUser()['act_button'][0] == '0' ? 'disabled' : '') ?>><?= lang('app.btn add') ?></button>
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
    function countVAT() {
        document.getElementById('contractValue').value = document.getElementById('contractValue').value || '0,00';
        document.getElementById('vat').value = document.getElementById('vat').value || '0,00';
        document.getElementById('incomeTax').value = document.getElementById('incomeTax').value || '0,00';
        document.getElementById('additionalValue').value = document.getElementById('additionalValue').value || '0,00';
        document.getElementById('extraValue').value = document.getElementById('extraValue').value || '0,00';

        var contractValue = formatAmount(document.getElementById('contractValue').value, 'nol');
        var vatPercent = formatAmount(document.getElementById('vat').value, 'nol');
        var incomeTaxPercent = formatAmount(document.getElementById('incomeTax').value, 'nol');
        var additionalValue = formatAmount(document.getElementById('additionalValue').value, 'nol');
        var extraValue = formatAmount(document.getElementById('extraValue').value, 'nol');
        var grossValue = parseFloat(contractValue) + parseFloat(additionalValue) + parseFloat(extraValue);
        var vatValue = (parseFloat(grossValue) * parseFloat(vatPercent)) / (100 + parseFloat(vatPercent));
        var netValue = parseFloat(grossValue) - parseFloat(vatValue)
        var incomeTaxValue = parseFloat(incomeTaxPercent) / 100 * parseFloat(netValue)

        $('#grossValue').val(formatAmount(grossValue, 'rp'));
        $('#vatValue').val(formatAmount(vatValue, 'rp'));
        $('#netValue').val(formatAmount(netValue, 'rp'));
        $('#incomeTaxValue').val(formatAmount(incomeTaxValue, 'rp'));
    }

    function countVAT2() {
        document.getElementById('vatValue').value = document.getElementById('vatValue').value || '0,00';
        document.getElementById('incomeTaxValue').value = document.getElementById('incomeTaxValue').value || '0,00';
        var grossValue = formatAmount(document.getElementById('grossValue').value, 'nol');
        var vatValue = formatAmount(document.getElementById('vatValue').value, 'nol');
        var netValue = parseFloat(grossValue) - parseFloat(vatValue)
        $('#netValue').val(formatAmount(netValue, 'rp'));
    }

    function loadDistrict() {
        var getProvince = $("#province").val();
        var getDistrict = "<?= $project[0]->district ?? '' ?>";
        $.ajax({
            type: "POST",
            url: "<?= $link ?>/district",
            data: {
                province: getProvince,
                district: getDistrict
            },
            dataType: "json",
            success: function(response) {
                if (response.district) {
                    $("#district").html(response.district);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    $(document).ready(function() {
        loadDistrict();
        callAttachment();
        $('#standard').select2({
            ajax: {
                url: "/load/standard",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        param: 'code standard',
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
                $('#askDelete, #company, #region, #division, #code, #projectName, #packageName, #contractValue').removeClass('is-invalid');
                $('.err_askDelete, .err_company, .err_region, .err_division, .err_code, .err_projectName, .err_packageName, .err_contractValue').html('');
                if (response.error) {
                    handleFieldError('askDelete', response.error.askDelete);
                    handleFieldError('company', response.error.company);
                    handleFieldError('region', response.error.region);
                    handleFieldError('division', response.error.division);
                    handleFieldError('code', response.error.code);
                    handleFieldError('projectName', response.error.projectName);
                    handleFieldError('packageName', response.error.packageName);
                    handleFieldError('contractValue', response.error.contractValue);
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
                object: 'project',
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
                object: 'project',
                table: 'm_project',
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