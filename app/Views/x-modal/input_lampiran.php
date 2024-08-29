<div class="modal fade" id="modal-lampiran" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header <?= lang('app.bgMinput') ?>">
                <h4 class="modal-title"><?= lang('app.lampir') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <?= form_open_multipart('', ['class' => 'formlampiran']) ?>
            <?= csrf_field() ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-block">
                            <input type="hidden" readonly class="form-control" id="idunik" name="idunik" value="<?= $idunik ?>">
                            <input type="hidden" readonly class="form-control" id="xpilih" name="xpilih" value="<?= $xpilih ?>">
                            <div class="form-group row">
                                <label for="judul" class="col-sm-2 col-form-label"><?= lang('app.judul') ?></label>
                                <div class="col-sm-10">
                                    <input type="text" harusisi class="form-control" id="judul" name="judul" placeholder="<?= lang('app.harusisi') ?>">
                                    <div class="invalid-feedback errJudul"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="deskripsi" class="col-sm-2 col-form-label"><?= lang('app.deskripsi') ?></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="deskripsi" name="deskripsi">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tanggal" class="col-sm-2 col-form-label"><?= lang('app.tanggal') ?></label>
                                <div class="col-sm-4">
                                    <input type="date" class="form-control" id="tanggal" name="tanggal">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="lampiran" class="col-sm-2 col-form-label"><?= lang('app.berkas') ?></label>
                                <div class="col-sm-10">
                                    <input type="file" harusisi class="form-control" id="lampiran" name="lampiran">
                                    <div class="invalid-feedback errlampiran"></div>
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

<script>
    $(document).ready(function() {
        $('.btnok').click(function(e) {
            e.preventDefault();
            var form = $('.formlampiran')[0];
            var formData = new FormData(form);
            var url = '/<?= $xpilih ?>/savelampir';
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
                        datalampiran();
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