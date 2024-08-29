<div class="modal fade" id="modal-lampiran" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header <?= lang('app.bgMlampir'); ?>">
                <h4 class="modal-title"><?= lang('app.titlegambarbiaya'); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <?= form_open('kaspindah/savelampir', ['class' => 'formlampiran']) ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-block">
                            <input type="hidden" readonly class="form-control" id="midunik" name="midunik" value="<?= $idunik; ?>">
                            <input type="hidden" class="form-control" id="totalv2" name="totalv2" value="<?= old('totalv2'); ?>" />

                            <div class="form-group row">
                                <label for="noakun2" class="col-sm-1 col-form-label"><?= lang('app.noakun'); ?></label>
                                <div class="col-sm-11">
                                    <select id="noakun2" class="js-example-data-ajax" name="noakun2">
                                        <option value="" selected="selected"><?= lang('app.pilihsr'); ?></option>
                                    </select>
                                    <div id="error" class="invalid-feedback d-block errnoakun2"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="total2" class="col-sm-1 col-form-label"><?= lang('app.total'); ?></label>
                                <div class="col-sm-4">
                                    <input type="text" harusisi class="form-control form-control-right autonumber" data-a-sep="." data-a-dec="," id="total2" name="total2" placeholder="<?= lang('app.harusisi'); ?>" value="<?= (old('mtotal')) ? old('mtotal') : ''; ?>" autocomplete="off" />
                                    <div id="error" class="invalid-feedback d-block errtotal2"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="catatan2" class="col-sm-1 col-form-label"><?= lang('app.catatan'); ?></label>
                                <div class="col-sm-11">
                                    <textarea class="form-control" rows="3" id="catatan2" name="catatan2"></textarea>
                                    <div id="error" class="invalid-feedback d-block errcatatan2"></div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn <?= lang('app.btnOk'); ?> btnok" name="attach"><?= lang('app.btn_Ok'); ?></button>
                        </div>
                    </div>
                </div>
            </div>
            <?= form_close() ?>

        </div>
    </div>
</div>

<script>
    $("#total2").change(function() {
        document.getElementById('totalv2').value = formatKosong(document.getElementById('total2').value)
    });

    $(document).ready(function() {
        $("#noakun2").select2({
            dropdownParent: $("#modal-lampiran"),
            ajax: {
                url: "/kaslangsung/akun",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term, // search term
                        awal: '6',
                    };
                },
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            },
            <?= lang("app.inputminimum"); ?>,
        });

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
                    $('.btnok').html('<?= lang('app.btn_Ok'); ?>');
                },
                success: function(response) {
                    if (response.error) {
                        if (response.error.mnoakun) {
                            $('#noakun2').addClass('is-invalid');
                            $('.errnoakun2').html(response.error.mnoakun);
                        } else {
                            $('#noakun2').removeClass('is-invalid');
                            $('.errnoakun2').html('');
                        }
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
                        datalampiran();
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

<script type="text/javascript" src="<?= base_url('libraries'); ?>/assets/pages/form-masking/form-mask.js"></script>
<script type="text/javascript" src="<?= base_url('libraries'); ?>/bower_components/select2/js/select2.full.min.js"></script>
<script type="text/javascript" src="<?= base_url('libraries'); ?>/assets/pages/advance-elements/select2-custom.js"></script>
<script type="text/javascript" src="<?= base_url('libraries'); ?>/bower_components/extra/js/modal.js"></script>
<link rel="stylesheet" type="text/css" href="<?= base_url('libraries'); ?>/bower_components/extra/css/modal.css">