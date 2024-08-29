<div class="modal fade" id="modal-input" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header <?= json('modal input') ?>">
                <h4 class="modal-title judul-modal"><?= ($t_modal ?? '') ?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <?= form_open('', ['class' => 'formmain']) ?>
            <?= csrf_field() ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="peminta" name="peminta" placeholder="<?= lang('app.harus') ?>" value="" />
                            <label for="peminta"><?= lang('app.peminta') ?></label>
                            <div id="error" class="invalid-feedback errpeminta"></div>
                        </div>
                    </div>
                </div>
            </div> <!--/ Modal Body -->

            <div class="modal-footer">
                <div class="row w-100">
                    <div class="col-12 ms-auto text-end">
                        <button type="button" class="<?= json('btn submit') ?> btnsubmit"><?= json('submit') ?></button>
                    </div>
                </div>
            </div> <!--/ Modal Footer -->
            <?= form_close() ?>

        </div> <!--/ Modal Content -->
    </div> <!--/ Modal Dialog -->
</div> <!--/ Modal fade -->

<script src="<?= base_url('libraries') ?>/cang/js/extra.js"></script>
<script>
    $('.btnsubmit').click(function(e) {
        e.preventDefault();
        var form = $('.formmain')[0];
        var formData = new FormData(form);
        var getAction = $(this).val();
        var url = '<?= $link ?>/save';
        formData.append('postaction', getAction);
        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            dataType: "json",
            beforeSend: function() {
                $('.btnsubmit').attr('disabled', 'disabled');
                $('.btnsubmit').html('<i class="ri-loader-5-line ri-spin ri-24px"></i>');
            },
            complete: function() {
                $('.btnsubmit').removeAttr('disabled');
                $('.btnsubmit').each(function() {
                    $(this).html('<?= json('submit') ?>');
                });
            },
            success: function(response) {
                if (response.error) {
                    if (response.error.peminta) {
                        $('#peminta').addClass('is-invalid');
                        $('.errpeminta').html(response.error.peminta);
                    } else {
                        $('#peminta').removeClass('is-invalid');
                        $('.errpeminta').html('');
                    }
                } else {
                    window.location.href = response.redirect;
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