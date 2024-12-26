<?= $this->extend($template == 'vertical' ? 'layouts/template-vertical' : 'layouts/template-horizontal') ?>
<?= $this->section('content') ?>

<?= form_open('', ['class' => 'form-cash']) ?>
<?= csrf_field() ?>
<input type="hidden" id="askDoc" name="askDoc" />
<div id="error" class="invalid-feedback alert alert-danger err_askDoc" role="alert"></div>
<div class="row g-2">
    <div class="col-12 col-md-12 col-lg-6">
        <div class="card mb-6">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-subtext form-select" id="company" name="company" <?= (isset($cash[0]->status) && $cash[0]->status >= '1' ? 'disabled' : '') ?>>
                                <?= companyOptions($company, $cash, thisUser()) ?>
                            </select>
                            <div id="error" class="invalid-feedback err_company"></div>
                            <label for="company"><?= lang('app.company') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="region" name="region" <?= (isset($cash[0]->status) && $cash[0]->status >= '1' ? 'disabled' : '') ?>>
                                <?= regionOptions($region, $cash, thisUser()) ?>
                            </select>
                            <div id="error" class="invalid-feedback err_region"></div>
                            <label for="region"><?= lang('app.region') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="division" name="division" <?= (isset($cash[0]->status) && $cash[0]->status >= '1' ? 'disabled' : '') ?>>
                                <?= divisionOptions($division, $cash, thisUser()) ?>
                            </select>
                            <div id="error" class="invalid-feedback err_division"></div>
                            <label for="division"><?= lang('app.division') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="object" name="object" <?= (isset($cash[0]->status) && $cash[0]->status >= '1' ? 'disabled' : '') ?>>
                                <?php foreach ($selectObject as $db) : ?>
                                    <?php if ($db->number <= 10) : ?>
                                        <option value="<?= $db->name ?>" <?= (isset($cash[0]->object) && $cash[0]->object == $db->name ? 'selected' : '') ?>><?= lang('app.' . $db->name) ?></option>
                                    <?php endif ?>
                                <?php endforeach ?>
                            </select>
                            <label for="object"><?= lang('app.object') ?></label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-subtext form-select" id="branch" name="branch" <?= (isset($cash[0]->status) && $cash[0]->status >= '1' ? 'disabled' : '') ?> data-allow-clear="true" data-placeholder="<?= lang('app.selectSearch') ?>">
                                <?php if ($object1) : ?>
                                    <option value="<?= $object1[0]->id ?>" selected data-subtext="<?= ($cash[0]->object == 'project' ? $object1[0]->package_name : $object1[0]->name) ?>"><?= $object1[0]->code ?></option>
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
                <input type="hidden" id="unique" name="unique" value="<?= ($cash[0]->unique ?? '') ?>" />
                <input type="hidden" id="xObject" name="xObject" value="<?= ($cash[0]->object ?? 'project') ?>" />
                <div class="row g-2">
                    <div class="col-12 col-md-8 col-lg-8 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-subtext form-select" id="requester" name="requester" <?= (isset($cash[0]->status) && $cash[0]->status >= '1' ? 'disabled' : '') ?>>
                                <?php if ($requester1) : ?><option value="<?= $requester1[0]->id ?>" selected data-subtext="<?= $requester1[0]->employeeName ?>"><?= $requester1[0]->code ?></option><?php endif ?>
                            </select>
                            <div id="error" class="invalid-feedback err_requester"></div>
                            <label for="requester"><?= lang('app.requester') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="date" class="form-control" id="dateDay" name="dateDay" disabled value="<?= ($cash[0]->date_start ?? date('Y-m-d')) ?>" />
                            <label for="dateDay"><?= lang('app.date'); ?></label>
                        </div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-subtext form-select" id="person" name="person" <?= (isset($cash[0]->status) && $cash[0]->status >= '1' ? 'disabled' : '') ?> data-allow-clear="true" data-placeholder="<?= lang('app.selectSearch') ?>" onchange="clickPerson()">
                            </select>
                            <div id="error" class="invalid-feedback err_person"></div>
                            <label for="person"><?= lang('app.person') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" readonly id="documentNumber" name="documentNumber" placeholder="" value="<?= ($cash[0]->document_number ?? '') ?>" />
                            <label for="documentNumber"><?= lang('app.document number') ?></label>
                        </div>
                    </div>
                    <div class="col-4 col-md-2 col-lg-2 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" readonly id="revision" name="revision" placeholder="" value="1" />
                            <label for="revision"><?= lang('app.revision') ?></label>
                        </div>
                    </div>
                    <div class="col-8 col-md-4 col-lg-4 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" readonly id="status" name="status" placeholder="" value="<?= labelBadge('cash', $cash[0]->status ?? '0')['text'] ?>" />
                            <label for="status"><?= lang('app.status') ?></label>
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="file" class="form-control" id="attachment" name="attachment" />
                        <div id="error" class="invalid-feedback err_attachment"></div>
                    </div>
                    <span><?= ($cash[0]->attachment ?? '') ?></span>
                </div>
            </div> <!--/ Card body  -->

            <div class="card-footer">
                <div class="row w-100">
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.save by") ?> :</small>
                        <div class="form-text"><?= ($cash[0]->saveBy ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-9 col-lg-9 ms-auto text-end">
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
<div class="card-datatable table-responsive viewTable1"></div>

<div class="row">
    <div class="col-12">
        <div class="card mb-6">
            <div class="card-body">
                <div id="alertContainer" class="mt-2"></div>
                <div class="row g-2" id="zCost">
                    <div class="col-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-subtext form-select" id="segment" name="segment" data-allow-clear="true" data-placeholder="<?= lang('app.select-') ?>"></select>
                            <div id="error" class="invalid-feedback err_segment"></div>
                            <label for="segment"><?= lang('app.segment') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-subtext form-select" id="cost" name="cost" data-allow-clear="true" data-placeholder="<?= lang('app.select-') ?>"></select>
                            <div id="error" class="invalid-feedback err_cost"></div>
                            <label for="cost"><?= lang('app.cost') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-subtext form-select" id="resources" name="resources" data-allow-clear="true" data-placeholder="<?= lang('app.selectSearch') ?>"></select>
                            <div id="error" class="invalid-feedback err_resources"></div>
                            <label for="resources"><?= lang('app.resources') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row" id="zAccount">
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-subtext form-select" id="account" name="account" data-allow-clear="true" data-placeholder="<?= lang('app.select-') ?>"></select>
                            <div id="error" class="invalid-feedback err_account"></div>
                            <label for="account"><?= lang('app.account number') ?></label>
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
                            <input type="text" class="form-control autonumber" data-a-sep="." data-a-dec="," id="price" name="price" placeholder="" onchange="countTotal()" />
                            <label for="price"><?= lang('app.price') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4 mb-2">
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
    </div> <!--/ Column  -->
</div> <!--/ Row  -->
<?= form_close() ?>
<div class="card-datatable table-responsive viewTable2"></div>

<script>
    let isPageLoaded;
    $("#company, #region, #division").change(function() {
        $('#branch').val(null).trigger('change');
    });

    $("#object").change(function() {
        if (this.id === 'object') {
            $("#xObject").val($("#object").val());
            const isProject = document.getElementById('xObject').value === 'project';
            $('#zCost').attr('hidden', !isProject);
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
        }
    });

    function countTotal() {
        document.getElementById('quantity').value = document.getElementById('quantity').value || '0,0000';
        document.getElementById('price').value = document.getElementById('price').value || '0,00';
        var quantity = formatAmount(document.getElementById('quantity').value, 'nol');
        var price = formatAmount(document.getElementById('price').value, 'nol');
        var total = parseFloat(quantity) * parseFloat(price);
        $('#total').val(formatAmount(total, 'rp'));
    }

    function tableAdvancePayment() {
        var getUnique = $("#unique").val();
        var getObject = $("#xObject").val();
        $.ajax({
            url: "<?= $link ?>/table1",
            data: {
                unique: getUnique,
                object: getObject,
            },
            dataType: "json",
            success: function(response) {
                $('.viewTable1').html(response.data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    function tableCashChild() {
        var getUnique = $("#unique").val();
        var getObject = $("#xObject").val();
        $.ajax({
            url: "<?= $link ?>/table2",
            data: {
                unique: getUnique,
                object: getObject,
            },
            dataType: "json",
            success: function(response) {
                $('.viewTable2').html(response.data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    $(document).ready(function() {
        isPageLoaded = true;
        tableAdvancePayment();
        tableCashChild();
        $("#object").trigger("change")
        $('#requester').select2({
            ajax: {
                url: "/load/user",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        employee: '1',
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

        $('#person').select2({
            ajax: {
                url: "/load/person",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        choose: '01110',
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

    function clickPerson() {
        var getPerson = $("#person").val();
        $.ajax({
            type: "POST",
            url: "/outfocus/person",
            data: {
                person: getPerson,
                choose: 'advance payment',
            },
            dataType: "json",
            success: function(response) {
                $("#account").html(response.account);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

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
        var form = $('.form-cash')[0];
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
                $('#askDoc, #company, #company, #region, #division, #branch, #requester, #person, #attachment, #account, #total').removeClass('is-invalid');
                $('.err_askDoc, .err_company, .err_region, .err_division, .err_branch, .err_requester, .err_person, .err_attachment, .err_account, .err_total').html('');
                if (response.error) {
                    handleFieldError('askDoc', response.error.askDoc);
                    handleFieldError('company', response.error.company);
                    handleFieldError('region', response.error.region);
                    handleFieldError('division', response.error.division);
                    handleFieldError('branch', response.error.branch);
                    handleFieldError('requester', response.error.requester);
                    handleFieldError('person', response.error.person);
                    handleFieldError('attachment', response.error.attachment);
                    handleFieldError('account', response.error.account);
                    handleFieldError('total', response.error.total);
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