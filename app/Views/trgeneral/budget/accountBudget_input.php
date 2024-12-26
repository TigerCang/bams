<?= $this->extend($template == 'vertical' ? 'layouts/template-vertical' : 'layouts/template-horizontal') ?>
<?= $this->section('content') ?>

<?= form_open('', ['class' => 'form-budget']) ?>
<?= csrf_field() ?>
<div class="row g-2">
    <div class="col-12 col-md-12 col-lg-6">
        <div class="card mb-6">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-subtext form-select" id="company" name="company" <?= (isset($budget[0]->status) && $budget[0]->status >= '1' ? 'disabled' : '') ?>>
                                <?= companyOptions($company, $budget, thisUser()) ?>
                            </select>
                            <div id="error" class="invalid-feedback err_company"></div>
                            <label for="company"><?= lang('app.company') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="region" name="region" <?= (isset($budget[0]->status) && $budget[0]->status >= '1' ? 'disabled' : '') ?>>
                                <?= regionOptions($region, $budget, thisUser()) ?>
                            </select>
                            <div id="error" class="invalid-feedback err_region"></div>
                            <label for="region"><?= lang('app.region') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="division" name="division" <?= (isset($budget[0]->status) && $budget[0]->status >= '1' ? 'disabled' : '') ?>>
                                <?= divisionOptions($division, $budget, thisUser()) ?>
                            </select>
                            <div id="error" class="invalid-feedback err_division"></div>
                            <label for="division"><?= lang('app.division') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="object" name="object" <?= (isset($budget[0]->status) && $budget[0]->status >= '1' ? 'disabled' : '') ?>>
                                <?php foreach ($selectObject as $db) : ?>
                                    <?php if (($choice == 'project' && $db->name == 'project') || ($choice == 'object' && $db->name != 'project')) : ?>
                                        <?php if ($db->number <= 10) : ?>
                                            <option value="<?= $db->name ?>" <?= (isset($budget[0]->object) && $budget[0]->object == $db->name ? 'selected' : '') ?>><?= lang('app.' . $db->name) ?></option>
                                        <?php endif ?>
                                    <?php endif ?>
                                <?php endforeach ?>
                            </select>
                            <label for="object"><?= lang('app.object') ?></label>
                        </div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-subtext form-select" id="branch" name="branch" <?= (isset($budget[0]->status) && $budget[0]->status >= '1' ? 'disabled' : '') ?> data-allow-clear="true" data-placeholder="<?= lang('app.selectSearch') ?>">
                                <?php if ($object1) : ?>
                                    <option value="<?= $object1[0]->id ?>" selected data-subtext="<?= ($budget[0]->object == 'project' ? $object1[0]->package_name : $object1[0]->name) ?>"><?= $object1[0]->code ?></option>
                                <?php endif ?>
                            </select>
                            <div id="error" class="invalid-feedback err_branch"></div>
                            <label for="branch" id="branchLabel"><?= lang('app.branch') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Card body  -->
        </div> <!--/ Card Company -->
    </div> <!--/ Column Left -->

    <div class="col-12 col-md-12 col-lg-6">
        <div class="card mb-6">
            <div class="card-body">
                <?php $rev = empty($budget[0]->revision) ? splitData('1.1', '.') : splitData($budget[0]->revision, '.'); ?>
                <input type="hidden" id="unique" name="unique" value="<?= ($budget[0]->unique ?? '') ?>" />
                <input type="hidden" id="start" name="start" />
                <input type="hidden" id="xSource" name="xSource" value="<?= ($budget[0]->source ?? '') ?>" />
                <input type="hidden" id="xObject" name="xObject" value="<?= ($budget[0]->object ?? '') ?>" />
                <input type="hidden" id="xType" name="xType" value="<?= ($budget[0]->type ?? '') ?>" />
                <input type="hidden" id="addendumNumber" name="addendumNumber" value="<?= ($rev[0]) ?>">
                <input type="hidden" id="revisionNumber" name="revisionNumber" value="<?= ($rev[1]) ?>">
                <div class="row g-2">
                    <div class="col-12 col-md-4 col-lg-4 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="source" name="source" <?= (isset($budget[0]) ? 'disabled' : '') ?>>
                                <?php foreach ($selectSource as $db) :
                                    if ($choice != 'project' || $db->name != 'income') : ?>
                                        <option value="<?= $db->name ?>" <?= (isset($budget[0]->source) && $budget[0]->source == $db->name ? 'selected' : '') ?>><?= lang('app.' . $db->name) ?></option>
                                    <?php endif ?>
                                <?php endforeach ?>
                            </select>
                            <label for="source"><?= lang('app.source') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-8 col-lg-8 mb-4" id="zType">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="type" name="type" data-placeholder="<?= lang('app.select-') ?>">
                                <?php foreach ($type as $db) : ?>
                                    <option value="<?= $db->code ?>" <?= (isset($budget[0]->type) && $budget[0]->type == $db->code ? 'selected' : '') ?>><?= $db->name ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="type"><?= lang('app.type') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="date" class="form-control" id="startDate" name="startDate" value="<?= ($budget[0]->date_start ?? '') ?>" />
                            <label for="startDate"><?= lang('app.start date'); ?></label>
                            <div id="error" class="invalid-feedback err_startDate"></div>
                        </div>
                    </div>
                    <div class="col-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="date" class="form-control" id="endDate" name="endDate" value="<?= ($budget[0]->date_end ?? '') ?>" />
                            <label for="endDate"><?= lang('app.end date'); ?></label>
                            <div id="error" class="invalid-feedback err_endDate"></div>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" readonly id="documentNumber" name="documentNumber" placeholder="" value="<?= ($budget[0]->document_number ?? '') ?>" />
                            <label for="documentNumber"><?= lang('app.document number') ?></label>
                        </div>
                    </div>
                    <div class="col-4 col-md-2 col-lg-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" readonly id="revision" name="revision" placeholder="" value="<?= $rev[0] . '.' . $rev[1] ?>" />
                            <label for="revision"><?= lang('app.revision') ?></label>
                        </div>
                    </div>
                    <div class="col-8 col-md-4 col-lg-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" readonly id="status" name="status" placeholder="" value="" />
                            <label for="status"><?= lang('app.status') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Card body  -->

            <div class="card-footer">
                <div class="row w-100">
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.save by") ?> :</small>
                        <div class="form-text"><?= ($budget[0]->saveBy ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-9 col-lg-9 ms-auto text-end">
                        <button type="button" class="<?= json('btn import') ?> btn-import"><?= json('import') ?></button>
                        <div class="btn-group" id="dropdown-icon" <?= $button['hidden'] ?>>
                            <button type="button" class="<?= json('btn submit') ?> btn-submit dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" <?= $button['disabled'] ?>><?= json('submit') ?></button>
                            <ul class="dropdown-menu">
                                <li><button type="button" name="action" value="save" class="dropdown-item d-flex align-items-center btn-save"><?= lang('app.btn save document') ?></button></li>
                                <li><button type="button" name="action" value="cancel" class="dropdown-item d-flex align-items-center btn-save"><?= lang('app.btn cancel document') ?></button></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div> <!--/ Card Footer -->
        </div> <!--/ Card Init -->
    </div> <!--/ Column Right -->
</div> <!--/ Row  -->

<div class="row">
    <div class="col-12">
        <div class="card mb-6">
            <div class="card-body">
                <div id="alertContainer" class="mt-2"></div>
                <div class="col-12 mb-4">
                    <div class="form-floating form-floating-outline">
                        <select class="select2-subtext form-select" id="cost" name="cost" data-allow-clear="true" data-placeholder="<?= lang('app.selectSearch') ?>"></select>
                        <div id="error" class="invalid-feedback err_cost"></div>
                        <label for="cost"><?= lang('app.cost') ?></label>
                    </div>
                </div>
            </div>
            <div class="row" id="zAccount">
                <div class="col-12 mb-4">
                    <div class="form-floating form-floating-outline">
                        <select class="select2-subtext form-select" id="account" name="account" data-allow-clear="true" data-placeholder="<?= lang('app.selectSearch') ?>"></select>
                        <div id="error" class="invalid-feedback err_account"></div>
                        <label for="account"><?= lang('app.account number') ?></label>
                    </div>
                </div>
            </div>
            <div class="row g-2">
                <div class="col-12 col-md-6 col-lg-3 mb-2">
                    <div class="form-floating form-floating-outline">
                        <input type="text" class="form-control autonumber" data-digit-after-decimal="0" data-a-sep="." data-a-dec="," id="month" name="month" placeholder="" onchange="countTotal()" />
                        <label for="month"><?= lang('app.month') ?></label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3 mb-2">
                    <div class="form-floating form-floating-outline">
                        <input type="text" class="form-control autonumber" data-digit-after-decimal="4" data-a-sep="." data-a-dec="," id="quantity" name="quantity" placeholder="" onchange="countTotal()" />
                        <label for="quantity"><?= lang('app.quantity') ?></label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3 mb-2">
                    <div class="form-floating form-floating-outline">
                        <input type="text" class="form-control autonumber" data-a-sep="." data-a-dec="," id="price" name="price" placeholder="" onchange="countTotal()" />
                        <label for="price"><?= lang('app.price') ?></label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3 mb-2">
                    <div class="form-floating form-floating-outline">
                        <input type="text" readonly class="form-control autonumber" data-a-sep="." data-a-dec="," id="total" name="total" placeholder="" />
                        <label for="total"><?= lang('app.total') ?></label>
                        <div id="error" class="invalid-feedback err_total"></div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating form-floating-outline">
                        <textarea class="form-control h-px-100" id="notes" name="notes" placeholder=""></textarea>
                        <label for="notes"><?= lang('app.notes') ?></label>
                    </div>
                </div>
            </div>
        </div> <!--/ Card body  -->

        <div class="card-footer">
            <div class="row w-100">
                <div class="col-6"></div>
                <div class="col-6 ms-auto text-end">
                    <button type="button" class="<?= json('btn submit') ?> btn-add"><?= lang('app.btn add') ?></button>
                </div>
            </div>
        </div> <!--/ Card Footer -->
    </div> <!--/ End Card -->
</div> <!--/ Column -->
</div> <!--/ Row-->
<?= form_close() ?>
<div class="modal-input" style="display: none;"></div>
<div class="card-datatable table-responsive viewTable"></div>

<script>
    let isPageLoaded;
    $("#company, #region, #division").change(function() {
        $('#branch').val(null).trigger('change');
    });

    $("#source, #object, #type").change(function() {
        if (this.id === 'source') {
            $("#xSource").val($(this).val());
            var chooseValue = $(this).val();
            document.getElementById('start').value = (chooseValue === 'income') ? '4' : '6';
        } else if (this.id === 'object') {
            $("#xObject").val($("#object").val());
            const isProject = document.getElementById('xObject').value === 'project';
            $('#zType, #zCost').attr('hidden', !isProject);
            $('#zAccount').attr('hidden', isProject);
            if (!isPageLoaded) $('#branch').val(null).trigger('change');
            isPageLoaded = false;
            var translations = {
                "project": "<?= lang('app.project') ?>",
                "branch": "<?= lang('app.branch') ?>",
                "equipment tool": "<?= lang('app.equipment tool') ?>",
                "land building": "<?= lang('app.land building') ?>"
            };
            var selectedValue = this.value;
            document.getElementById('branchLabel').innerText = translations[selectedValue] || "<?= lang('app.branch') ?>";
        } else if (this.id === 'type') {
            $("#xType").val($(this).val());
        }
    });

    function countTotal() {
        document.getElementById('month').value = document.getElementById('month').value || '0,00';
        document.getElementById('quantity').value = document.getElementById('quantity').value || '0,0000';
        document.getElementById('price').value = document.getElementById('price').value || '0,00';

        var month = formatAmount(document.getElementById('month').value, 'nol');
        var quantity = formatAmount(document.getElementById('quantity').value, 'nol');
        var price = formatAmount(document.getElementById('price').value, 'nol');
        var total = parseFloat(month) * parseFloat(quantity) * parseFloat(price);
        $('#total').val(formatAmount(total, 'rp'));
    }

    function tableBudget() {
        var getUnique = $("#unique").val();
        var getObject = $("#xObject").val();
        $.ajax({
            url: "<?= $link ?>/table",
            data: {
                unique: getUnique,
                object: getObject,
            },
            dataType: "json",
            success: function(response) {
                $('.viewTable').html(response.data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    $(document).ready(function() {
        isPageLoaded = true;
        tableBudget();
        $("#source, #object, #type").trigger("change")
        $('#account').select2({
            ajax: {
                url: "/load/account",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        start: $("#start").val(),
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

        $('#cost').select2({
            ajax: {
                url: "/load/cost",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        param: 'cost',
                        segment: '',
                        start: $("#xType").val().substring(0, 2),
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

        $('#branch').select2({
            ajax: {
                url: "/load/object",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    var getCompany = $("#company").val();
                    var getRegion = $("#region").val();
                    var getDivision = $("#division").val();
                    var getObject = $("#xObject").val();
                    return {
                        searchTerm: params.term,
                        company: getCompany,
                        region: getRegion,
                        division: getDivision,
                        object: getObject,
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

    $('.btn-add').click(function(e) {
        e.preventDefault();
        var form = $('.form-budget')[0];
        var formData = new FormData(form);
        var url = '<?= $link ?>/add';
        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            dataType: "json",
            beforeSend: function() {
                $('.btn-add').attr('disabled', 'disabled');
                $('.btn-add').html('<i class="ri-loader-5-line ri-spin ri-24px"></i>');
            },
            complete: function() {
                $('.btn-add').removeAttr('disabled');
                $('.btn-add').html("<?= lang('app.btn add') ?>");
            },
            success: function(response) {
                $('#company, #region, #division, #branch, #cost, #account, #total').removeClass('is-invalid');
                $('.err_company, .err_region, .err_division, .err_branch, .err_cost, .err_account, .err_total').html('');
                if (response.error) {
                    handleFieldError('company', response.error.company);
                    handleFieldError('region', response.error.region);
                    handleFieldError('division', response.error.division);
                    handleFieldError('branch', response.error.branch);
                    handleFieldError('cost', response.error.cost);
                    handleFieldError('account', response.error.account);
                    handleFieldError('total', response.error.total);
                } else if (response.redirect) {
                    window.location.href = response.redirect;
                } else {
                    var alertHtml = `
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        ${response.message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`;
                    $('#alertContainer').html(alertHtml);
                    clearElements();
                    tableBudget();
                }

                function handleFieldError(field, error) {
                    if (error) {
                        $('#' + field).addClass('is-invalid');
                        $('.err_' + field).html(error);
                    } else {
                        $('#' + field).removeClass('is-invalid');
                    }
                }

                function clearElements() {
                    $('#source').attr('disabled', 'disabled');
                    $('#cost, #account').val(null).trigger('change');
                    $("#month, #quantity, #price, #total, #notes").val('');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
        return false;
    })

    $('.btn-save').click(function(e) {
        e.preventDefault();
        var getAction = $(this).val();
        if (getAction === 'cancel') {
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
        var form = $('.form-budget')[0];
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
                $('#branch, #startDate, #endDate').removeClass('is-invalid');
                $('.err_branch, .err_startDate, .err_endDate').html('');
                if (response.error) {
                    handleFieldError('branch', response.error.branch);
                    handleFieldError('startDate', response.error.startDate);
                    handleFieldError('endDate', response.error.endDate);
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