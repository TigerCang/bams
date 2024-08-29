<div class="modal fade" id="modal-lampiran" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header <?= json('modal input') ?>">
                <h4 class="modal-title judul-modal"><?= ($t_modal ?? '') ?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <?= form_open_multipart('', ['class' => 'formlampiran']) ?>
            <?= csrf_field() ?>
            <div class="modal-body">
                <input type="hidden" id="idunik" name="idunik" value="<?= $idunik ?>">
                <input type="hidden" id="param" name="param" value="<?= $param ?>">

                <div class="row g-2">
                    <div class="col-12 col-md-12 col-lg-7 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="judul" name="judul" placeholder="<?= lang('app.harus') ?>" />
                            <label for="judul"><?= lang('app.judul') ?></label>
                            <div id="error" class="invalid-feedback errjudul"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-5 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="date" class="form-control" id="tanggal" name="tanggal" />
                            <label for="tanggal"><?= lang('app.tanggal'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="deskripsi" name="deskripsi" placeholder="" />
                            <label for="deskripsi"><?= lang('app.deskripsi') ?></label>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <input type="file" class="form-control" id="lampiran" name="lampiran" />
                    <div id="error" class="invalid-feedback errlampiran"></div>
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

<script>
    $('.btnsubmit').click(function(e) {
        e.preventDefault();
        var form = $('.formlampiran')[0];
        var formData = new FormData(form);
        var url = '/lampiran/save';
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
                if (response.error) {
                    if (response.error.judul) {
                        $('#judul').addClass('is-invalid');
                        $('.errjudul').html(response.error.judul);
                    } else {
                        $('#judul').removeClass('is-invalid');
                        $('.errjudul').html('');
                    }
                    if (response.error.lampiran) {
                        $('#lampiran').addClass('is-invalid');
                        $('.errlampiran').html(response.error.lampiran);
                    } else {
                        $('#lampiran').removeClass('is-invalid');
                        $('.errlampiran').html('');
                    }
                } else {
                    flashdata("success", response.sukses);
                    $('#modal-lampiran').modal('hide');
                    dataLampiran();
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