<?= $this->extend($template == 'vertical' ? 'layouts/template-vertical' : 'layouts/template-horizontal') ?>
<?= $this->section('content') ?>

<?= form_open('', ['class' => 'form-budget']) ?>
<?= csrf_field() ?>
<input type="hidden" id="askAccess" name="askAccess" />
<div id="error" class="invalid-feedback alert alert-danger err_askAccess" role="alert"></div>
<div class="row g-2">
    <div class="col-12 col-md-12 col-lg-6">
        <div class="card mb-6">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-12 col-md-8 col-lg-8 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="company" name="company" <?= (isset($budget[0]->status) && $budget[0]->status >= '1' ? 'disabled' : '') ?>>
                                <?= companyOptions($company, $budget, thisUser()) ?>
                            </select>
                            <div id="error" class="invalid-feedback err_company"></div>
                            <label for="company"><?= lang('app.company') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="object" name="object" <?= (isset($budget[0]->status) && $budget[0]->status >= '1' ? 'disabled' : '') ?>>
                                <?= objectOptions($selectObject, '', thisUser(), $choice) ?>
                            </select>
                            <label for="object"><?= lang('app.object') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="region" name="region" <?= (isset($budget[0]->status) && $budget[0]->status >= '1' ? 'disabled' : '') ?>>
                                <?= regionOptions($region, $budget, thisUser()) ?>
                            </select>
                            <div id="error" class="invalid-feedback err_region"></div>
                            <label for="region"><?= lang('app.region') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="division" name="division" <?= (isset($budget[0]->status) && $budget[0]->status >= '1' ? 'disabled' : '') ?>>
                                <?= divisionOptions($division, $budget, thisUser()) ?>
                            </select>
                            <div id="error" class="invalid-feedback err_division"></div>
                            <label for="division"><?= lang('app.division') ?></label>
                        </div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="branch" name="branch" <?= (isset($budget[0]->status) && $budget[0]->status >= '1' ? 'disabled' : '') ?> data-allow-clear="true" data-placeholder="<?= lang('app.selectSearch') ?>" onchange="clickProject()">
                                <?php if ($object1) : ?>
                                    <option value="<?= $object1[0]->id ?>" selected><?= "{$object1[0]->code} &ensp;&emsp;" . ($budget[0]->object == 'project' ? $object1[0]->package_name : $object1[0]->name) ?></option>
                                <?php endif ?>
                            </select>
                            <div id="error" class="invalid-feedback err_branch"></div>
                            <label for="branch"><?= lang('app.project') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Card body  -->
        </div> <!--/ Card Company -->
    </div> <!--/ Column Left -->

    <div class="col-12 col-md-12 col-lg-6">
        <div class="card mb-6">
            <div class="card-body">
                <input type="hidden" id="unique" name="unique" value="<?= ($budget[0]->unique ?? '') ?>" />
                <input type="hidden" id="xObject" name="xObject" value="<?= ($budget[0]->object ?? '') ?>" />
                <input type="hidden" id="xSegment" name="xSegment" value="<?= ($budget[0]->segment_id ?? '') ?>" />
                <input type="hidden" id="category" name="category" />
                <div class="row g-2">
                    <div class="col-6">
                        <div class="form-floating form-floating-outline">
                            <input type="date" class="form-control" id="startDate" name="startDate" value="<?= ($budget[0]->date_start ?? '') ?>" />
                            <label for="startDate"><?= lang('app.start date'); ?></label>
                            <div id="error" class="invalid-feedback err_startDate"></div>
                        </div>
                    </div>
                    <div class="col-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="date" class="form-control" id="endDate" name="endDate" value="<?= ($budget[0]->date_end ?? '') ?>" />
                            <label for="endDate"><?= lang('app.end date'); ?></label>
                            <div id="error" class="invalid-feedback err_endDate"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" readonly id="documentNumber" name="documentNumber" placeholder="" value="<?= ($budget[0]->document_number ?? '') ?>" />
                            <label for="documentNumber"><?= lang('app.document number') ?></label>
                        </div>
                    </div>
                    <div class="col-4 col-md-2 col-lg-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" readonly id="revision" name="revision" placeholder="" value="<?= ($budget[0]->revision ?? '1.1') ?>" />
                            <label for="revision"><?= lang('app.revision') ?></label>
                        </div>
                    </div>
                    <div class="col-8 col-md-4 col-lg-4 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" readonly id="status" name="status" placeholder="" value="<?= labelBadge('cash', $budget[0]->status ?? '0')['text'] ?>" />
                            <label for="status"><?= lang('app.status') ?></label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="segment" name="segment" <?= (isset($budget[0]->status) && $budget[0]->status >= '1' ? 'disabled' : '') ?> data-placeholder="<?= lang('app.select-') ?>">
                                <!-- <option value="<= $object1[0]->id ?>" selected><= "{$object1[0]->code} &ensp;&emsp;" . ($budget[0]->object == 'project' ? $object1[0]->package_name : $object1[0]->name) ?></option> -->
                            </select>
                            <label for="segment"><?= lang('app.segment') ?></label>
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
                        <div class="btn-group" id="dropdown-icon">
                            <button type="button" class="<?= json('btn submit') ?> btn-submit dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" <?= $button['on'] ?>><?= json('submit') ?></button>
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

