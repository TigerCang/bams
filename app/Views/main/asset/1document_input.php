<div class="modal fade" id="modal-input" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header <?= json('modal input') ?>">
                <h4 class="modal-title title-modal"><?= ($t_modal ?? '') ?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <?= form_open('', ['class' => 'form-main']) ?>
            <?= csrf_field() ?>
            <div class="modal-body">
                <input type="hidden" id="unique" name="unique" value="<?= ($document[0]->unique ?? '') ?>" />
                <input type="hidden" id="access" name="access" />
                <div id="error" class="invalid-feedback alert alert-danger err_access" role="alert"></div>

                <div class="row g-2">
                    <div class="col-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="title" name="title" placeholder="<?= lang('app.required') ?>" value="<?= ($document[0]->title ?? '') ?>" />
                            <label for="title"><?= lang('app.title') ?></label>
                            <div id="error" class="invalid-feedback err_title"></div>
                        </div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-100" id="description" name="description" placeholder="<?= lang('app.required') ?>"><?= ($document[0]->name ?? '') ?></textarea>
                            <label for="description"><?= lang('app.description') ?></label>
                            <div id="error" class="invalid-feedback err_description"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-subtext form-select" id="company" name="company" <?= (isset($tool[0]->adaptation[0]) && $tool[0]->adaptation[0] == '1' ? 'disabled' : '') ?> data-allow-clear="true" data-placeholder="<?= lang('app.select-') ?>">
                                <?= companyOptions($company, $document, thisUser()) ?>
                            </select>
                            <label for="company"><?= lang('app.company') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="region" name="region" <?= (isset($tool[0]->adaptation[0]) && $tool[0]->adaptation[0] == '1' ? 'disabled' : '') ?> data-allow-clear="true" data-placeholder="<?= lang('app.select-') ?>">
                                <?= regionOptions($region, $document, thisUser()) ?>
                            </select>
                            <label for="region"><?= lang('app.region') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="division" name="division" <?= (isset($tool[0]->adaptation[0]) && $tool[0]->adaptation[0] == '1' ? 'disabled' : '') ?> data-allow-clear="true" data-placeholder="<?= lang('app.select-') ?>">
                                <?= divisionOptions($division, $document, thisUser()) ?>
                            </select>
                            <label for="division"><?= lang('app.division') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-3 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="object" name="object" <?= (isset($tool[0]->adaptation[0]) && $tool[0]->adaptation[0] == '1' ? 'disabled' : '') ?>>
                                <?php foreach ($selectObject as $db) : ?>
                                    <option value="<?= $db->name ?>" <?= (session()->getFlashdata('flash-object') == $db->name ? 'selected' : '') ?>><?= lang('app.' . $db->name) ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="object"><?= lang('app.object') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-8 col-lg-9 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="objectID" name="objectID" <?= (isset($tool[0]->adaptation[0]) && $tool[0]->adaptation[0] == '1' ? 'disabled' : '') ?> data-allow-clear="true" data-placeholder="<?= lang('app.selectSearch') ?>">
                            </select>
                            <label for="objectID"><?= lang('app.object') ?></label>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-3 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="date" class="form-control" id="startDate" name="startDate" value="<?= ($document[0]->start_date ?? '') ?>" />
                            <label for="startDate"><?= lang('app.start date') ?></label>
                            <div id="error" class="invalid-feedback err_startDate"></div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-3 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="date" class="form-control" id="endDate" name="endDate" value="<?= ($document[0]->end_date ?? '') ?>" />
                            <label for="endDate"><?= lang('app.end date') ?></label>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-6 mb-2">
                        <input type="file" class="form-control" id="attachment" name="attachment" />
                        <div id="error" class="invalid-feedback err_attachment"></div>
                    </div>
                </div>
            </div> <!--/ Modal Body -->

            <div class="modal-footer">
                <div class="row w-100">
                    <div class="col-12 col-md-3 col-lg-3 mb-2">
                        <small class="text-light fw-medium d-block"><?= lang("app.save by") ?> :</small>
                        <div class="form-text"><?= ($document[0]->saveBy ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-2">
                        <small class="text-light fw-medium d-block"><?= lang("app.confirm by") ?> :</small>
                        <div class="form-text"><?= ($document[0]->confirmBy ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-2">
                        <small class="text-light fw-medium d-block"><?= $active_by ?> :</small>
                        <div class="form-text"><?= ($document[0]->activeBy ?? '') ?></div>
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
    var suppressChangeEvent = false;

    function clickObject() {
        var getObject = $("#object").val();
        var getObjectID = $("#objectID").val();
        if (getObjectID) {
            $.ajax({
                type: "POST",
                url: "<?= $link ?>/outFocusObject",
                data: {
                    object: getObject,
                    objectID: getObjectID,
                },
                dataType: "json",
                success: function(response) {
                    suppressChangeEvent = true;
                    $("#company").val(response.company).trigger('change');
                    $("#region").val(response.region).trigger('change');
                    $("#division").val(response.division).trigger('change');
                    suppressChangeEvent = false;
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText);
                    alert(thrownError);
                }
            });
        }
    }

    $("#company, #region, #division, #object, #objectID").change(function() {
        var element = $(this).attr('id');
        if (!suppressChangeEvent) {
            if (element === 'objectID') {
                clickObject();
            } else {
                $('#objectID').val(null).trigger('change');
            }
        }
    });

    $('.modal').on('shown.bs.modal', function() {
        $('#objectID').select2({
            dropdownParent: $('.modal'),
            ajax: {
                url: "/load/object",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    var getObject = $("#object").val();
                    var getCompany = $("#company").val();
                    var getRegion = $("#region").val();
                    var getDivision = $("#division").val();
                    return {
                        searchTerm: params.term,
                        object: getObject,
                        choose: 'multi',
                        company: getCompany,
                        region: getRegion,
                        division: getDivision,
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
        var form = $('.form-main')[0];
        var formData = new FormData(form);
        var getAction = $(this).val();
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
                $('#access, #title, #description, #startDate, #attachment').removeClass('is-invalid');
                $('.err_access, .err_title, .err_description, .err_startDate, .err_attachment').html('');
                if (response.error) {
                    handleFieldError('access', response.error.access);
                    handleFieldError('title', response.error.title);
                    handleFieldError('description', response.error.description);
                    handleFieldError('attachment', response.error.attachment);
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
    })
</script>