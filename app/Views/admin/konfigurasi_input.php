<div class="modal fade" id="modal-input" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header <?= json('modal input') ?>">
                <h4 class="modal-title judul-modal"><?= ($t_modal ?? '') ?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <?= form_open('', ['class' => 'formmain']) ?>
            <div class="modal-body">
                <input type="hidden" id="idunik" name="idunik" value="<?= $konfigurasi[0]['idunik'] ?>" />
                <input type="hidden" id="xparam" name="xparam" value="<?= $konfigurasi[0]['param'] ?>" />

                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" readonly class="form-control" id="param" name="param" placeholder="" value="<?= lang('app.' . $konfigurasi[0]['param']) ?>" />
                        </div>
                    </div>
                </div>
                <div class="row" <?= ($konfigurasi[0]['mode'] == 'A' ? '' : 'hidden') ?>>
                    <div class="col-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="number" class="form-control" id="level" name="level" placeholder="<?= lang('app.nilai') ?>" value="<?= $konfigurasi[0]['nilai'] ?>" min="0" max="20" />
                            <label for="level"><?= lang('app.deskripsi') ?></label>
                            <div id="error" class="invalid-feedback errlevel"></div>
                        </div>
                    </div>
                </div>
                <div class="row" <?= ($konfigurasi[0]['mode'] == 'B' ? '' : 'hidden') ?>>
                    <div class="col-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="deskripsi" name="deskripsi" placeholder="<?= lang('app.deskripsi') ?>" value="<?= $konfigurasi[0]['nilai'] ?>" />
                            <label for="deskripsi"><?= lang('app.deskripsi') ?></label>
                            <div id="error" class="invalid-feedback errdeskripsi"></div>
                        </div>
                    </div>
                </div>
            </div> <!--/ Modal Body -->

            <div class="modal-footer">
                <div class="row w-100">
                    <div class="col-6">
                        <small class="text-light fw-medium d-block"><?= lang("app.saby") ?> :</small>
                        <div class="form-text"><?= ($konfigurasi[0]['saveby'] ?? '') ?></div>
                    </div>
                    <div class="col-6 ms-auto text-end">
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
                $('#level, #deskripsi').removeClass('is-invalid');
                $('.errlevel, .errdeskripsi').html('');
                if (response.error) {
                    handleFieldError('level', response.error.level);
                    handleFieldError('deskripsi', response.error.deskripsi);
                } else {
                    window.location.href = response.redirect;
                }

                function handleFieldError(field, error) {
                    if (error) {
                        $('#' + field).addClass('is-invalid');
                        $('.err' + field).html(error);
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