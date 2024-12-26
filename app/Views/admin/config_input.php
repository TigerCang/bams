<div class="modal fade" id="modal-input" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header <?= json('modal input') ?>">
                <h4 class="modal-title title-modal"><?= ($t_modal ?? '') ?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <?= form_open('', ['class' => 'form-main']) ?>
            <?= csrf_field() ?>
            <div class="modal-body">
                <input type="hidden" id="xParam" name="xParam" value="<?= $config[0]['param'] ?>" />
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" readonly class="form-control" id="param" name="param" placeholder="" value="<?= lang('app.' . $config[0]['param']) ?>" />
                        </div>
                    </div>
                </div>
                <div class="row" <?= ($config[0]['mode'] == 'A' ? '' : 'hidden') ?>>
                    <div class="col-6">
                        <div class="form-floating form-floating-outline">
                            <input type="number" class="form-control" id="level" name="level" placeholder="<?= lang('app.value') ?>" value="<?= $config[0]['value'] ?>" min="0" max="20" />
                            <label for="level"><?= lang('app.description') ?></label>
                            <div id="error" class="invalid-feedback err_level"></div>
                        </div>
                    </div>
                </div>
                <div class="row" <?= ($config[0]['mode'] == 'B' ? '' : 'hidden') ?>>
                    <div class="col-12">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="description" name="description" placeholder="<?= lang('app.description') ?>" value="<?= $config[0]['value'] ?>" />
                            <label for="description"><?= lang('app.description') ?></label>
                            <div id="error" class="invalid-feedback err_description"></div>
                        </div>
                    </div>
                </div>
            </div> <!--/ Modal Body -->

            <div class="modal-footer">
                <div class="row w-100">
                    <div class="col-6">
                        <small class="text-light fw-medium d-block"><?= lang("app.save by") ?> :</small>
                        <div class="form-text"><?= ($config[0]['user'] ?? '') ?></div>
                    </div>
                    <div class="col-6 ms-auto text-end">
                        <button type="button" class="<?= json('btn submit') ?> btn-submit"><?= json('submit') ?></button>
                    </div>
                </div>
            </div> <!--/ Modal Footer -->
            <?= form_close() ?>

        </div> <!--/ Modal Content -->
    </div> <!--/ Modal Dialog -->
</div> <!--/ Modal fade -->

<script src="<?= base_url('libraries') ?>/cang/js/extra.js"></script>
<script>
    $('.btn-submit').click(function(e) {
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
                $('#level, #description').removeClass('is-invalid');
                $('.err_level, .err_description').html('');
                if (response.error) {
                    handleFieldError('level', response.error.level);
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