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
                            <div class="col-12 col-md-9 col-lg-9 mb-2">
                                <div class="form-floating form-floating-outline">
                                    <select class="select2-non form-select" id="cost" name="cost" data-allow-clear="true" data-placeholder="<?= lang('app.selectSearch') ?>" onchange="clickCost()">
                                        <?php if ($cost1) : ?>
                                            <option value="<?= $cost1[0]->id ?>" selected><?= "{$cost1[0]->code} &ensp;&emsp; {$cost1[0]->name}" ?></option>
                                        <?php endif ?>
                                    </select>
                                    <div id="error" class="invalid-feedback err_cost"></div>
                                    <label for="cost"><?= lang('app.resources') ?></label>
                                </div>
                            </div>
                            <div class="col-12 col-md-3 col-lg-3 mb-2">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" readonly class="form-control" id="unit" name="unit" placeholder="" value="<?= ($item[0]->unit ?? '') ?>" />
                                    <label for="unit"><?= lang('app.unit') ?></label>
                                </div>
                            </div>
                            <div class="col-12 col-md-9 col-lg-9 mb-2">
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
                            <div class="col-12 col-md-3 col-lg-3 mb-2">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control autonumber" data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="price" name="price" placeholder="" value="<?= ($item[0]->price ?? '') ?>" />
                                    <label for="price"><?= lang('app.price') ?></label>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
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
                    </div> <!--/ End left init-->

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
                    </div> <!--/ End Picture -->
                </div> <!--/ End Init -->

                <div class="row">
                    <div class="col-12">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-100" id="notes" name="notes" placeholder=""><?= ($item[0]->notes ?? '') ?></textarea>
                            <label for="notes"><?= lang('app.notes') ?></label>
                        </div>
                    </div>
                </div> <!--/ End Notes -->
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
    function clickCost() {
        var getCost = $("#cost").val();
        $.ajax({
            type: "POST",
            url: "/show/unit",
            data: {
                cost: getCost,
            },
            dataType: "json",
            success: function(response) {
                $("#unit").val(response.unit);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    $('#modal-input').on('shown.bs.modal', function() {
        $('#cost').select2({
            dropdownParent: $('.modal'),
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
                $('#askDelete, #cost, #category, #picture').removeClass('is-invalid');
                $('.err_askDelete, .err_cost, .err_category, .err_picture').html('');
                if (response.error) {
                    handleFieldError('askDelete', response.error.askDelete);
                    handleFieldError('cost', response.error.cost);
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