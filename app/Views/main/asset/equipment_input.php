<?= $this->extend($template == 'vertical' ? 'layouts/template-vertical' : 'layouts/template-horizontal') ?>
<?= $this->section('content') ?>

<?= form_open('', ['class' => 'form-main']) ?>
<?= csrf_field() ?>
<div class="row">
    <div class="col-12 col-md-12 col-lg-8">
        <div class="card mb-6">
            <div class="card-body">
                <input type="hidden" id="unique" name="unique" value="<?= ($tool[0]->unique ?? '') ?>" />
                <input type="hidden" name="pictureName" value="<?= ($tool[0]->picture ?? 'default.png') ?>" />
                <input type="hidden" id="age" name="age" />
                <input type="hidden" id="remain" name="remain" value="<?= ($tool[0]->remain ?? '0') ?>" />
                <input type="hidden" id="askDelete" name="askDelete" />
                <div id="error" class="invalid-feedback alert alert-danger err_askDelete" role="alert"></div>
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control text-uppercase" id="code" name="code" <?= (isset($tool[0]->adaptation[0]) && $tool[0]->adaptation[0] == '1' ? 'readonly' : '') ?> placeholder="<?= lang('app.required') ?>" maxlength="10" value="<?= ($tool[0]->code ?? '') ?>" />
                            <label for="code"><?= lang('app.code') ?></label>
                            <div id="error" class="invalid-feedback err_code"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control text-uppercase" id="code2" name="code2" <?= ((isset($tool[0]->adaptation[0]) && $tool[0]->adaptation[0] == '1') ? (thisUser()['act_access'][8] == '1' ? '' : 'readonly') : '') ?> placeholder="<?= lang('app.required') ?>" maxlength="12" value="<?= ($tool[0]->code2 ?? '') ?>" />
                            <label for="code2"><?= lang('app.number') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="description" name="description" <?= ((isset($tool[0]->adaptation[0]) && $tool[0]->adaptation[0] == '1') ? (thisUser()['act_access'][8] == '1' ? '' : 'readonly') : '') ?> placeholder="<?= lang('app.required') ?>" value="<?= ($tool[0]->name ?? '') ?>" />
                            <label for="description"><?= lang('app.description') ?></label>
                            <div id="error" class="invalid-feedback err_description"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="model" name="model">
                                <?php foreach ($selectTool as $db) : ?>
                                    <option value="<?= $db->name ?>" <?= (isset($tool[0]->model) && $tool[0]->model == $db->name ? 'selected' : '') ?>><?= lang('app.' . $db->name) ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="model"><?= lang('app.model') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="brand" name="brand" placeholder="" value="<?= ($tool[0]->brand ?? '') ?>" />
                            <label for="brand"><?= lang('app.brand') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-tokenizer form-select" id="category" name="category" data-allow-clear="true" data-placeholder="<?= lang('app.selectCreate') ?>">
                                <option value="" <?= (isset($tool[0]->category) && $tool[0]->category == '' ? 'selected' : '') ?>></option>
                                <?php foreach ($selectCategory as $db) : ?>
                                    <option value="<?= $db->category ?>" <?= (isset($tool[0]->category) && $tool[0]->category == $db->category ? 'selected' : '') ?>><?= $db->category ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="category"><?= lang('app.category') ?></label>
                            <div id="error" class="invalid-feedback err_category"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-tokenizer form-select" id="type" name="type" data-allow-clear="true" data-placeholder="<?= lang('app.selectCreate') ?>">
                                <option value="" <?= (isset($tool[0]->type) && $tool[0]->type == '' ? 'selected' : '') ?>></option>
                                <?php foreach ($selectType as $db) : ?>
                                    <option value="<?= $db->type ?>" <?= (isset($tool[0]->type) && $tool[0]->type == $db->type ? 'selected' : '') ?>><?= $db->type ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="type"><?= lang('app.type') ?></label>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-4 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="date" class="form-control" id="manufactureDate" name="manufactureDate" value="<?= ($tool[0]->manufacture_date ?? '') ?>" />
                            <label for="manufactureDate"><?= lang('app.manufacture date') ?></label>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-4 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="date" class="form-control" id="registerDate" name="registerDate" value="<?= ($tool[0]->register_date ?? '') ?>" />
                            <label for="registerDate"><?= lang('app.register date') ?></label>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-4 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="date" class="form-control" id="departureDate" name="departureDate" value="<?= ($tool[0]->departure_date ?? '') ?>" />
                            <label for="departureDate"><?= lang('app.departure date') ?></label>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-4 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="number" step="0.01" class="form-control" id="indexFuel" name="indexFuel" placeholder="" value="<?= ($tool[0]->index_fuel ?? '0') ?>" min="0" max="100" />
                            <label for="indexFuel"><?= lang('app.index fuel') ?></label>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-4 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="number" step="0.01" class="form-control" id="weight" name="weight" placeholder="" value="<?= ($tool[0]->weight ?? '0') ?>" min="0" max="100" />
                            <label for="weight"><?= lang('app.weight') ?> (Ton)</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" readonly class="form-control" id="invoiceLink" name="invoiceLink" placeholder="" value="<?= ($tool[0]->invoice_link ?? '') ?>" />
                            <label for="invoiceLink"><?= lang('app.invoice link') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Card body  -->
        </div> <!--/ Card init -->

        <div class="card mb-6">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="groupAccount" name="groupAccount">
                                <?php foreach ($selectGroup as $db) : ?>
                                    <option value="<?= $db->id ?>" data-age="<?= formatComa($db->value, 0) ?>" <?= (isset($tool[0]->group_account) && $tool[0]->group_account == $db->id ? 'selected' : '') ?>><?= $db->name ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="groupAccount"><?= lang('app.group account') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="standard" name="standard" data-allow-clear="true" data-placeholder="<?= lang('app.select-') ?>">
                                <?php if ($standard1) : ?>
                                    <option value="<?= $standard1[0]->id ?>" selected><?= "{$standard1[0]->code} &ensp;&emsp; {$standard1[0]->name}" ?></option>
                                <?php endif ?>
                            </select>
                            <label for="standard"><?= lang('app.standard code') ?></label>
                        </div>
                    </div>
                    <div class="col-6 col-md-8 col-lg-8 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="invoice" name="invoice" placeholder="" value="<?= ($tool[0]->invoice ?? '') ?>" />
                            <label for="invoice"><?= lang('app.invoice') ?></label>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-4 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="date" class="form-control" id="purchaseDate" name="purchaseDate" value="<?= ($tool[0]->purchase_date ?? '') ?>" />
                            <label for="purchaseDate"><?= lang('app.date') ?></label>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-4 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control autonumber" data-a-sep="." data-a-dec="," id="purchaseValue" name="purchaseValue" placeholder="" value="<?= ($tool[0]->purchase_value ?? '') ?>" onchange="countDepreciation()" />
                            <label for="purchaseValue"><?= lang('app.purchase value') ?></label>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-4 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control autonumber" data-a-sep="." data-a-dec="," id="residualValue" name="residualValue" placeholder="" value="<?= ($tool[0]->residual_value ?? '') ?>" />
                            <label for="residualValue"><?= lang('app.residual value') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control autonumber" data-a-sep="." data-a-dec="," id="rentalValue" name="rentalValue" placeholder="" value="<?= ($tool[0]->rental_value ?? '') ?>" />
                            <label for="rentalValue"><?= lang('app.rental value') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="depreciationMode" name="depreciationMode">
                                <?php foreach ($selectDepreciation as $db) : ?>
                                    <option value="<?= $db->name ?>" <?= (isset($tool[0]->depreciation_mode) && $tool[0]->depreciation_mode == $db->name ? 'selected' : '') ?>><?= lang('app.' . $db->name) ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="depreciationMode"><?= lang('app.depreciation mode') ?></label>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control autonumber" data-a-sep="." data-a-dec="," id="depreciationValue" name="depreciationValue" placeholder="" value="<?= ($tool[0]->depreciation_value ?? '') ?>" />
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
    </div> <!--/ Column left -->

    <div class="col-12 col-md-12 col-lg-4">
        <div class="card mb-6">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 mb-2">
                        <img class="img-fluid img-preview" src="/assets/picture/tool/<?= ($tool ? $tool[0]->picture : 'default.png') ?>">
                    </div>
                    <div class="col-12 mb-2">
                        <input type="file" class="form-control" id="picture" name="picture" onchange="previewImage()" />
                        <div id="error" class="invalid-feedback err_picture"></div>
                    </div>
                    <span><?= ($tool[0]->picture ?? '') ?></span>
                </div>
            </div> <!--/ Card body  -->
        </div> <!--/ Card picture -->

        <div class="card mb-6">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="company" name="company" <?= (isset($tool[0]->adaptation[0]) && $tool[0]->adaptation[0] == '1' ? 'disabled' : '') ?>>
                                <?= companyOptions($company, $tool, thisUser()) ?>
                            </select>
                            <div id="error" class="invalid-feedback err_company"></div>
                            <label for="company"><?= lang('app.company') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="region" name="region" <?= (isset($tool[0]->adaptation[0]) && $tool[0]->adaptation[0] == '1' ? 'disabled' : '') ?>>
                                <?= regionOptions($region, $tool, thisUser()) ?>
                            </select>
                            <div id="error" class="invalid-feedback err_region"></div>
                            <label for="region"><?= lang('app.region') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="division" name="division" <?= (isset($tool[0]->adaptation[0]) && $tool[0]->adaptation[0] == '1' ? 'disabled' : '') ?>>
                                <?= divisionOptions($division, $tool, thisUser()) ?>
                            </select>
                            <div id="error" class="invalid-feedback err_division"></div>
                            <label for="division"><?= lang('app.division') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="companyInternal" name="companyInternal" data-allow-clear="true" data-placeholder="<?= lang('app.select-') ?>">
                                <?php foreach ($company as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (isset($tool[0]->company2_id) && $tool[0]->company2_id == $db->id ? 'selected' : '') ?>><?= "{$db->code} &ensp;&emsp; {$db->name}" ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="companyInternal"><?= lang('app.company internal') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Card body  -->
        </div> <!--/ Card company-->
    </div> <!--/ Column right -->
</div> <!--/ Row-->

<div class="row">
    <div class="col-12">
        <div class="card mb-6">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="employee" name="employee" data-allow-clear="true" data-placeholder="<?= lang('app.selectSearch') ?>">
                                <?php if ($employee1) : ?>
                                    <option value="<?= $employee1[0]->id ?>" selected><?= "{$employee1[0]->code} &ensp;&emsp; {$employee1[0]->name}" ?></option>
                                <?php endif ?>
                            </select>
                            <label for="employee"><?= lang('app.osm') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="cost" name="cost" data-allow-clear="true" data-placeholder="<?= lang('app.selectSearch') ?>">
                                <?php if ($cost1) : ?>
                                    <option value="<?= $cost1[0]->id ?>" selected><?= "{$cost1[0]->code} &ensp;&emsp; {$cost1[0]->name}" ?></option>
                                <?php endif ?>
                            </select>
                            <div id="error" class="invalid-feedback err_cost"></div>
                            <label for="cost"><?= lang('app.resources') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-100" id="machine" name="machine" placeholder=""><?= ($tool[0]->machine ?? '') ?></textarea>
                            <label for="machine"><?= lang('app.machine') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-100" id="transmission" name="transmission" placeholder=""><?= ($tool[0]->transmission ?? '') ?></textarea>
                            <label for="transmission"><?= lang('app.transmission') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-100" id="document" name="document" placeholder=""><?= ($tool[0]->document ?? '') ?></textarea>
                            <label for="document"><?= lang('app.document') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-100" id="notes" name="notes" placeholder=""><?= ($tool[0]->notes ?? '') ?></textarea>
                            <label for="notes"><?= lang('app.notes') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Card body  -->

            <div class="card-footer">
                <div class="row w-100">
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.save by") ?> :</small>
                        <div class="form-text"><?= ($tool[0]->saveBy ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.confirm by") ?> :</small>
                        <div class="form-text"><?= ($tool[0]->confirmBy ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= $active_by ?> :</small>
                        <div class="form-text"><?= ($tool[0]->activeBy ?? '') ?></div>
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
    </div> <!--/ End Col -->
</div> <!--/ End Row -->

<div class="row">
    <div class="col-12">
        <div class="card mb-6">
            <div class="card-header pb-0 mb-4">
                <div class="d-flex justify-content-between align-items-center row py-0 gap-3 gap-md-0">
                    <div class="col-4 col-md-9 col-lg-10">
                        <button type="button" class="<?= json('btn create') ?> input-attachment <?= ($tool ? '' : 'disabled') ?>" <?= (thisUser()['act_button'][0] == '0' ? 'disabled' : '') ?>><?= lang('app.btn add') ?></button>
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
        callAttachment();
        $("#groupAccount").trigger("change");
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

        $('#employee').select2({
            ajax: {
                url: "/load/person",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        choose: '00011',
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

        $('#cost').select2({
            ajax: {
                url: "/load/cost",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        param: 'resources',
                        segment: '0000',
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
                $('#askDelete, #company, #region, #division, #code, #description, #category, #cost, #picture').removeClass('is-invalid');
                $('.err_askDelete, .err_company, .err_region, .err_division, .err_code, .err_description, .err_category, .err_cost, .err_picture').html('');
                if (response.error) {
                    handleFieldError('askDelete', response.error.askDelete);
                    handleFieldError('company', response.error.company);
                    handleFieldError('region', response.error.region);
                    handleFieldError('division', response.error.division);
                    handleFieldError('code', response.error.code);
                    handleFieldError('description', response.error.description);
                    handleFieldError('category', response.error.category);
                    handleFieldError('cost', response.error.cost);
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

    $('.input-attachment').click(function(e) {
        e.preventDefault();
        var getUnique = $('#unique').val();
        $.ajax({
            url: "/attachment/modal",
            data: {
                unique: getUnique,
                object: 'equipment',
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
                object: 'equipment',
                table: 'm_tool',
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