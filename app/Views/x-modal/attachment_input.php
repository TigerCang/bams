<div class="modal fade" id="modal-input" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header <?= json('modal input') ?>">
                <h4 class="modal-title title-modal"><?= ($t_modal ?? '') ?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <?= form_open('', ['class' => 'form-attachment']) ?>
            <?= csrf_field() ?>
            <div class="modal-body">
                <input type="hidden" id="unique" name="unique" value="<?= $unique ?>" />
                <input type="hidden" id="object" name="object" value="<?= $object ?>" />
                <input type="hidden" id="skat" name="skat" value="<?= $ska ?>" />
                <div class="row g-2">
                    <div class="col-6 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-tokenizer form-select" id="categoryAttachment" name="categoryAttachment" data-allow-clear="true" data-placeholder="<?= lang('app.selectCreate') ?>">
                                <option value=""></option>
                                </option>
                                <?php foreach ($selectCategory as $db) : ?>
                                    <option value="<?= $db->category ?>"><?= $db->category ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="categoryAttachment"><?= lang('app.category') ?></label>
                            <div id="error" class="invalid-feedback err_categoryAttachment"></div>
                        </div>
                    </div>
                    <div class="col-6 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="keeperAttachment" name="keeperAttachment" />
                            <label for="keeperAttachment"><?= lang('app.keeper') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row g-2" <?= $sHid ?>>
                    <div class="col-6 col-md-3 col-lg-3 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="ska" name="ska">
                                <option value="SKA">SKA</option>
                                <option value="SKT">SKT</option>
                            </select>
                            <label for="ska"></label>
                        </div>
                    </div>
                    <div class="col-6 col-md-3 col-lg-3 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="levelAttachment" name="levelAttachment">
                                <option value="Utama">Utama</option>
                                <option value="Madya">Madya</option>
                            </select>
                            <label for="levelAttachment"></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="yearAttachment" name="yearAttachment" placeholder="<?= lang('app.reference year') ?>" />
                            <label for="yearAttachment"><?= lang('app.reference year') ?></label>
                        </div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="qualificationAttachment" name="qualificationAttachment" placeholder="<?= lang('app.qualification') ?>" />
                            <label for="qualificationAttachment"><?= lang('app.qualification') ?></label>
                            <div id="error" class="invalid-feedback err_qualificationAttachment"></div>
                        </div>
                    </div>
                    <div class="col-6 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-tokenizer form-select" id="associationAttachment" name="associationAttachment" data-allow-clear="true" data-placeholder="<?= lang('app.selectCreate') ?>">
                                <?php foreach ($selectAssociation as $db) : ?>
                                    <option value="<?= $db->association ?>"><?= $db->association ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="associationAttachment"><?= lang('app.association') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="registrationNumber" name="registrationNumber" placeholder="<?= lang('app.registration number') ?>" />
                            <label for="registrationNumber"><?= lang('app.registration number') ?></label>
                            <div id="error" class="invalid-feedback err_registrationNumber"></div>
                        </div>
                    </div>
                </div>
                <div class="row g-2" <?= $tHid ?>>
                    <div class="col-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="titleAttachment" name="titleAttachment" placeholder="<?= lang('app.required') ?>" />
                            <label for="titleAttachment"><?= lang('app.title') ?></label>
                            <div id="error" class="invalid-feedback err_titleAttachment"></div>
                        </div>
                    </div>
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="descriptionAttachment" name="descriptionAttachment" placeholder="<?= lang('app.required') ?>" />
                            <label for="descriptionAttachment"><?= lang('app.description') ?></label>
                            <div id="error" class="invalid-feedback err_descriptionAttachment"></div>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="date" class="form-control" id="startDate" name="startDate" />
                            <label for="startDate"><?= lang('app.start date') ?></label>
                            <div id="error" class="invalid-feedback err_startDate"></div>
                        </div>
                    </div>
                    <div class="col-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="date" class="form-control" id="endDate" name="endDate" />
                            <label for="endDate"><?= lang('app.end date') ?></label>
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="file" class="form-control" id="attachment" name="attachment" />
                        <div id="error" class="invalid-feedback err_attachment"></div>
                    </div>
                </div>
            </div> <!--/ Modal Body -->

            <div class="modal-footer">
                <div class="row w-100">
                    <div class="col-6"></div>
                    <div class="col-6 ms-auto text-end">
                        <button type="button" class="<?= json('btn submit') ?> btn-submit"><?= json('submit') ?></button>
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
    $('.btn-submit').click(function(e) {
        e.preventDefault();
        var form = $('.form-attachment')[0];
        var formData = new FormData(form);
        var getAction = $(this).val();
        var url = '/attachment/save';
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
                $('#categoryAttachment, #qualificationAttachment, #registrationNumber, #titleAttachment, #descriptionAttachment, #startDate, #attachment').removeClass('is-invalid');
                $('.err_categoryAttachment, .err_qualificationAttachment, .err_registrationNumber, .err_titleAttachment, .err_descriptionAttachment, .err_startDate, .err_attachment').html('');
                if (response.error) {
                    handleFieldError('categoryAttachment', response.error.categoryAttachment);
                    handleFieldError('qualificationAttachment', response.error.qualificationAttachment);
                    handleFieldError('registrationNumber', response.error.registrationNumber);
                    handleFieldError('titleAttachment', response.error.titleAttachment);
                    handleFieldError('descriptionAttachment', response.error.descriptionAttachment);
                    handleFieldError('startDate', response.error.startDate);
                    handleFieldError('attachment', response.error.attachment);
                } else {
                    callAttachment();
                    var alertHtml = `<div class="alert alert-success alert-dismissible fade show" role="alert">${response.message}</div>`;
                    $('#alertContainer4').html(alertHtml);
                    $('#modal-input').modal('hide');
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