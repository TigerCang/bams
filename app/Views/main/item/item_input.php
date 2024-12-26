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
                <input type="hidden" id="unique" name="unique" value="<?= ($item[0]->unique ?? '') ?>" />
                <input type="hidden" name="pictureName" value="<?= ($item[0]->picture ?? 'default.png') ?>" />
                <input type="hidden" id="askDelete" name="askDelete" />
                <div id="error" class="invalid-feedback alert alert-danger err_askDelete" role="alert"></div>
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-8">
                        <div class="row g-2">
                            <div class="col-12 col-md-6 col-lg-5 mb-2">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control text-uppercase item" id="code" name="code" <?= (isset($item[0]->adaptation[0]) && $item[0]->adaptation[0] == '1' ? 'readonly' : '') ?> placeholder="<?= lang('app.required') ?>" value="<?= ($item[0]->code ?? '') ?>" data-mask="aaaa-aaaa.9999" />
                                    <label for="code"><?= lang('app.code') ?></label>
                                    <div id="error" class="invalid-feedback err_code"></div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4 mb-2">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control" id="partNumber" name="partNumber" placeholder="" value="<?= ($item[0]->part_number ?? '') ?>" />
                                    <label for="partNumber"><?= lang('app.part number') ?></label>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3 mb-2">
                                <div class="form-floating form-floating-outline">
                                    <select class="select2-non form-select" id="unit" name="unit">
                                        <?php foreach ($unit as $db) : ?>
                                            <option value="<?= $db->name ?>" <?= (isset($item[0]->unit) && $item[0]->unit == $db->name ? 'selected' : '') ?>><?= $db->name ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <label for="unit"><?= lang('app.unit') ?></label>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control" id="description" name="description" placeholder="<?= lang('app.required') ?>" value="<?= ($item[0]->name ?? '') ?>" />
                                    <label for="description"><?= lang('app.description') ?></label>
                                    <div id="error" class="invalid-feedback err_description"></div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6 mb-2">
                                <div class="form-floating form-floating-outline">
                                    <select class="select2-tokenizer form-select" id="category" name="category" data-placeholder="<?= lang('app.selectCreate') ?>">
                                        <option value="" <?= (isset($item[0]->category) && $item[0]->category == '' ? 'selected' : '') ?>></option>
                                        <?php foreach ($category as $db) : ?>
                                            <option value="<?= $db->category ?>" <?= (isset($item[0]->category) && $item[0]->category == $db->category ? 'selected' : '') ?>><?= $db->category ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <div id="error" class="invalid-feedback err_category"></div>
                                    <label for="category"><?= lang('app.category') ?></label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6 mb-2">
                                <div class="form-floating form-floating-outline">
                                    <select class="select2-tokenizer form-select" id="brand" name="brand" data-allow-clear="true" data-placeholder="<?= lang('app.selectCreate') ?>">
                                        <option value="" <?= (isset($item[0]->brand) && $item[0]->brand == '' ? 'selected' : '') ?>></option>
                                        <?php foreach ($brand as $db) : ?>
                                            <option value="<?= $db->brand ?>" <?= (isset($item[0]->brand) && $item[0]->brand == $db->brand ? 'selected' : '') ?>><?= $db->brand ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <label for="brand"><?= lang('app.brand') ?></label>
                                </div>
                            </div>
                            <div class="col-6 col-md-6 col-lg-3 mb-2">
                                <div class="form-floating form-floating-outline">
                                    <input type="number" class="form-control" id="stockMin" name="stockMin" placeholder="" value="<?= $item[0]->min_stock ?? '0' ?>" min="0" max="100" />
                                    <label for="stockMin"><?= lang('app.stock min') ?></label>
                                </div>
                            </div>
                            <div class="col-6 col-md-6 col-lg-3 mb-2">
                                <input type="checkbox" id="serial" name="serial" data-toggle="toggle" data-width="100%" <?= (isset($item[0]->mode) && $item[0]->mode[0] == '1' ? 'checked' : '') ?> />
                            </div>
                            <div class="col-6 col-md-6 col-lg-3 mb-2">
                                <input type="checkbox" id="second" name="second" data-toggle="toggle" data-width="100%" <?= (isset($item[0]->mode) && $item[0]->mode[1] == '1' ? 'checked' : '') ?> />
                            </div>
                            <div class="col-6 col-md-6 col-lg-3 mb-2">
                                <input type="checkbox" id="stock" name="stock" data-toggle="toggle" data-width="100%" <?= (isset($item[0]->mode) && $item[0]->mode[2] == '1' ? 'checked' : '') ?> />
                            </div>
                        </div>
                        <div class="row" id="zAccount">
                            <div class="col-12 mt-2">
                                <div class="form-floating form-floating-outline">
                                    <select class="select2-non form-select" id="groupAccount" name="groupAccount">
                                        <?php foreach ($selectGroup as $db) : ?>
                                            <option value="<?= $db->id ?>" <?= (isset($item[0]->group_account) && $item[0]->group_account == $db->id ? 'selected' : '') ?>><?= $db->name ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <label for="groupAccount"><?= lang('app.group account') ?></label>
                                </div>
                            </div>
                        </div>
                    </div> <!--/ End Init left-->

                    <div class="col-12 col-md-12 col-lg-4">
                        <div class="row">
                            <div class="col-12 mb-2">
                                <img class="img-fluid img-preview" src="/assets/picture/item/<?= ($item ? $item[0]->picture : 'default.png') ?>">
                            </div>
                            <div class="col-12 mb-2">
                                <input type="file" class="form-control" id="picture" name="picture" onchange="previewImage()" />
                                <div id="error" class="invalid-feedback err_picture"></div>
                            </div>
                            <span><?= ($item[0]->picture ?? '') ?></span>
                        </div>
                    </div> <!--/ End picture -->
                </div> <!--/ End Init -->

                <div class="row">
                    <div class="col-12">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-100" id="notes" name="notes" placeholder=""><?= ($item[0]->notes ?? '') ?></textarea>
                            <label for="notes"><?= lang('app.notes') ?></label>
                        </div>
                    </div>
                </div> <!--/ End Notes-->
            </div> <!--/ Modal Body -->

            <div class="modal-footer">
                <div class="row w-100">
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.save by") ?> :</small>
                        <div class="form-text"><?= ($item[0]->saveBy ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.confirm by") ?> :</small>
                        <div class="form-text"><?= ($item[0]->confirmBy ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= $active_by ?> :</small>
                        <div class="form-text"><?= ($item[0]->activeBy ?? '') ?></div>
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

<script src="<?= base_url('libraries') ?>/cang/form-masking/form-mask.js"></script>
<script src="<?= base_url('libraries') ?>/cang/js/select2.js"></script>
<script src="<?= base_url('libraries') ?>/cang/js/extra.js"></script>
<script>
    $(document).ready(function() {
        $('#stock').change(function() {
            if ($(this).prop('checked')) {
                $('#zAccount').removeAttr('hidden');
            } else {
                $('#zAccount').attr('hidden', 'hidden');
            }
        });
    });

    function initializeBsToggle(selector, onLabel, offLabel, onStyle) {
        $(selector).bootstrapToggle({
            onlabel: onLabel,
            offlabel: offLabel,
            onstyle: onStyle
        });
    }

    $('#modal-input').on('shown.bs.modal', function() {
        initializeBsToggle('#serial', '<?= lang('app.serial') ?>', '<?= lang('app.serial') ?>', 'primary');
        initializeBsToggle('#second', '<?= lang('app.second') ?>', '<?= lang('app.second') ?>', 'warning');
        initializeBsToggle('#stock', '<?= lang('app.stock') ?>', '<?= lang('app.stock') ?>', 'success');
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
                $('#askDelete, #code, #description, #category, #picture').removeClass('is-invalid');
                $('.err_askDelete, .err_code, .err_description, .err_category, .err_picture').html('');
                if (response.error) {
                    handleFieldError('askDelete', response.error.askDelete);
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