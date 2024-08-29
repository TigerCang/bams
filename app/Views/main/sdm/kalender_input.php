<div class="modal fade" id="modal-input" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header <?= json('modal input') ?>">
                <h4 class="modal-title judul-modal"><?= ($t_modal ?? '') ?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <?= form_open('', ['class' => 'formmain']) ?>
            <?= csrf_field() ?>
            <div class="modal-body">
                <div class="row g-2">
                    <div class="col-6 col-md-4 col-lg-4 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="date" class="form-control" id="tanggalaw" name="tanggalaw" />
                            <label for="tanggalaw"><?= lang('app.dari') ?></label>
                            <div id="error" class="invalid-feedback errtanggalaw"></div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-4 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="date" class="form-control" id="tanggalak" name="tanggalak" />
                            <label for="tanggalak"><?= lang('app.ke') ?></label>
                        </div>
                    </div>
                    <div class="col-6 col-md-3 col-lg-3 mb-4">
                        <input type="checkbox" id="potong" name="potong" data-toggle="toggle" data-width="100%">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="deskripsi" name="deskripsi" placeholder="<?= lang('app.harus') ?>" />
                            <label for="deskripsi"><?= lang('app.deskripsi') ?></label>
                            <div id="error" class="invalid-feedback errdeskripsi"></div>
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

<script src="<?= base_url('libraries') ?>/cang/js/select2.js"></script>
<script>
    $('#modal-input').on('shown.bs.modal', function() {
        $('#potong').bootstrapToggle({
            onlabel: '<?= lang('app.potong cuti') ?>',
            offlabel: '<?= lang('app.no') ?>',
            onstyle: 'success',
        });
    });

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
                $('.btnsubmit').html('<?= json('submit') ?>');
            },
            success: function(response) {
                $('#tanggalaw, #deskripsi').removeClass('is-invalid');
                $('.errtanggalaw, .errdeskripsi').html('');
                if (response.error) {
                    handleFieldError('tanggalaw', response.error.tanggalaw);
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