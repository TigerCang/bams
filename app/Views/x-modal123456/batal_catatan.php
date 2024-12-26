<div class="modal fade" id="modal-lampiran" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header <?= lang('app.bgMbatal') ?>">
                <h4 class="modal-title"><?= lang('app.bataldata') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <?= form_open('', ['class' => 'formbatal']) ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-block">
                            <input type="hidden" class="form-control" id="idunik" name="idunik" value="<?= $anggaran[0]->idunik ?>">
                            <div class="form-group row">
                                <label for="mcatatan" class="col-sm-1 col-form-label"><?= lang('app.catatan') ?></label>
                                <div class="col-sm-11">
                                    <textarea harusisi class="form-control" rows="3" id="mcatatan" name="mcatatan" placeholder="<?= lang('app.harusisi') ?>"></textarea>
                                    <div class="invalid-feedback errcatatan"></div>
                                </div>
                            </div>
                        </div>
                        <!--  -->
                        <div class="modal-footer">
                            <button type="submit" class="btn <?= lang('app.btncOK') ?> btnok"><?= lang('app.btnOK') ?></button>
                        </div>
                    </div>
                </div>
            </div>
            <?= form_close() ?>

        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.btnok').click(function(e) {
            e.preventDefault();
            var form = $('.formbatal')[0];
            var formData = new FormData(form);
            var url = '/<?= $menu ?>/bataldoc';
            $.ajax({
                type: 'post',
                url: url,
                data: formData,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('.btnok').attr('disabled', 'disabled');
                    $('.btnok').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('.btnok').removeAttr('disabled');
                    $('.btnok').html('<?= lang('app.btnOK') ?>');
                },
                success: function(response) {
                    if (response.error) {
                        if (response.error.catatan) {
                            $('#mcatatan').addClass('is-invalid');
                            $('.errcatatan').html(response.error.catatan);
                        } else {
                            $('#mcatatan').removeClass('is-invalid');
                            $('.errcatatan').html('');
                        }
                    } else {
                        window.location.href = response.redirect;
                        // flashdata("success", response.sukses);
                        // $('#modal-lampiran').modal('hide');
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText);
                    alert(thrownError);
                }
            });
        });
    });
</script>