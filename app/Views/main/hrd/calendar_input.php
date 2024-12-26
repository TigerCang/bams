<div class="modal fade" id="modal-input" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header <?= json('modal input') ?>">
                <h4 class="modal-title title-modal"><?= ($t_modal ?? '') ?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <?= form_open('', ['class' => 'form-main']) ?>
            <?= csrf_field() ?>
            <div class="modal-body">
                <div class="row g-2">
                    <div class="col-6 col-md-4 col-lg-4 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="date" class="form-control" id="dateStart" name="dateStart" />
                            <label for="dateStart"><?= lang('app.from') ?></label>
                            <div id="error" class="invalid-feedback err_dateStart"></div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-4 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="date" class="form-control" id="dateEnd" name="dateEnd" />
                            <label for="dateEnd"><?= lang('app.to') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4 mb-2">
                        <input type="checkbox" id="cut" name="cut" data-toggle="toggle" data-width="100%" />
                    </div>
                    <div class="col-12">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="description" name="description" placeholder="<?= lang('app.required') ?>" />
                            <label for="description"><?= lang('app.description') ?></label>
                            <div id="error" class="invalid-feedback err_description"></div>
                        </div>
                    </div>
                </div>
            </div> <!--/ Modal Body -->

            <div class="modal-footer">
                <div class="row w-100">
                    <div class="col-12 ms-auto text-end">
                        <button type="button" class="<?= json('btn submit') ?> btn-submit"><?= json('submit') ?></button>
                    </div>
                </div>
            </div> <!--/ Modal Footer -->
            <?= form_close() ?>

        </div> <!--/ Modal Content -->
    </div> <!--/ Modal Dialog -->
</div> <!--/ Modal fade -->

<script src="<?= base_url('libraries') ?>/cang/js/select2.js"></script>
<script>
    $('#modal-input').on('shown.bs.modal', function() {
        $('#cut').bootstrapToggle({
            onlabel: '<?= lang('app.cut leave') ?>',
            offlabel: '<?= lang('app.cut leave') ?>',
            onstyle: 'danger',
        });
    });

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
                $('.btn-submit').html('<?= json('submit') ?>');
            },
            success: function(response) {
                $('#dateStart, #description').removeClass('is-invalid');
                $('.err_dateStart, .err_description').html('');
                if (response.error) {
                    handleFieldError('dateStart', response.error.dateStart);
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