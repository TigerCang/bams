<div class="modal fade" id="modal-lampiran" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header <?= lang('app.bgMinput') ?>">
                <h4 class="modal-title"><?= lang('app.ambilbarang') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <?= form_open_multipart('', ['class' => 'formbarang']) ?>
            <?= csrf_field() ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-block">
                            <div class="form-group row">
                                <label for="mbarang" class="col-sm-2 col-form-label"><?= lang('app.item') ?></label>
                                <div class="col-sm-10">
                                    <input type="text" harusisi class="form-control" id="mbarang" name="mbarang" placeholder="<?= lang('app.harusisi') ?>">
                                    <div class="invalid-feedback errmbarang"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="msatuan" class="col-sm-2 col-form-label"><?= lang('app.satuan') ?></label>
                                <div class="col-sm-2">
                                    <?= "<select id='msatuan' class='js-example-basic-single' name='msatuan'>";
                                    echo "<option value=''>" . lang('app.pilih-') . "</option>";
                                    foreach ($satuan as $db) :
                                        echo "<option value='{$db->nama}'>{$db->nama}</option>";
                                    endforeach;
                                    echo "</select>"; ?>
                                    <div id="error" class="invalid-feedback d-block errmsatuan"></div>
                                </div>
                            </div>
                        </div>
                        <!--  -->
                        <div class="modal-footer"><?= "<button type='submit' class='btn " . lang('app.btncOK') . " btnok'>" . lang('app.btnOK') . "</button>"; ?></div>
                    </div>
                </div>
            </div>
            <?= form_close() ?>

        </div>
    </div>
</div>

<link rel="stylesheet" type="text/css" href="<?= base_url('libraries') ?>/bower_components/extra/css/modal.css">
<script type="text/javascript" src="<?= base_url('libraries') ?>/assets/pages/advance-elements/select2-custom.js"></script>
<script>
    $(document).ready(function() {
        $('.btnok').click(function(e) {
            e.preventDefault();
            var form = $('.formbarang')[0];
            var formData = new FormData(form);
            var url = '/ambilbarang/saveatk';
            $.ajax({
                type: 'post',
                url: url,
                data: formData,
                enctype: "multipart/form-data",
                cache: false,
                processData: false,
                contentType: false,
                dataType: "json",
                beforeSend: function() {
                    $('.btnok').attr('disable', 'disabled');
                    $('.btnok').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('.btnok').removeAttr('disable', 'disabled');
                    $('.btnok').html('<?= lang('app.btnOK') ?>');
                },
                success: function(response) {
                    if (response.error) {
                        if (response.error.mbarang) {
                            $('#mbarang').addClass('is-invalid');
                            $('.errmbarang').html(response.error.mbarang);
                        } else {
                            $('#mbarang').removeClass('is-invalid');
                            $('.errmbarang').html('');
                        }
                        if (response.error.msatuan) {
                            $('#msatuan').addClass('is-invalid');
                            $('.errmsatuan').html(response.error.msatuan);
                        } else {
                            $('#msatuan').removeClass('is-invalid');
                            $('.errmsatuan').html('');
                        }
                    } else {
                        flashdata("success", response.sukses);
                        $('#modal-lampiran').modal('hide');
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