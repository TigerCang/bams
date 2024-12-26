<?= $this->extend($template == 'vertical' ? 'layouts/template-vertical' : 'layouts/template-horizontal') ?>
<?= $this->section('content') ?>

<?= form_open('', ['class' => 'form-main']) ?>
<?= csrf_field() ?>
<div class="row">
    <div class="col-12">
        <div class="card mb-6">
            <div class="card-body">
                <input type="hidden" id="unique" name="unique" value="<?= ($budget[0]->unique ?? '') ?>" />
                <input type="hidden" id="start" name="start" />
                <input type="hidden" id="xSource" name="xSource" value="<?= ($budget[0]->source ?? '') ?>" />
                <input type="hidden" id="xObject" name="xObject" value="<?= ($budget[0]->object ?? '') ?>" />
                <input type="hidden" id="xType" name="xType" value="<?= ($budget[0]->type ?? '') ?>" />
                <input type="hidden" id="access" name="access" />
                <div id="error" class="invalid-feedback alert alert-danger err_access" role="alert"></div>
                <div class="row g-2">
                    <div class="col-12 col-md-4 col-lg-4 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="source" name="source" <?= (isset($budget[0]) ? 'disabled' : '') ?>>
                                <?php foreach ($selectSource as $db) : ?>
                                    <option value="<?= $db->name ?>" <?= (isset($budget[0]->source) && $budget[0]->source == $db->name ? 'selected' : '') ?>><?= lang('app.' . $db->name) ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="source"><?= lang('app.source') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="object" name="object" <?= (isset($budget[0]->adaptation[0]) && $budget[0]->adaptation[0] == '1' ? 'disabled' : '') ?>>
                                <?php foreach ($selectObject as $db) :
                                    if ($db->number <= 10) : ?>
                                        <option value="<?= $db->name ?>" <?= (isset($budget[0]->object) && $budget[0]->object == $db->name ? 'selected' : '') ?>><?= lang('app.' . $db->name) ?></option>
                                    <?php endif ?>
                                <?php endforeach ?>
                            </select>
                            <div id="error" class="invalid-feedback err_object"></div>
                            <label for="object"><?= lang('app.object') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4 mb-2" id="zType">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="type" name="type" data-placeholder="<?= lang('app.select-') ?>">
                                <?php foreach ($type as $db) : ?>
                                    <option value="<?= $db->code ?>" <?= (isset($budget[0]->type) && $budget[0]->type == $db->code ? 'selected' : '') ?>><?= $db->name ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="type"><?= lang('app.type') ?></label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="title" name="title" <?= (isset($budget[0]->adaptation[0]) && $budget[0]->adaptation[0] == '1' ? 'readonly' : '') ?> placeholder="<?= lang('app.required') ?>" value="<?= ($budget[0]->title ?? '') ?>" />
                            <label for="title"><?= lang('app.title') ?></label>
                            <div id="error" class="invalid-feedback err_title"></div>
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
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.confirm by") ?> :</small>
                        <div class="form-text"><?= ($budget[0]->confirmBy ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= $active_by ?> :</small>
                        <div class="form-text"><?= ($budget[0]->activeBy ?? '') ?></div>
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
    </div> <!--/ Column  -->
</div> <!--/ Row  -->

<div class="row">
    <div class="col-12">
        <div class="card mb-6">
            <div class="card-body">
                <div id="alertContainer"></div>
                <div id="flashMessage">
                    <?php if (session()->getFlashdata('message')):
                        echo json('alert success-1') . session()->getFlashdata('message') . "</div>";
                    endif ?>
                </div>
                <div class="row" id="zCost">
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
    $("#source, #object, #type").change(function() {
        if (this.id === 'source') {
            $("#xSource").val($(this).val());
            var chooseValue = $(this).val();
            document.getElementById('start').value = (chooseValue === 'income') ? '4,7' : '5,6,8';
        } else if (this.id === 'object') {
            $("#xObject").val($("#object").val());
            const isProject = document.getElementById('xObject').value === 'project';
            $('#zType, #zCost').attr('hidden', !isProject);
            $('#zAccount').attr('hidden', isProject);
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
                    console.log(response);
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
    });

    $('.btn-add').click(function(e) {
        e.preventDefault();
        var form = $('.form-main')[0];
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
                $('#access, #object, #title, #cost, #account, #total').removeClass('is-invalid');
                $('.err_access, .err_object, .err_title, .err_cost, .err_account, .err_total').html('');
                if (response.error) {
                    handleFieldError('access', response.error.access);
                    handleFieldError('object', response.error.object);
                    handleFieldError('title', response.error.title);
                    handleFieldError('cost', response.error.cost);
                    handleFieldError('account', response.error.account);
                    handleFieldError('total', response.error.total);
                } else if (response.redirect) {
                    window.location.href = response.redirect;
                } else if (response.message) {
                    var alertHtml = `<div class="alert alert-success alert-dismissible fade show" role="alert">${response.message}</div>`;
                    $('#alertContainer').html(alertHtml);
                    $('#flashMessage').html('');
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
                    $('#source, #type').attr('disabled', 'disabled');
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
</script>

<?= $this->endSection() ?>