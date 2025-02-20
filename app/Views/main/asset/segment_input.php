<?php [$bHid, $cHid, $sHid, $oHid, $dHid] = array_map(function ($hid) {
    return $hid == '1' ? '' : 'hidden';
}, str_split($bcsod)) ?>

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
                <input type="hidden" id="unique" name="unique" value="<?= ($distance[0]->unique ?? '') ?>" />
                <input type="hidden" id="codeSegment" name="codeSegment" />
                <div>
                    <input type="hidden" id="askDelete" name="askDelete" />
                    <div id="error" class="invalid-feedback alert alert-danger err_askDelete" role="alert"></div>
                </div>
                <div>
                    <input type="hidden" id="access" name="access" />
                    <div id="error" class="invalid-feedback alert alert-danger err_access" role="alert"></div>
                </div>
                <div class="row g-2">
                    <div class="col-12 mb-2" <?= $bHid ?>>
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="branch" name="branch" data-allow-clear="true" data-placeholder="<?= lang('app.selectSearch') ?>" <?= (isset($distance[0]->adaptation[0]) && $distance[0]->adaptation[0] == '1' ? 'disabled' : '') ?>>
                                <?php if ($branch1) : ?>
                                    <option value="<?= $branch1[0]->id ?>" selected><?= "{$branch1[0]->code} &ensp;&emsp; {$branch1[0]->name}" ?></option>
                                <?php endif ?>
                            </select>
                            <div id="error" class="invalid-feedback err_branch"></div>
                            <label for="branch"><?= lang('app.branch') ?></label>
                        </div>
                    </div>
                    <div class="col-12 mb-2" <?= $cHid ?>>
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="project" name="project" data-allow-clear="true" data-placeholder="<?= lang('app.selectSearch') ?>" <?= (isset($distance[0]->adaptation[0]) && $distance[0]->adaptation[0] == '1' ? 'disabled' : '') ?> onchange="clickProject()">
                                <?php if ($project1) : ?>
                                    <option value="<?= $project1[0]->id ?>" selected><?= "{$project1[0]->code} &ensp;&emsp; {$project1[0]->package_name}" ?></option>
                                <?php endif ?>
                            </select>
                            <div id="error" class="invalid-feedback err_project"></div>
                            <label for="project"><?= lang('app.project') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2" <?= $cHid ?>>
                        <div class="form-floating form-floating-outline">
                            <input type="text" readonly class="form-control" id="company" name="company" placeholder="" />
                            <label for="company"><?= lang('app.company') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2" <?= $cHid ?>>
                        <div class="form-floating form-floating-outline">
                            <input type="text" readonly class="form-control" id="region" name="region" placeholder="" />
                            <label for="region"><?= lang('app.region') ?></label>
                        </div>
                    </div>
                    <div class="col-12 mb-2" <?= $sHid ?>>
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="segment" name="segment" data-allow-clear="true" data-placeholder="<?= lang('app.select-') ?>" <?= (isset($distance[0]->adaptation[0]) && $distance[0]->adaptation[0] == '1' ? 'disabled' : '') ?>></select>
                            <div id="error" class="invalid-feedback err_segment"></div>
                            <label for="segment"><?= lang('app.segment') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" <?= (isset($distance[0]->adaptation[0]) && $distance[0]->adaptation[0] == '1' ? 'readonly' : '') ?> class="form-control text-uppercase" id="code" name="code" maxlength="<?= $length ?>" placeholder="<?= lang('app.required') ?>" value="<?= (isset($distance[0]) ? ($distance[0]->param == 'subsegment' ? substr($distance[0]->code, -3) : $distance[0]->code) : '') ?>" />
                            <label for="code"><?= lang('app.code') ?></label>
                            <div id="error" class="invalid-feedback err_code"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4 mb-2" <?= $oHid ?>>
                        <div class="form-floating form-floating-outline">
                            <input type="text" readonly class="form-control text-uppercase" id="code2" name="code2" placeholder="" value="<?= ($distance[0]->code ?? '') ?>" />
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4 mb-2" <?= $dHid ?>>
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control autonumber" data-a-sep="." data-a-dec="," id="distance" name="distance" placeholder="" value="<?= ($distance[0]->distance ?? '') ?>" />
                            <label for="distance"><?= lang('app.distance') . ' (Km)' ?></label>
                            <div id="error" class="invalid-feedback err_distance"></div>
                        </div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" <?= ((isset($company[0]->adaptation[0]) && $company[0]->adaptation[0] == '1') ? (thisUser()['act_access'][8] == '1' ? '' : 'readonly') : '') ?> class="form-control" id="description" name="description" placeholder="<?= lang('app.required') ?>" value="<?= ($distance[0]->name ?? '') ?>" />
                            <label for="description"><?= lang('app.description') ?></label>
                            <div id="error" class="invalid-feedback err_description"></div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-100" id="notes" name="notes" placeholder=""><?= ($distance[0]->notes ?? '') ?></textarea>
                            <label for="notes"><?= lang('app.notes') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Modal Body -->

            <div class="modal-footer">
                <div class="row w-100">
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.save by") ?> :</small>
                        <div class="form-text"><?= ($distance[0]->saveBy ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.confirm by") ?> :</small>
                        <div class="form-text"><?= ($distance[0]->confirmBy ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= $active_by ?> :</small>
                        <div class="form-text"><?= ($distance[0]->activeBy ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 ms-auto text-end">
                        <div class="btn-group" id="dropdown-icon"><?= $buttonHidden ?>
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

<script src="<?= base_url('libraries') ?>/cang/form-masking/form-mask.js"></script>
<script src="<?= base_url('libraries') ?>/cang/js/select2.js"></script>
<script src="<?= base_url('libraries') ?>/cang/js/extra.js"></script>
<script>
    $("#code").on("change", () => $("#code2").val($("#codeSegment").val() + '.' + $('#code').val()));
    $("#segment").change(function() {
        $('#codeSegment').val($('#segment').find(':selected').data('code'));
        $("#code2").val($("#codeSegment").val() + '.' + $('#code').val());
    });

    $(document).ready(function() {
        $("#project").change();
    });

    function clickProject() {
        var getProject = $("#project").val();
        // var getSegment = "<= $distance[0]->segment_id ?? '' ?>";
        $.ajax({
            type: "POST",
            url: "<?= $link ?>/outFocusProject",
            data: {
                project: getProject,
                // segment: getSegment,
                segment: '',
            },
            dataType: "json",
            success: function(response) {
                $("#company").val(response.company);
                $("#region").val(response.region);
                $("#segment").html(response.segment);
                $("#segment").trigger('change');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    $('.modal').on('shown.bs.modal', function() {
        $('#branch').select2({
            dropdownParent: $('.modal'),
            ajax: {
                url: "/load/branch",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        company: '',
                        region: '',
                        division: '',
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

        $('#project').select2({
            dropdownParent: $('.modal'),
            ajax: {
                url: "/load/project",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        company: '',
                        region: '',
                        division: '',
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
                $('#askDelete, #access, #branch, #project, #segment, #code, #distance, #description').removeClass('is-invalid');
                $('.err_askDelete, .err_access, .err_branch, .err_project, .err_segment, .err_code, .err_distance, .err_description').html('');
                if (response.error) {
                    handleFieldError('askDelete', response.error.askDelete);
                    handleFieldError('access', response.error.access);
                    handleFieldError('project', response.error.project);
                    handleFieldError('code', response.error.code);
                    handleFieldError('distance', response.error.distance);
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
    })
</script>