<div class="modal fade" id="modal-lampiran" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header <?= lang('app.bgMlampir') ?>">
                <h4 class="modal-title"><?= lang('app.titlebayarpiut') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <?= form_open('kasnonlangsung/saveuangmuka', ['class' => 'formlampiran']) ?>
            <?= csrf_field() ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-block">
                            <input type="hidden" class="form-control" id="xidunik" name="xidunik" value="<?= $idunik ?>">
                            <input type="hidden" class="form-control" id="idkasinduk" name="idkasinduk" value="<?= $induk ?>">
                            <input type="hidden" class="form-control" id="idkasanak" name="idkasanak" value="<?= $anak ?>">
                            <input type="hidden" class="form-control" id="idakun" name="idakun" value="<?= $akun ?>">
                            <input type="hidden" class="form-control" id="xsisa" name="xsisa" value="<?= $sisa ?>">

                            <div class="form-group row">
                                <label for="mtotal" class="col-sm-1 col-form-label"><?= lang('app.total') ?></label>
                                <div class="col-sm-4">
                                    <input type="text" harusisi class="form-control form-control-right autonumber" data-a-sep="." data-a-dec="," id="total2" name="total2" placeholder="<?= lang('app.harusisi') ?>" value="<?= ((old('total2')) ? old('total2') : '') ?>" autocomplete="off" />
                                    <div id="error" class="invalid-feedback d-block errtotal2"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="catatan2" class="col-sm-1 col-form-label"><?= lang('app.catatan') ?></label>
                                <div class="col-sm-11">
                                    <textarea class="form-control" rows="3" id="catatan2" name="catatan2" placeholder="<?= lang('app.harusisi') ?>"></textarea>
                                    <div id="error" class="invalid-feedback d-block errcatatan2"></div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn <?= lang('app.btnOk') ?> btnok" name="attach"><?= lang('app.btn_Ok') ?></button>
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
        $('.formlampiran').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: 'post',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function() {
                    $('.btnok').attr('disable', 'disabled');
                    $('.btnok').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('.btnok').removeAttr('disable');
                    $('.btnok').html('<?= lang('app.btn_Ok') ?>');
                },
                success: function(response) {
                    if (response.error) {
                        if (response.error.mtotal) {
                            $('#total2').addClass('is-invalid');
                            $('.errtotal2').html(response.error.mtotal);
                        } else {
                            $('#total2').removeClass('is-invalid');
                            $('.errtotal2').html('');
                        }
                        if (response.error.mcatatan) {
                            $('#catatan2').addClass('is-invalid');
                            $('.errcatatan2').html(response.error.mcatatan);
                        } else {
                            $('#catatan2').removeClass('is-invalid');
                            $('.errcatatan2').html('');
                        }
                    } else {
                        flashdata(response.sukses, 'success', response.judul);
                        $('#modal-lampiran').modal('hide');
                        datauangmuka();
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText);
                    alert(thrownError);
                }
            });
        })
    });
</script>

<script type="text/javascript" src="<?= base_url('libraries') ?>/assets/pages/form-masking/form-mask.js"></script>
<script type="text/javascript" src="<?= base_url('libraries') ?>/bower_components/select2/js/select2.full.min.js"></script>
<script type="text/javascript" src="<?= base_url('libraries') ?>/assets/pages/advance-elements/select2-custom.js"></script>
<script type="text/javascript" src="<?= base_url('libraries') ?>/bower_components/extra/js/modal.js"></script>
<link rel="stylesheet" type="text/css" href="<?= base_url('libraries') ?>/bower_components/extra/css/modal.css">