<div class="row" <?= $card['input'] ?>>
    <div class="col-12">
        <div class="card mb-6">
            <div class="card-body">
                <div id="alertContainer4" class="mt-2"></div>
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="cost" name="cost" data-allow-clear="true" data-placeholder="<?= lang('app.selectSearch') ?>"></select>
                            <div id="error" class="invalid-feedback err_cost"></div>
                            <label for="cost"><?= lang('app.cost') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-12 col-md-4 col-lg-4 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control autonumber" data-digit-after-decimal="4" data-a-sep="." data-a-dec="," id="quantity" name="quantity" placeholder="" onchange="countTotal()" />
                            <label for="quantity"><?= lang('app.quantity') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control autonumber" data-a-sep="." data-a-dec="," id="priceContract" name="priceContract" placeholder="" onchange="countTotal()" />
                            <label for="priceContract"><?= lang('app.price contract') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control autonumber" data-a-sep="." data-a-dec="," id="priceWork" name="priceWork" placeholder="" onchange="countTotal()" />
                            <label for="priceWork"><?= lang('app.price work') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="groupIndustry" name="groupIndustry">
                                <?php foreach ($selectIndustry as $db) : ?>
                                    <option value="<?= $db->name ?>"><?= lang('app.' . $db->name) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <label for="groupIndustry"><?= lang('app.group industry') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" readonly class="form-control autonumber" data-a-sep="." data-a-dec="," id="totalContract" name="totalContract" placeholder="" />
                            <label for="totalContract"><?= lang('app.total contract') ?></label>
                            <div id="error" class="invalid-feedback err_totalContract"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" readonly class="form-control autonumber" data-a-sep="." data-a-dec="," id="totalWork" name="totalWork" placeholder="" />
                            <label for="totalWork"><?= lang('app.total work') ?></label>
                            <div id="error" class="invalid-feedback err_totalWork"></div>
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

<div class="row" <?= $card['acc'] ?>>
    <div class="col-12">
        <div class="card mb-6">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-4 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="sAction" name="sAction">
                                <?php foreach ($selectAction as $db) : ?>
                                    <option value="<?= $db->name ?>" <?= optionCondition($db->name) ?>><?= lang('app.' . $db->name) ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="sAction"><?= lang('app.action') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4 mb-2">
                        <input type="checkbox" id="create" name="create" data-toggle="toggle" data-width="100%" data-onlabel="<?= lang('app.more attention') ?>" data-offlabel="<?= lang('app.more attention') ?>" data-onstyle="warning" />
                    </div>
                    <div class="col-12">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-100" id="notesAcc" name="notesAcc" placeholder=""></textarea>
                            <label for="notesAcc"><?= lang('app.notes') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Card body  -->

            <div class="card-footer">
                <div class="row w-100">
                    <div class="col-6"></div>
                    <div class="col-6 ms-auto text-end">
                        <button type="button" class="<?= json('btn submit') ?> btn-ok"><?= json('submit') ?></button>
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
    $("#company, #region, #division, #object, #segment").change(function() {
        if (this.id === 'company' || this.id === 'region' || this.id === 'division') {
            $('#branch').val(null).trigger('change');
            $('#segment').val(null).trigger('change');
        } else if (this.id === 'object') {
            $("#xObject").val($("#object").val());
        } else if (this.id === 'segment') {
            $("#xSegment").val($("#segment").val());
        }
    });

    function clickProject() {
        var getProject = $("#branch").val();
        var getSegment = "<?= $budget[0]->segment_id ?? '' ?>";
        $.ajax({
            type: "POST",
            url: "<?= $link ?>/outFocusProject",
            data: {
                project: getProject,
                segment: getSegment,
            },
            dataType: "json",
            success: function(response) {
                $("#category").val(response.categoryProject);
                $("#segment").html(response.segment);
                $("#segment").trigger('change');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    function countTotal() {
        document.getElementById('quantity').value = document.getElementById('quantity').value || '0,0000';
        document.getElementById('priceContract').value = document.getElementById('priceContract').value || '0,00';
        document.getElementById('priceWork').value = document.getElementById('priceWork').value || '0,00';

        var quantity = formatAmount(document.getElementById('quantity').value, 'nol');
        var priceContract = formatAmount(document.getElementById('priceContract').value, 'nol');
        var priceWork = formatAmount(document.getElementById('priceWork').value, 'nol');
        var totalContract = parseFloat(quantity) * parseFloat(priceContract);
        var totalWork = parseFloat(quantity) * parseFloat(priceWork);

        $('#totalContract').val(formatAmount(totalContract, 'rp'));
        $('#totalWork').val(formatAmount(totalWork, 'rp'));
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
        $("#object").trigger("change")
        $("#project").change();
        clickProject();

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
                        segment: $("#xSegment").val(),
                        category: $("#category").val(),
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
                $('#askAccess, #company, #region, #division, #branch, #cost, #totalContract, #totalWork').removeClass('is-invalid');
                $('.err_askAccess, .err_company, .err_region, .err_division, .err_branch, .err_cost, .err_totalContract, .err_totalWork').html('');
                if (response.error) {
                    handleFieldError('askAccess', response.error.askAccess);
                    handleFieldError('company', response.error.company);
                    handleFieldError('region', response.error.region);
                    handleFieldError('division', response.error.division);
                    handleFieldError('branch', response.error.branch);
                    handleFieldError('cost', response.error.cost);
                    handleFieldError('totalContract', response.error.totalContract);
                    handleFieldError('totalWork', response.error.totalWork);
                } else if (response.redirect) {
                    window.location.href = response.redirect;
                } else {
                    var alertHtml = `<div class="alert alert-success alert-dismissible fade show" role="alert">${response.message}</div>`;
                    $('#alertContainer4').html(alertHtml);
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
                    $('#cost').val(null).trigger('change');
                    $("#quantity, #priceContract, #priceWork, #totalContract, #totalWork, #notes").val('');
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
            askConfirmation("<?= lang('app.sure') ?>", "<?= lang('app.confirm cancel') ?>").then((result) => {
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